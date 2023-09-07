@if ($project->exists)
  <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
    @method('PUT')
  @else
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
@endif

@csrf
<div class="row">
  <div class="col-6">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text"
        class="form-control @error('title') is-invalid @elseif(old('title')) is-valid @enderror"
        id="title" name="title" value="{{ old('title', $project->title) }}">
      @error('title')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>
  <div class="col-12">
    <div class="mb-3">
      <label for="surname" class="form-label">Description</label>
      <textarea class="form-control @error('description') is-invalid @elseif(old('description')) is-valid @enderror"
        id="description" name="description" rows="5">{{ old('description', $project->description) }}</textarea>
      @error('description')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>
  <div class="col-6">
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="file"
        class="form-control @error('image') is-invalid @elseif(old('image')) is-valid @enderror"
        id="image" name="image">
      @error('image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>
  <div class="col-6">
    <div class="mb-3">
      <label for="type_id" class="form-label">Type</label>
      <select class="form-select @error('type_id') is-invalid @elseif(old('type_id')) is-valid @enderror"
        name="type_id" id="type_id">
        <option value="">None</option>
        @foreach ($types as $type)
          <option value="{{ $type->id }}">{{ $type->label }}</option>
        @endforeach
      </select>
      @error('type_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
  </div>
  <div class="col-12 my-3">
    <p class="m-0">Technologies</p>
    @foreach ($technologies as $technology)
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="technology-{{ $technology->id }}"
          value="{{ $technology->id }}" name="technologies[]" @if (in_array($technology->id, old('technologies', $project_technology_ids ?? []))) checked @endif>
        <label class="form-check-label" for="technology-{{ $technology->id }}">{{ $technology->label }}</label>
      </div>
      @error('technologies')
        <div class="text-danger">
          {{ $message }}
        </div>
      @enderror
    @endforeach
  </div>
  <div class="col-1">
    <button type="submit" class="btn btn-success">Save</button>
  </div>
  <div class="col-1">
    <button type="reset" class="btn btn-warning">Reset</button>
  </div>
</div>

</form>
