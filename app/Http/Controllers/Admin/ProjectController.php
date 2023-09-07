<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all()->sortByDesc('updated_at');
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:20',
                'description' => 'required|string',
                'image' => 'nullable|file',
                'type_id' => 'nullable|numeric',
                'technologies' => 'nullable|exists:technologies,id'
            ]
        );

        $data = $request->all();
        $project = new Project();

        if (array_key_exists('image', $data)) {
            $img_url = Storage::putFile('project_images', $data['image']);
            $data['image'] = $img_url;
        }

        $data['slug'] = Str::slug($data['title'], '-');
        $project->fill($data);
        $project->save();

        if (array_key_exists('technologies', $data)) {
            $project->technologies()->attach($data['technologies']);
        }

        return to_route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        $project_technology_ids = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technology_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate(
            [
                'title' => 'required|string|max:20',
                'description' => 'required|string',
                'image' => 'nullable|file',
                'type_id' => 'nullable|numeric',
                'technologies' => 'nullable|exists:technologies,id'
            ]
        );

        $data = $request->all();

        if (array_key_exists('image', $data)) {
            if ($project->image) Storage::delete($project->image);
            $img_url = Storage::putFile('project_images', $data['image']);
            $data['image'] = $img_url;
        }

        $data['slug'] = Str::slug($data['title'], '-');
        $project->update($data);

        if (!array_key_exists('technologies', $data) && count($project->technologies)) $project->technologies()->detach();
        elseif (array_key_exists('technologies', $data)) $project->technologies()->sync($data['technologies']);

        return to_route('admin.projects.show', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) Storage::delete($project->image);
        if (count($project->technologies)) $project->technologies()->detach();
        $project->delete();
        return to_route('admin.projects.index');
    }
}
