@extends('layouts.app')

@section('content')
  <div class="container mt-5">
    <a href="{{ route('admin.projects.index') }}">Go back</a>

    @if ($project->image)
      <figure>
        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
      </figure>
    @endif

    <h1 class="mt-2">{{ $project->title }}</h1>
    <p>{{ $project->description }}</p>
    <p><b>Created at: </b>{{ $project->created_at }}</p>
    <p><b>Last update: </b>{{ $project->updated_at }}</p>
    <p><b>Type: </b>{{ $project->type?->label }}</p>
    <hr>

    <a class="btn btn-warning" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
    <form class="d-inline" method="POST" action="{{ route('admin.projects.destroy', $project) }}">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger">Delete</button>
    </form>

  </div>
@endsection
