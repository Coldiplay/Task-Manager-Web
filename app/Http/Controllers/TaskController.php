<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\project;
use App\Models\task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(project $project, task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }
//    public function GetTasks()
//    {
//        return task::all();
//    }
//    public function GetTask(int $id)
//    {
//        return task::all()->find(['id' => $id]);
//    }

    public function store(CreateTaskRequest $request, project $project)
    {
        $validated = $request->validated();
        $task = $project->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function update(UpdateTaskRequest $request, task $task)
    {
        $validated = $request->validated();

        $task->update($validated);
        return response()->json(['message' => 'Task updated successfully.', 'task' => $task]);
    }

    public function destroy(DeleteTaskRequest $request, task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully.']);
    }

}
