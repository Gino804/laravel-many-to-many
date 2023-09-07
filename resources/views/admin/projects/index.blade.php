@extends('layouts.app')

@section('content')
  <div class="container mt-5">
    <table class="table">
      <thead>
        <tr class="text-center">
          <th scope="col"></th>
          <th scope="col">Title</th>
          <th scope="col">Created at</th>
          <th scope="col">Last update</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($projects as $project)
          <tr class="text-center">
            <th scope="row">{{ $project->id }}</th>
            <td>{{ $project->title }}</td>
            <td>{{ $project->created_at }}</td>
            <td>{{ $project->updated_at }}</td>
            <td>
              <a class="btn btn-success" href="{{ route('admin.projects.show', $project) }}">See</a>
              <a class="btn btn-warning" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
              <form class="d-inline" method="POST" action="{{ route('admin.projects.destroy', $project) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-center" colspan="5">
              <h3>No projects available</h3>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
