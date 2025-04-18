<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold leading-tight text-gray-800">
            🕓 Historique des tâches accomplies
        </h2>
    </x-slot>

    <div class="p-4">
        @forelse ($tasks as $task)
            <div class="mb-4 p-4 border rounded shadow-sm bg-white">
                <h3 class="text-lg font-bold">{{ $task->title }}</h3>
                <p class="text-gray-600">{{ $task->description }}</p>
                <p class="text-sm text-green-600 mt-2">
                    ✅ Terminée le {{ \Carbon\Carbon::parse($task->pivot->completed_at)->format('d/m/Y H:i') }}
                </p>
                @if($task->pivot->comment)
                    <p class="mt-1 text-sm"> 💬 {{ $task->pivot->comment }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-600">Aucune tâche terminée pour l'instant.</p>
        @endforelse
    </div>
</x-app-layout>
