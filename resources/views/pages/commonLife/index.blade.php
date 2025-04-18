<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal text-gray-700">
            {{ __('Vie Commune') }}
        </h1>
    </x-slot>

    <div class="p-4 space-y-8">
        <!-- Formulaire de création de tâche -->
        <form action="{{ route('communal-tasks.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="title" id="title" required
                       class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2"
                       placeholder="Ex : Ménage cuisine">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2"
                          placeholder="Détails de la tâche..."></textarea>
            </div>

            <div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-gray-800 text-gray-800 rounded-md hover:bg-gray-800 hover:text-white transition duration-200">
                    Créer la tâche
                </button>
            </div>
        </form>

        <!-- Liste des tâches -->
        <div class="mt-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Tâches Communes</h2>

                <a href="{{ route('communal-tasks.history') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-800 text-gray-800 rounded-md hover:bg-gray-800 hover:text-white transition duration-200">
                    🕓 Mon historique
                </a>
            </div>

            @if($tasks->isEmpty())
                <p class="text-gray-500">Aucune tâche n’a encore été créée.</p>
            @else
                <ul class="space-y-4">
                    @foreach($tasks as $task)
                        <li class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-md font-bold text-gray-800">{{ $task->title }}</h3>
                            </div>

                            <p class="text-sm text-gray-600 mt-2">{{ $task->description }}</p>

                            <div class="mt-3 flex gap-2">
                                @if(auth()->user()->schools()->first()?->pivot->role === 'admin')
                                    <button
                                            data-modal-toggle="#task-modal"
                                            data-user='@json($task)'
                                            onclick="openEditModal(this)"
                                            class="text-green-600 hover:text-green-800 text-sm font-medium">
                                        Modifier
                                    </button>

                                    <form action="{{ route('communal-tasks.destroy', $task) }}" method="POST"
                                          onsubmit="return confirm('Es-tu sûr de vouloir supprimer cette tâche ?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:underline text-sm font-medium">
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="bg-white shadow p-4 rounded mt-4">
                                @if (!$task->completedBy->contains(auth()->id()))
                                    <div x-data="{ open: false, comment: '' }">
                                        <button @click="open = !open"
                                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                            J’ai terminé
                                        </button>

                                        <form x-show="open" x-cloak method="POST"
                                              action="{{ route('communal-tasks.complete', $task->id) }}"
                                              class="mt-2 space-y-2">
                                            @csrf
                                            <textarea x-model="comment" name="comment" required
                                                      class="w-full border rounded p-2"
                                                      placeholder="Décris ce que tu as fait..."></textarea>

                                            <input type="hidden" name="comment_hidden" :value="comment">

                                            <button type="submit"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                                Valider
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-green-600 mt-2">
                                        Terminé par toi le {{ \Carbon\Carbon::parse($task->completed_at)->format('d/m/Y H:i') }}
                                        <ul class="mt-2 ml-4 text-sm text-gray-700 border border-gray-800 rounded p-2">
                                            <li class="font-semibold">Autres participants :</li>
                                            @foreach ($task->completedBy as $user)
                                                @if ($user->id !== auth()->id())
                                                    <li class="mt-1">
                                                        ✅ {{ $user->full_name }}
                                                        @if ($user->pivot->comment)
                                                            <br>
                                                            💬 {{ $user->pivot->comment }}
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <br>
                                        💬 Commentaire : {{ $task->completedBy->find(auth()->id())->pivot->comment }}
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>

@include('pages.commonLife.edit-cohort-content')

