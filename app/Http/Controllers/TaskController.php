<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $task);
        return view('task.show', compact('task'));
    }


    public function index(Request $request, Project $project)
    {
        $user = $request->user();

        $all_tasks = $project->tasks()->get();
        $query = $project->tasks()->getQuery();

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

        //sort fields for security
        $allowedSortFields = ['created_at', 'priority', 'due_date'];
        $sortBy = in_array($request->query('sort_by'), $allowedSortFields) ? $request->query('sort_by') : 'created_at';
        $sortOrder = strtolower($request->query('sort_order')) === 'desc' ? 'desc' : 'asc';
        // filters from url
        // Filter and sort by url parameters
        $tasks = $query
            ->when($user->role === 'executor', function ($query) use ($user) {
                $query->where('assignee_id', $user->id);
            }) //comment for debug, uncomment it in prod
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->query('priority'), function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($request->query('assignee_id'), function ($query, $assigneeId) {
                $query->where('assignee_id', $assigneeId);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->withQueryString();
        // get method can be used instead of paginate
        $users = User::all();
        return view('index', compact('project', 'tasks', 'all_tasks', 'users'));
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

        return redirect()->route('task.index', $project)
            ->with('success', 'Задача успешно создана!');
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);
        return redirect()->route('task.show', [$task->project_id, $task])
            ->with('success', 'Задача обновлена!');
    }

    public function destroy(DeleteTaskRequest $request, Task $task)
    {
        $project = $task->project;

        $task->delete();
        return redirect()->route('task.index', $project)
            ->with('success', 'Задача удалена.');
    }



    //Filters:
    //status filter
    public function byStatus(Builder $query, ?string $status): Builder
    {
        // Invoke when() only if $status is not empty
        return $query->when($status, function ($q) use ($status) {
            return $q->where('status', $status);
        });
    }

    //priority filter
    public function byPriority(Builder $query, ?string $priority): Builder
    {
        return $query->when($priority, function ($q) use ($priority) {
            return $q->where('priority', $priority);
        });
    }

    //assignee filter
    public function byAssignee(Builder $query, ?int $assigneeId): Builder
    {
        return $query->when($assigneeId, function ($q) use ($assigneeId) {
            return $q->where('assignee_id', $assigneeId);
        });
    }

    //sort
    public function withSorting(Builder $query, ?string $sortBy, ?string $direction = 'asc'): Builder
    {
        $allowedSortFields = ['created_at', 'priority', 'due_date'];

        //direction of sort
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        return $query->when(in_array($sortBy, $allowedSortFields), function ($q) use ($sortBy, $direction) {
            return $q->orderBy($sortBy, $direction);
        }, function ($q) {
            // If its get nothing, then sort by default
            return $q->orderBy('created_at', 'desc');
        });
    }

}
