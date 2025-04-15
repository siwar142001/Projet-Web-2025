@extends('layouts.modal')

@section('modal-id', 'edit-task-modal-' . $task->id)

@section('modal-title', 'Modifier la tÃ¢che')

@section('modal-content')
    <form action="{{ route('communal-tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="title" value="{{ $task->title }}"
                   class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4"
                      class="mt-1 w-full border rounded px-3 py-2">{{ $task->description }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <button type="button" data-modal-dismiss="true"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Annuler
            </button>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>
@endsection