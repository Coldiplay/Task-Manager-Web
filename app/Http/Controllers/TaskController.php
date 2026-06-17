<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }


    public function index(Request $request, Project $project)
    {
        $user = $request->user();

        $query = $project->tasks();

        if ($user->role === 'manager' && $project->author_id !== $user->id) {
            abort(403, 'Вы не менеджер этого проекта');
        }

        if ($user->role === 'executor') {
            $assignee_task = Task::all()->firstWhere(['assignee_id' => $user->id]);
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
            ->paginate(10)->withQueryString() ; // get method can be used instead of paginate

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

    public function store(CreateTaskRequest $request, Project $project)
    {
        $validated = $request->validated();
        $task = $project->tasks()->create($validated);

        return redirect()->route('tasks.index', $project)->with('success', 'Задача успешно создана!');
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);
        return redirect()->route('task.show', [$task->project_id, $task])->with('success', 'Задача обновлена!');
    }

    public function destroy(DeleteTaskRequest $request, Task $task)
    {
        $project = $task->project;

        $task->delete();
        return redirect()->route('tasks.index', $project)->with('success', 'Задача удалена.');
    }

}
