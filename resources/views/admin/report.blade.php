@extends('admin.basic')

@section('title', 'Tasks')

@section('content')

    <h1>Report</h1>
    <div class="row">
        <div class="col-12">
            <form method="GET" action="{{ route('task.page') }}" class="form-inline" id="filterForm">
                <div class="form-group mr-2 mt-2">
                    <label for="start_date" class="mr-2">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" placeholder="yyyy-mm-dd"
                        value="{{ request()->query('start_date') }}">
                </div>
                <div class="form-group mr-2 mt-2">
                    <label for="end_date" class="mr-2">End Date:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" placeholder="yyyy-mm-dd"
                        value="{{ request()->query('end_date') }}">
                </div>
                <button type="submit" style="width: 50px;" class="btn btn-primary mt-2" id="filterButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-filter" viewBox="0 0 16 16">
                        <path
                            d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                    </svg>
                </button>
            </form>
            <table class="table table-bordered table-hover mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th style="width:20px">Category</th>
                        <th style="width:120px">Sent</th>
                        <th style="width:120px">Opened</th>
                        <th style="width:120px">Answered</th>
                        <th style="width:120px">Approved</th>
                        <th style="width:120px">Rejected</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $data)
                        <tr>
                            <th>{{ $data['category'] }}</th>
                            <td>{{ $data['statuses']->where('status', 1)->first()->count ?? '-' }}</td>
                            <td>{{ $data['statuses']->where('status', 2)->first()->count ?? '-' }}</td>
                            <td>{{ $data['statuses']->where('status', 3)->first()->count ?? '-' }}</td>
                            <td>{{ $data['statuses']->where('status', 4)->first()->count ?? '-' }}</td>
                            <td>{{ $data['statuses']->where('status', 5)->first()->count ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>

@endsection
