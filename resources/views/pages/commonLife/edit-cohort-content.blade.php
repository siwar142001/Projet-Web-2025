@extends('layouts.modal', [
    'id' => 'task-modal',
    'title' => 'Modifier la tâche',
])

@section('modal-content')
    <form id="edit_task_form" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="edit_title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="title" id="edit_title"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>

            <div>
                <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="edit_description" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Sauvegarder
            </button>
        </div>
    </form>
@endsection