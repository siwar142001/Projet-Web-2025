<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Vie Commune') }}
            </span>
        </h1>
    </x-slot>

    <div class="p-4 space-y-8">
        <!-- Formulaire de création de tâche -->
        <form action="{{ route('communal-tasks.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="title" id="title" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                       placeholder="Ex : Ménage cuisine">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                          placeholder="Détails de la tâche..."></textarea>
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Créer la tâche
                </button>
            </div>
        </form>

        <!-- Liste des tâches -->
        <div class="mt-10">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Tâches Communes</h2>

            @if($tasks->isEmpty())
                <p class="text-gray-500">Aucune tâche n’a encore été créée.</p>
            @else
                <ul class="space-y-4">
                    @foreach($tasks as $task)
                        <li class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-md font-bold text-gray-800">{{ $task->title }}</h3>
                                <span class="text-sm text-gray-500">Statut: {{ ucfirst($task->status ?? 'en attente') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">{{ $task->description }}</p>
                            <div class="mt-3 flex gap-2">
                                @if(auth()->user()->schools()->first()?->pivot->role === 'admin')
                                    <a href="{{ route('communal-tasks.edit', $task) }}"
                                       class="text-blue-600 hover:underline text-sm font-medium">Modifier</a>

                                    <form action="{{ route('communal-tasks.destroy', $task) }}" method="POST"
                                          onsubmit="return confirm('Es-tu sûr de vouloir supprimer cette tâche ?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline text-sm font-medium">Supprimer</button>
                                    </form>
                                @endif
                            </div>
                        </li>


                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
