@extends('admin.basic')

@section('title', 'Tasks')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <div class="small-box bg-info" style="flex: 1; min-width: 180px; height: auto;">
                    <div class="inner">
                        <h3>{{ $allCount }}</h3>
                        <p>All Tasks</p>
                    </div>
                    <a href="{{ route('control.page', ['filter' => 'all']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                <div class="small-box bg-success" style="flex: 1; min-width: 180px; height: auto;">
                    <div class="inner">
                        <h3>{{ $twoDaysLeftCount }}</h3>
                        <p>Two Days Left</p>
                    </div>
                    <a href="{{ route('control.page', ['filter' => 'two_days_left']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                <div class="small-box bg-warning" style="flex: 1; min-width: 180px; height: auto;">
                    <div class="inner">
                        <h3>{{ $oneDayLeftCount }}</h3>
                        <p>One Day Left</p>
                    </div>
                    <a href="{{ route('control.page', ['filter' => 'one_day_left']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                <div class="small-box bg-danger" style="flex: 1; min-width: 180px; height: auto;">
                    <div class="inner">
                        <h3>{{ $todayCount }}</h3>
                        <p>Today's Tasks</p>
                    </div>
                    <a href="{{ route('control.page', ['filter' => 'today']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                <div class="small-box bg-dark" style="flex: 1; min-width: 180px; height: auto;">
                    <div class="inner">
                        <h3>{{ $overdueCount }}</h3>
                        <p>Overdue Tasks</p>
                    </div>
                    <a href="{{ route('control.page', ['filter' => 'overdue']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h1>Control</h1>
        <div class="col-12">
            <table class="table table-bordered table-hover mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>Region</th>
                        @foreach ($categories as $category)
                            <th>{{ $category->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($regions as $region)
                    <tr>
                        <th>{{ $region->name }}</th>
                        @foreach ($categories as $category)
                            <td>
                                @if (($data[$region->id][$category->id] ?? 0) > 0)
                                    <form action="{{ route('task.page') }}" method="GET">
                                        @foreach ($tasks as $task)
                                            @if ($task->region_id == $region->id && $task->category_id == $category->id)
                                                <input type="hidden" name="regionTask_id" value="{{ $task->id }}">
                                                <button type="submit" class="btn 
                                                    @if(request('filter') == 'all') bg-info text-white
                                                    @elseif(request('filter') == 'two_days_left') bg-success text-white
                                                    @elseif(request('filter') == 'one_day_left') bg-warning text-dark
                                                    @elseif(request('filter') == 'today') bg-danger text-white
                                                    @elseif(request('filter') == 'overdue') bg-dark text-white
                                                    @else bg-primary text-white
                                                    @endif">
                                                    {{ $data[$region->id][$category->id] }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </form>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                
                </tbody>
            </table>
        </div>
    </div>
@endsection
