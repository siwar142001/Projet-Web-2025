<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\KnowledgeTest;
use App\Models\KnowledgeQuestion;

class KnowledgeController extends Controller
{
    /**
     * Display the page
     *
     * @return Factory|View|Application|object
     */



    public function index()
    {
        $tests = auth()->user()
            ->knowledgeTests()
            ->with('questions')
            ->latest()
            ->get();

        return view('pages.knowledge.index', compact('tests'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'languages' => 'required|array|min:1',
            'count' => 'required|integer|min:1|max:20',
        ]);

        $languages = $request->input('languages');
        $count = $request->input('count');

        foreach ($languages as $language) {
            // Construction dynamique du prompt
            $prompt = [
                [
                    "role" => "system",
                    "content" => "Tu es un assistant pédagogique expert en programmation."
                ],
                [
                    "role" => "user",
                    "content" => "Génère un QCM en français avec $count questions à choix multiples sur le langage $language.
Chaque question doit comporter :
- Un énoncé clair
- 4 propositions (A, B, C, D)
- Une seule bonne réponse

Réponds en format JSON strict comme ceci :

[
  {
    \"question\": \"Quelle est la syntaxe correcte pour créer une fonction en Python ?\",
    \"choix\": {
      \"A\": \"function maFonction()\",
      \"B\": \"def maFonction():\",
      \"C\": \"def maFonction():\",
      \"D\": \"create maFonctionn()\"
    },
    \"bonne_reponse\": \"B\"
  }
]"
                ]
            ];

            $response = Http::withToken(env('OPENAI_API_KEY')) // ⚠️ Remet ton token dans .env
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => $prompt,
                'temperature' => 0.7,
            ]);

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? null;

            try {
                $questions = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable $e) {
                return back()->with('error', 'Erreur lors du décodage du JSON généré par l’IA.');
            }

            // Création du test
            $test = KnowledgeTest::create([
                'user_id' => auth()->id(),
                'language' => $language,
            ]);

            // Enregistrement des questions
            foreach ($questions as $question) {
                KnowledgeQuestion::create([
                    'knowledge_test_id' => $test->id,
                    'question' => $question['question'],
                    'choices' => $question['choix'],
                    'bonne_reponse' => $question['bonne_reponse'],
                ]);
            }
        }

        return back()->with('success', 'Bilan généré et enregistré pour : ' . implode(', ', $languages));
    }


    public function show(KnowledgeTest $test)
    {
        $test->load('questions'); // Charger les questions liées

        return view('pages.knowledge.show', compact('test'));
    }
}
