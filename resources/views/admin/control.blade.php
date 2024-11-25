@extends('admin.basic')

@section('title', 'Tasks')

@section('content')
 
        <div class="row">
        <div class="col-lg-3 col-6">
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
        <div class="col-lg-3 col-6">
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
        <div class="col-lg-3 col-6">
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
        <div class="col-lg-3 col-6">
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