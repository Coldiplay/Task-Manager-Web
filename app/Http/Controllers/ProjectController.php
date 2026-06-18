<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $projects = Project::latest()->paginate(10);
        } elseif ($user->role === 'manager') {
            $projects = Project::where('manager_id', $user->id)->latest()->paginate(10);
        } else {
            $projects = Project::whereHas('tasks', function($query) use ($user) {
                $query->where('assignee_id', $user->id);
            })->latest()->paginate(10);
        }
        $users = User::all();
        return view('project.index', compact('projects', 'users'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);
        return view('project.create');
    }

    public function store(CreateProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        Project::create($request->validated());
        return redirect()->route('project.index')
            ->with('success', 'Проект успешно создан!');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('project.show', compact('project'));
    }

//    public function edit(Project $project)
//    {
//        $this->authorize('update', $project);
//        return view('projects.edit', compact('project'));
//    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->validated());
        return redirect()->route('project.show', $project)
            ->with('success', 'Проект обновлен!');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('project.index')
            ->with('success', 'Проект удален.');
    }
}
