@extends('admin.basic')

@section('title', 'Main report')

@section('content')
    <h1>Main report</h1>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>№</th>
                        <th>Categories</th>
                        <th>Status</th>
                        @foreach ($regions as $region)
                            <th class="vertical-text">{{$region->name}}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th rowspan="5">{{$loop->iteration}}</th>
                            <th rowspan="5">{{$category->name}}</th>
            
                            <td>Sent</td>
                            @foreach ($regions as $region)
                                <td><button class="btn btn-primary">{{ $data[$category->name][$region->name]['sent'] }}</button></td>
                            @endforeach
                            <td><button class="btn btn-primary">{{ $data[$category->name]['total']['sent'] }}</button></td>
                        </tr>
            
                        <tr>
                            <td>Opened</td>
                            @foreach ($regions as $region)
                                <td><button class="btn btn-info">{{ $data[$category->name][$region->name]['opened'] }}</button></td>
                            @endforeach
                            <td><button class="btn btn-info">{{ $data[$category->name]['total']['opened'] }}</button></td>
                        </tr>
            
                        <tr>
                            <td>Answered</td>
                            @foreach ($regions as $region)
                                <td><button class="btn btn-warning">{{ $data[$category->name][$region->name]['answered'] }}</button></td>
                            @endforeach
                            <td><button class="btn btn-warning">{{ $data[$category->name]['total']['answered'] }}</button></td>
                        </tr>
            
                        <tr>
                            <td>Approved</td>
                            @foreach ($regions as $region)
                                <td><button class="btn btn-success">{{ $data[$category->name][$region->name]['approved'] }}</button></td>
                            @endforeach
                            <td><button class="btn btn-success">{{ $data[$category->name]['total']['approved'] }}</button></td>
                        </tr>
            
                        <tr>
                            <td>Rejected</td>
                            @foreach ($regions as $region)
                                <td><button class="btn btn-danger">{{ $data[$category->name][$region->name]['rejected'] }}</button></td>
                            @endforeach
                            <td><button class="btn btn-danger">{{ $data[$category->name]['total']['rejected'] }}</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
@endsection