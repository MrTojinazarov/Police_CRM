@extends('admin.basic')

@section('title', 'Regions')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1>Regions</h1>
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

            <button type="button" class="btn btn-primary" style="width: 90px; font-size:20px;" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Create
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('region.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="user" class="form-label">User</label>
                                    <select class="form-control" name="user_id" id="user">
                                        <option value="">Choose</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name1" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name1"
                                        value="{{ old('name') }}">
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

            <div class="mt-3">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th style="width: 20px;">№</th>
                        <th style="width: 150px;">Name</th>
                        <th style="width: 150px;">User</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                    @foreach ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->name }}</td>
                            <td>
                                @foreach ($users as $user)
                                    @if ($user->id == $model->user_id)
                                        {{$user->name}}
                                        @break
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('region.delete', $model->id) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 80px; font-size:18px;">Delete</button>
                                    </form>
                                    <button type="button" class="btn btn-warning" style="width: 80px; font-size:18px;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $model->id }}">
                                        Update
                                    </button>
                                </div>

                                <div class="modal fade" id="exampleModal{{ $model->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Region</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="{{ route('region.update', $model->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="user" class="form-label">User</label>
                                                        <select class="form-control" name="user_id" id="user">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" 
                                                                        @if ($model->user_id == $user->id) selected @endif>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>                                                        
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name1" class="form-label">Name</label>
                                                        <input type="text" name="name" class="form-control"
                                                            id="name1" value="{{ $model->name }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        style="width: 70px;">Save</button>
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
