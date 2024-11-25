@extends('admin.basic')

@section('title', 'Tasks')

@section('content')
    {{-- <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>All Tasks</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Two days left</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>One day left</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Today's</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Overdue</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Rejected</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $allCount }}</h3>
                    <p>All Tasks</p>
                </div>
                <a href="{{ route('task.page', ['filter' => 'all']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $twoDaysLeftCount }}</h3>
                    <p>Two days left</p>
                </div>
                <a href="{{ route('task.page', ['filter' => 'two_days_left']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $oneDayLeftCount }}</h3>
                    <p>One day left</p>
                </div>
                <a href="{{ route('task.page', ['filter' => 'one_day_left']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $todayCount }}</h3>
                    <p>Today's</p>
                </div>
                <a href="{{ route('task.page', ['filter' => 'today']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $overdueCount }}</h3>
                    <p>Overdue</p>
                </div>
                <a href="{{ route('task.page', ['filter' => 'overdue']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $rejectedCount }}</h3>
                    <p>Rejected</p>
                </div>
                <a href="{{ route('task.page', ['filter' => 'rejected']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
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

            <button type="button" class="btn btn-primary" style="width: 110px;" data-bs-toggle="modal"
                data-bs-target="#exampleModal"> Create new</button>

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
                                    <label for="performer" class="form-label">Performer</label>
                                    <input type="text" name="performer" class="form-control" id="performer"
                                        value="{{ old('performer') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Deadline</label>
                                    <input type="date" name="deadline" id="deadline" class="form-control"
                                        value="{{ old('deadline') }}">
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="select2" class="form-label">Multiple</label>
                                        <select class="select2" name="region_ids[]" multiple="multiple"
                                            data-placeholder="Select a State" style="width: 100%;" id="select2">
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
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

            <form method="GET" action="{{ route('task.page') }}" class="form-inline" id="filterForm">
                <div class="form-group mr-2 mt-4">
                    <label for="start_date" class="mr-2">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                        placeholder="yyyy-mm-dd" value="{{ request()->query('start_date') }}">
                </div>
                <div class="form-group mr-2 mt-4">
                    <label for="end_date" class="mr-2">End Date:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" placeholder="yyyy-mm-dd"
                        value="{{ request()->query('end_date') }}">
                </div>
                <button type="submit" style="width: 50px;" class="btn btn-primary mt-4" id="filterButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-filter" viewBox="0 0 16 16">
                        <path
                            d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                    </svg>
                </button>
            </form>


            <div class="mt-3">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th style="width: 20px;">ID</th>
                        <th style="width: 120px;">Region</th>
                        <th style="width: 150px;">Performer</th>
                        <th style="width: 150px;">Title</th>
                        <th style="width: 200px;">File</th>
                        <th style="width: 120px">Time sent</th>
                        <th style="width: 120px;">Deadline</th>
                        <th style="width: 130px">Status</th>
                        <th style="width: 70px;">Actions</th>
                    </tr>
                    </thead>
                    @foreach ($models as $model)
                        <tr>
                            <th>{{ $model->id }}</th>
                            <td>{{ $model->regions->name }}</td>
                            <td>{{ $model->tasks->performer }}</td>
                            <td>{{ $model->tasks->title }}</td>
                            <td>
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
                            <td>{{ $model->created_at }}</td>
                            <td>{{ $model->deadline }}</td>
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
                                    <button type="button" class="btn btn-outline-warning btn-action" style="width: 120px">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        <span>Answered</span>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <form action="{{ route('task.delete', $model->id) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 50px; font-size:18px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-warning mt-1"
                                        style="width: 50px; font-size:18px;" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $model->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                        </svg>
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
                                            <form method="post" action="{{ route('task.update', $model->id) }}"
                                                enctype="multipart/form-data">
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
                                                            id="title" value="{{ $model->tasks->title }}">
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
                                                                $fileExtension = pathinfo(
                                                                    $model->tasks->file,
                                                                    PATHINFO_EXTENSION,
                                                                );
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
                                                            class="form-control" value="{{ $model->deadline }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <label for="select" class="form-label">Multiple</label>
                                                            <select class="form-select" name="region_id"
                                                                style="width: 100%;" id="select">
                                                                @foreach ($areas as $area)
                                                                    <option value="{{ $area->id }}"
                                                                        @if ($model->region_id == $area->id) selected @endif>
                                                                        {{ $area->name }}
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
            </div>
        </div>
        {{ $models->links() }}
    </div>

@endsection
