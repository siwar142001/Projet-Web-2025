<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunalTask;

class CommunalTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $tasks = CommunalTask::all();
        return view('pages.commonLife.index', [
            'tasks' => $tasks
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CommunalTask::create($request->all());
        return redirect()->route('communal-tasks.index')->with('success', 'Tâche créée avec succès.');

    }

    public function edit($id)
    {
        $task = CommunalTask::findOrFail($id);
        return view('pages.commonLife.index', [
            'tasks' => CommunalTask::all(),
            'taskToEdit' => $task
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = CommunalTask::findOrFail($id);
        $task->update($request->only(['title', 'description']));

        return redirect()->route('communal-tasks.index')->with('success', 'Tâche mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id) {
        CommunalTask::findOrFail($id)->delete();
        return redirect()->route('communal-tasks.index')->with('success', 'Tâche supprimée.');
    }



    public function complete(Request $request, $id)
    {
        $task = CommunalTask::findOrFail($id);

        if ($task->completedBy->contains(auth()->id())) {
            return back()->with('error', 'Tâche déjà complétée.');
        }

        $request->validate([
            'comment_hidden' => 'required|string'
        ]);

        $task->completedBy()->attach(auth()->id(), [
            'comment' => $request->comment_hidden,
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Tâche validée avec succès !');
    }




    public function history()
    {
        $user = auth()->user();

        $tasks = $user->completedTasks()->withPivot('comment', 'completed_at')->get();

        return view('pages.commonLife.history', compact('tasks'));
    }









}
