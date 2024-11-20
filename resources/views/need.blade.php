<table class="table table-hover table-bordered">
    <tr>
        <th style="width: 20px;">ID</th>
        <th style="width: 120px;">Region</th>
        <th style="width: 150px;">Performer</th>
        <th style="width: 150px;">Title</th>
        <th style="width: 150px;">Description</th>
        <th style="width: 200px;">File</th>
        <th style="width: 120px">Time sent</th>
        <th style="width: 120px;">Deadline</th>
        <th style="width: 100px">Status</th>
        <th style="width: 100px;">Actions</th>
    </tr>
    @foreach ($models as $model)
        <tr>
                <td>{{ $model->tasks->id }}</td>
                <td>
                    @foreach ($categories as $category)
                        @if ($category->id == $model->category_id)
                            {{ $category->name }}
                        @break
                        @endif
                    @endforeach
                {{$model->regions->name}}
            </td>
            <td>{{ $model->tasks->title }}</td>
            <td>{{ $model->tasks->description }}</td>
            <td>{{ $model->tasks->performer }}</td>
            <td>
                @if ($model->tasks->file)
                    @php
                        $fileExtension = pathinfo($model->file, PATHINFO_EXTENSION);
                        $filePath = $model->tasks->file;
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
            <td>{{ $model->tasks->created_at }}</td>
            <td>{{ $model->tasks->deadline }}</td>
            <td></td>
            <td>
                <div>
                    <form action="{{ route('task.delete', $model->tasks->id) }}" method="POST" class="me-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary"
                            style="width: 80px; font-size:18px;">Delete</button>
                    </form>
                    <button type="button" class="btn btn-warning mt-1" style="width: 80px; font-size:18px;"
                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $model->tasks->id }}">
                        Update
                    </button>
                </div>

                <div class="modal fade" id="exampleModal{{ $model->tasks->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="post" action="{{ route('task.update', $model->tasks->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-control" name="category_id" id="category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($model->tasks->category_id == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control"
                                            id="title" value="{{ $model->tasks->title }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control"
                                            id="description" value="{{ $model->tasks->description }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="performer" class="form-label">Performer</label>
                                        <input type="text" name="performer" class="form-control"
                                            id="performer" value="{{ $model->tasks->performer }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="file" class="form-label">File</label>
                                        <input type="file" name="file" id="file"
                                            class="form-control">
                                        <br>
                                        @if ($model->tasks->file)
                                            @php
                                                $fileExtension = pathinfo($model->tasks->file, PATHINFO_EXTENSION);
                                                $filePath = $model->tasks->file;
                                            @endphp

                                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                                <img src="{{ asset($filePath) }}" alt="File Image"
                                                    style="max-width: 200px; height: auto;">
                                            @elseif (in_array($fileExtension, ['MP4', 'mp4', 'mov', 'avi', 'mkv']))
                                                <video controls style="max-width: 200px;">
                                                    <source src="{{ asset($filePath) }}"
                                                        type="video/{{ $fileExtension }}">
                                                </video>
                                            @elseif (in_array($fileExtension, ['pdf', 'doc', 'docx', 'xls', 'xlsx']))
                                                <a href="{{ asset($filePath) }}" target="_blank">Download
                                                    File</a>
                                            @else
                                                <span>Unknown file type</span>
                                            @endif
                                        @else
                                            <span>No file uploaded</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="deadline" class="form-label">Deadline</label>
                                        <input type="date" name="deadline" id="deadline"
                                            class="form-control" value="{{ $model->tasks->deadline }}">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="select22" class="form-label">Multiple</label>
                                            <select class="select2" name="region_id[]"
                                                multiple="multiple" data-placeholder="Select a State"
                                                style="width: 100%;" id="select22">
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}"
                                                        @foreach ($models as $regiontask)
                                                        @if ($model->tasks->id == $regiontask->task_id && $region->id == $regiontask->region_id)
                                                            selected
                                                        @endif @endforeach>
                                                        {{ $region->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"
                                        style="width: 70px;">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
</table>