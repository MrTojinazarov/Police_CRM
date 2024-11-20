@extends('admin.basic')

@section('title', 'Tasks')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1>Tasks</h1>
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <button type="button" class="btn btn-primary" style="width: 90px; font-size:20px;" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Create
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create Task</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('task.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" name="category_id" id="category">
                                        <option value="">Choose</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                        value="{{ old('title') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control" id="description"
                                        value="{{ old('description') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="performer" class="form-label">Performer</label>
                                    <input type="text" name="performer" class="form-control" id="performer"
                                        value="{{ old('performer') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Deadline</label>
                                    <input type="date" name="deadline" id="deadline" class="form-control"
                                        value="{{ old('deadline') }}">
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="select2" class="form-label">Multiple</label>
                                        <select class="select2" name="region_id[]" multiple="multiple" data-placeholder="Select a State"
                                            style="width: 100%;" id="select2">
                                            @foreach ($regions as $region)
                                                <option value="{{$region->id}}">{{$region->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" style="width: 70px;">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th style="width: 20px;">№</th>
                        <th style="width: 150px;">Category</th>
                        <th style="width: 150px;">Title</th>
                        <th style="width: 150px;">Description</th>
                        <th style="width: 150px;">Performer</th>
                        <th style="width: 150px;">File</th>
                        <th style="width: 150px;">Deadline</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                    @foreach ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>
                                @foreach ($categories as $category)
                                    @if ($category->id == $model->category_id)
                                        {{ $category->name }}
                                    @break
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $model->title }}</td>
                        <td>{{ $model->description }}</td>
                        <td>{{ $model->performer }}</td>
                        <td>
                            @if ($model->file)
                                @php
                                    $fileExtension = pathinfo($model->file, PATHINFO_EXTENSION);
                                    $filePath = $model->file;
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                    <img src="{{ asset($filePath) }}" alt="File Image"
                                        style="max-width: 200px; height: auto;">
                                @elseif (in_array($fileExtension, ['MP4', 'mp4', 'mov', 'avi', 'mkv']))
                                    <video controls style="max-width: 200px;">
                                        <source src="{{ asset($filePath) }}" type="video/{{ $fileExtension }}">
                                    </video>
                                @elseif (in_array($fileExtension, ['pdf', 'doc', 'docx', 'xls', 'xlsx']))
                                    <a href="{{ asset($filePath) }}" target="_blank">Download File</a>
                                @else
                                    <span>Unknown file type</span>
                                @endif
                            @else
                                <span>No file uploaded</span>
                            @endif
                        </td>

                        <td>{{ $model->deadline }}</td>
                        <td>
                            <div class="d-flex">
                                <form action="{{ route('task.delete', $model->id) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary"
                                        style="width: 80px; font-size:18px;">Delete</button>
                                </form>
                                <button type="button" class="btn btn-warning" style="width: 80px; font-size:18px;"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal{{ $model->id }}">
                                    Update
                                </button>
                            </div>

                            <div class="modal fade" id="exampleModal{{ $model->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="{{ route('task.update', $model->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="category" class="form-label">Category</label>
                                                    <select class="form-control" name="category_id" id="category">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @if ($model->category_id == $category->id) selected @endif>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" name="title" class="form-control"
                                                        id="title" value="{{ $model->title }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <input type="text" name="description" class="form-control"
                                                        id="description" value="{{ $model->description }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="performer" class="form-label">Performer</label>
                                                    <input type="text" name="performer" class="form-control"
                                                        id="performer" value="{{ $model->performer }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file" class="form-label">File</label>
                                                    <input type="file" name="file" id="file"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="deadline" class="form-label">Deadline</label>
                                                    <input type="datetime" name="deadline" id="deadline"
                                                        class="form-control" value="{{ $model->deadline }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"
                                                    style="width: 70px;">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{ $models->links() }}
</div>

@endsection
