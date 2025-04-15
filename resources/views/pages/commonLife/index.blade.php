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
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Tâches Communes     <a href="{{ route('communal-tasks.history') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">🕓 Historique</a></h2>


            </div>


            </div>


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
                                    <button
                                            data-modal="true"
                                            data-modal-target="edit-task-modal-{{ $task->id }}"
                                            class="text-blue-600 hover:underline text-sm font-medium">
                                        Modifier
                                    </button>

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



                            <div class="bg-white shadow p-4 rounded mb-4">

                                @if (!$task->completedBy->contains(auth()->id()))
                                    <div x-data="{ open: false, comment: '' }" class="mt-3">
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
                                        <br>
                                        <ul class="mt-2 ml-4 text-sm text-gray-700">
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


                        @include('pages.commonLife.edit-task-modal', ['task' => $task])









                    @endforeach



                        <div x-data="{ showModal: false, taskId: null, title: '', description: '' }">
                            <!-- Modal
                            <div x-show="showModal"
                                 x-transition
                                 x-cloak
                                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                                <div class="bg-white w-full max-w-md rounded-lg shadow p-6 relative">
                                    <h2 class="text-xl font-semibold mb-4">Modifier la tâche</h2>

                                    <form :action="'/communal-tasks/' + taskId" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="id" :value="taskId">

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Titre</label>
                                            <input type="text" name="title" x-model="title"
                                                   class="mt-1 w-full border rounded px-3 py-2" required>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="description" rows="4" x-model="description"
                                                      class="mt-1 w-full border rounded px-3 py-2"></textarea>
                                        </div>

                                        <div class="flex justify-end gap-2">
                                            <button type="button" @click="showModal = false"
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                Annuler
                                            </button>

                                            <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            -->

                            <!-- Script pour ouvrir la modal
                            <script>
                                function openModal(id, title, description) {
                                    const scope = document.querySelector('[x-data]');
                                    scope.__x.$data.showModal = true;
                                    scope.__x.$data.taskId = id;
                                    scope.__x.$data.title = title;
                                    scope.__x.$data.description = description;
                                }
                            </script>     -->
                        </div>

                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
