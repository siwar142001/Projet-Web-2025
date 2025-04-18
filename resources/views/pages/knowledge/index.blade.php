<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Bilans de connaissances') }}
            </span>
        </h1>
    </x-slot>

    {{-- 👇 Contenu principal de la page --}}
    <div class="py-6 px-4 mx-auto max-w-7xl">

        {{-- Si l'utilisateur est admin, on lui montre le formulaire --}}
        @if(auth()->user()->schools()->first()?->pivot->role === 'admin')
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">🎯 Générer un bilan de compétence</h2>

                <form action="{{ route('knowledge.generate') }}" method="POST">
                    @csrf

                    {{-- Langages à évaluer --}}
                    <div class="mb-4">
                        <label for="languages" class="block text-sm font-medium text-gray-700">Langages à évaluer</label>
                        <select name="languages[]" id="languages" multiple required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="PHP">PHP</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="Python">Python</option>
                            <option value="Java">Java</option>
                            <option value="C++">C++</option>
                        </select>
                        <small class="text-gray-500">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs.</small>
                    </div>

                    {{-- Nombre de questions --}}
                    <div class="mb-4">
                        <label for="count" class="block text-sm font-medium text-gray-700">Nombre de questions</label>
                        <input type="number" name="count" id="count" min="1" max="20" required
                               class="mt-1 block w-32 border-gray-300 rounded-md shadow-sm">
                    </div>

                    {{-- Bouton --}}
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 border border-transparent rounded-md bg-indigo-600 text-white shadow-md hover:bg-indigo-700 transition">
                        ⚙️ Générer le QCM
                    </button>
                </form>
            </div>
        @endif

        {{-- 🔽 Liste des bilans générés --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tests as $test)
                <a href="{{ route('knowledge.show', $test) }}"
                   class="block bg-white rounded-xl shadow p-4 border hover:shadow-lg transition">
                    <p class="text-sm text-gray-600 mb-1">Langage : <strong>{{ $test->language }}</strong></p>
                    <p class="text-xs text-gray-400">Créé le {{ $test->created_at->format('d/m/Y à H:i') }}</p>
                    <p class="text-xs mt-2 text-indigo-500">{{ $test->questions->count() }} question(s)</p>
                </a>
            @endforeach
        </div>

    </div>
</x-app-layout>
