@extends('admin.basic')

@section('title', 'Tasks')

@section('content')

    <h1>Responses</h1>
    <div class="row mt-3">
        <div class="col-12">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 50px">№</th>
                        <th style="width: 100px">Region</th>
                        <th style="width: 60px">Task</th>
                        <th style="width: 120px">Title</th>
                        <th style="width: 150px">File</th>
                        <th style="width: 100px">Comment</th>
                        <th style="width: 130px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $model)
                        <tr>
                            <th>{{ $model->id }}</th>
                            <td>{{ $model->regions->name }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary" style="width: 100px"
                                    data-toggle="modal" data-target="#exampleModal{{ $model->id }}">
                                    Task
                                </button>

                                <div class="modal fade" id="exampleModal{{ $model->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>{{ $model->tasks->title }}</h3>
                                                <hr>
                                                @if ($model->tasks->file)
                                                    @php
                                                        $fileExtension = pathinfo(
                                                            $model->tasks->file,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                    @endphp
                                                    <a href="{{ asset($model->tasks->file) }}"
                                                        class="btn btn-outline-primary" download>
                                                        <i class="fas fa-download mr-1"></i>
                                                        Download {{ strtoupper($fileExtension) }} File
                                                    </a>
                                                @else
                                                    <span>No file uploaded</span>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $model->title }}</td>
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
                            <td>{{$model->note}}</td>
                            <td class="task-actions">
                                @if ($model->status == 1)
                                    <button type="submit" class="btn btn-outline-info btn-action" style="width: 120px">
                                        <i class="fas fa-envelope-open mr-1"></i>
                                        <span>Sent</span>
                                    </button>
                                @elseif ($model->status == 2)
                                    <button type="button" class="btn btn-outline-success btn-action disabled" style="width: 120px">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span>Opened</span>
                                    </button>
                                @elseif ($model->status == 4)
                                    <button type="button" class="btn btn-outline-success btn-action disabled" style="width: 120px">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span>Approved</span>
                                    </button>
                                @elseif ($model->status == 5)
                                    <button type="button" class="btn btn-outline-warning btn-action disabled" style="width: 120px">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        <span>Rejected</span>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-success btn-action" style="width: 120px" data-toggle="modal"
                                        data-target="#exampleModalstatus{{ $model->id }}">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        <span>Answered</span>
                                    </button>

                                    <div class="modal fade" id="exampleModalstatus{{ $model->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Task Action</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('response.check', $model->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <label for="note" class="form-label">Note</label>
                                                        <textarea name="note" class="form-control" id="note" cols="50" rows="5" placeholder="Enter note"></textarea>
                                                        <input type="hidden" name="action" id="action" value="">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-outline-primary" onclick="setAction('approve')">
                                                            Approve
                                                        </button>
                                                        <button type="submit" class="btn btn-outline-warning" onclick="setAction('reject')">
                                                            Reject
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $models->links() }}
    </div>

@endsection
