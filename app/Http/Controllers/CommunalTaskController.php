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



    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CommunalTask::create($request->all());
        return redirect()->route('communal-tasks.index')->with('success', 'Tâche créée avec succès.');

    }

    public function update($id) {
        $task = CommunalTask::findOrFail($id);
        return view('communal_tasks.edit', compact('task'));
    }

    public function edit(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = CommunalTask::findOrFail($id);
        $task->update($request->all());
        return redirect()->route('communal-tasks.index')->with('success', 'Tâche mise à jour.');
    }

    public function destroy($id) {
        CommunalTask::findOrFail($id)->delete();
        return redirect()->route('communal-tasks.index')->with('success', 'Tâche supprimée.');
    }
    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */






    /**
     * Remove the specified resource from storage.
     */

}
