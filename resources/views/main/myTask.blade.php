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
                        <th style="width: 120px;">Region</th>
                        <th style="width: 150px;">Performer</th>
                        <th style="width: 150px;">Category</th>
                        <th style="width: 200px;">File</th>
                        <th style="width: 120px;">Deadline</th>
                        <th style="width: 150px">Status</th>
                    </tr>
                    @foreach ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->regions->name }}</td>
                            <td>{{ $model->tasks->performer }}</td>
                            <td>{{ $model->categories->name }}</td>
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
                            <td>{{ $model->deadline }}</td>
                            <td>
                                @php
                                    $status = $model->status;
                                    $buttonClass = '';
                                    $statusText = '';
                            
                                    if ($status == 1) {
                                        $buttonClass = 'btn-outline-primary';
                                        $statusText = 'Open';
                                    } elseif ($status == 2) {
                                        $buttonClass = 'btn-outline-success';
                                        $statusText = 'Do Task';
                                    } elseif ($status == 3) {
                                        $buttonClass = 'btn-outline-warning';
                                        $statusText = 'Done';
                                    } elseif ($status == 4) {
                                        $buttonClass = 'btn-outline-dark';
                                        $statusText = 'Accepted';
                                    } elseif ($status == 5) {
                                        $buttonClass = 'btn-outline-danger';
                                        $statusText = 'Rejected';
                                    } else {
                                        $buttonClass = 'btn-outline-secondary';
                                    }
                                @endphp
                            
                                <form action="{{ route('region-task.update-status', $model->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                            
                                    <input type="hidden" name="status" value="{{ $status }}">
                            
                                    <button type="submit" class="btn {{ $buttonClass }}"
                                        style="width: 100%; text-align: center; border-width: 2px;"
                                        {{ in_array($status, [3, 4, 5]) ? 'disabled' : '' }}>
                                        {{ ucfirst($statusText) }}
                                    </button>
                                </form>
                            </td>
                            
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
