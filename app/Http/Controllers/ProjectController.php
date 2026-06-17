<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $projects = project::latest()->paginate(10);
        } elseif ($user->role === 'manager') {
            $projects = Project::where('manager_id', $user->id)->latest()->paginate(10);
        } else {
            $projects = Project::whereHas('tasks', function($query) use ($user) {
                $query->where('assignee_id', $user->id);
            })->latest()->paginate(10);
        }

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    public function store(CreateProjectRequest $request)
    {
        Project::create($request->validated());
        return redirect()->route('projects.index')->with('success', 'Проект успешно создан!');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

//    public function edit(Project $project)
//    {
//        $this->authorize('update', $project);
//        return view('projects.edit', compact('project'));
//    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.show', $project)->with('success', 'Проект обновлен!');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Проект удален.');
    }
}
