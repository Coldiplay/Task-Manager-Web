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


    public function index(Request $request, project $project)
    {
        $user = $request->user();

        $query = $project->tasks();

        if ($user->role === 'manager' && $project->author_id !== $user->id) {
            abort(403, 'Вы не менеджер этого проекта');
        }

        if ($user->role === 'executor') {
            $assignee_task = task::all()->firstWhere(['assignee_id' => $user->id]);
            if ($assignee_task !== null)
            {
                $query->where('project_id', $assignee_task->project_id);
            }
        }

        // filters from url
        // Filter and sort by url parameters
        $tasks = $query->byStatus($request->query('status'))
            ->byPriority($request->query('priority'))
            ->byAssignee($request->query('assignee_id'))
            ->withSorting($request->query('sort_by'))//, $request->query('sort_order'))
            ->paginate(10); // get can be used

        return view('tasks.index', compact('project', 'tasks'));
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
