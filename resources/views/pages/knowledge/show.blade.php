<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold">📋 QCM : {{ $test->language }}</h1>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto bg-white rounded-lg shadow">
        <p class="text-sm text-gray-500 mb-4">
            Généré le {{ $test->created_at->format('d/m/Y H:i') }}
        </p>

        @foreach($test->questions as $index => $question)
            <div class="mb-6">
                <p class="font-medium mb-2">{{ $index + 1 }}. {{ $question->question }}</p>

                @foreach($question->choices as $letter => $choice)
                    <div class="pl-4">
                        <span class="font-semibold">{{ $letter }}.</span> {{ $choice }}
                    </div>
                @endforeach

                <div x-data="{ show: false }" class="mt-2">
                    <button @click="show = !show"
                            class="text-sm text-indigo-600 hover:underline">
                        🎯 Afficher la réponse
                    </button>

                    <p x-show="show" x-transition class="mt-1 text-green-600 text-sm">
                        ✅ Réponse : <strong>{{ $question->correct_answer }}</strong>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
