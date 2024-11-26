@extends('admin.basic')

@section('title', 'Tasks')

@section('content')

    <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $allCount }}</h3>
                    <p>All Tasks</p>
                </div>
                <a href="{{ route('control.page', ['filter' => 'all']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $twoDaysLeftCount }}</h3>
                    <p>Two Days Left</p>
                </div>
                <a href="{{ route('control.page', ['filter' => 'two_days_left']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $oneDayLeftCount }}</h3>
                    <p>One Day Left</p>
                </div>
                <a href="{{ route('control.page', ['filter' => 'one_day_left']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $todayCount }}</h3>
                    <p>Today's Tasks</p>
                </div>
                <a href="{{ route('control.page', ['filter' => 'today']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $overdueCount }}</h3>
                    <p>Overdue Tasks</p>
                </div>
                <a href="{{ route('control.page', ['filter' => 'overdue']) }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-hover">
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
                                            <input type="hidden" name="region_id" value="{{ $region->id }}">
                                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                                            <button type="submit" class="btn btn-primary">
                                                {{ $data[$region->id][$category->id] }}
                                            </button>
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
