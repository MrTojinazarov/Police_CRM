@extends('main.index')

@section('title', 'MyTasks')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1>My Task Page</h1>
            <div class="mt-3">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th style="width: 20px;">ID</th>
                        <th style="width: 120px;">Title</th>
                        <th style="width: 150px;">Performer</th>
                        <th style="width: 150px;">Category</th>
                        <th style="width: 150px;">File</th>
                        <th style="width: 120px;">Deadline</th>
                        <th style="width: 150px">Status</th>
                    </tr>
                    @foreach ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->tasks->title}}</td>
                            <td>{{ $model->tasks->performer }}</td>
                            <td>{{ $model->categories->name }}</td>
                            <td>
                                @if ($model->tasks->file)
                                    @php
                                        $fileExtension = pathinfo($model->tasks->file, PATHINFO_EXTENSION);
                                    @endphp
                                    <a href="{{ asset($model->tasks->file) }}" class="btn btn-outline-primary" download>
                                        <i class="fas fa-download mr-1"></i> 
                                        Download {{ strtoupper($fileExtension) }} File
                                    </a>
                                @else
                                    <span>No file uploaded</span>
                                @endif
                            </td>
                                   
                            <td>{{ $model->deadline }}</td>
                            <td class="task-actions">
                                @if ($model->status == 1)
                                    <form method="POST" action="{{ route('tasks.open', $model->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info btn-action">
                                            <i class="fas fa-envelope-open mr-1"></i>
                                            <span>Open</span>
                                        </button>
                                    </form>
                                @elseif ($model->status == 3)
                                    <button type="button" class="btn btn-outline-success btn-action disabled">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span>Done</span>
                                    </button>
                                @elseif ($model->status == 4)
                                    <button type="button" class="btn btn-success btn-action disabled">
                                        <i class="fas fa-trophy mr-1"></i>
                                        <span>Approved</span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-warning btn-action" data-toggle="modal"
                                        data-target="#doTaskModal-{{ $model->id }}">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        <span>Do Task</span>
                                    </button>

                                    <!-- Enhanced Modal -->
                                    <div class="modal fade task-modal" id="doTaskModal-{{ $model->id }}" tabindex="-1"
                                        aria-labelledby="doTaskLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form method="POST" action="{{ route('tasks.do', $model->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-clipboard-check mr-2"></i>
                                                            Complete Task
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-4">
                                                            <label for="note" class="font-weight-bold">
                                                                <i class="fas fa-comment-alt mr-2"></i>
                                                                Task Notes
                                                            </label>
                                                            <textarea name="note" id="note" class="form-control" rows="4" required
                                                                placeholder="Enter your notes about the task completion..."></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="file" class="font-weight-bold">
                                                                <i class="fas fa-paperclip mr-2"></i>
                                                                Attachment
                                                            </label>
                                                            <div class="form-group">
                                                                <input type="file" name="file"
                                                                    class="form-control" id="file">
                                                            </div>
                                                            <small class="form-text text-muted mt-2">
                                                                <i class="fas fa-info-circle mr-1"></i>
                                                                Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG ,MP4 (max
                                                                20MB)
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-dismiss="modal">
                                                            <i class="fas fa-times mr-1"></i>
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-paper-plane mr-1"></i>
                                                            Submit Task
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
