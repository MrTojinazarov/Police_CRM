@extends('admin.basic')

@section('title', 'Users')

@section('content')

    <div class="row">
        <div class="col-12">
            <h1>Users</h1>
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
                        <form method="post" action="{{ route('user.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name1" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name1" value="{{old('name')}}">
                                </div>
                                <div class="mb-3">
                                    <label for="email1" class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" id="email1"
                                        aria-describedby="emailHelp" value="{{old('email')}}">
                                </div>
                                <div class="mb-3">
                                    <label for="password1" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password1" value="{{old('password')}}">
                                </div>
                                <div class="mb-3">
                                    <label for="password2" class="form-label">Password Confirmation</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password2" value="{{old('password_confirmation')}}">
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
                        <th style="width: 200px;">Email</th>
                        <th style="width: 120px;">Role</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                    @foreach ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->email }}</td>
                            <td>{{ $model->role }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('user.delete', $model->id) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary" style="width: 80px; font-size:18px;">Delete</button>
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
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create User</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="{{ route('user.update', $model->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name1" class="form-label">Name</label>
                                                        <input type="text" name="name" class="form-control"
                                                            id="name1" value="{{ $model->name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email1" class="form-label">Email address</label>
                                                        <input type="email" name="email" class="form-control"
                                                            id="email1" value="{{ $model->email }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password1" class="form-label">New password
                                                            (Optional)</label>
                                                        <input type="password" name="password" class="form-control"
                                                            id="password1">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password2" class="form-label">New password confirm
                                                            (Optional)</label>
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" id="password2">
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