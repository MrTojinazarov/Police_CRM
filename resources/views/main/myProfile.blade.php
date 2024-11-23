@extends('main.index') 
@section('title', 'My Profile')

@section('content')
<div class="container mt-5">
    <h2>Update Profile</h2>
    <form method="POST" action="{{ route('profile.update', auth()->user()->id ) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">New Password</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter new name" value="{{auth()->user()->name}}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="{{ auth()->user()->email }}" required>
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="form-control" placeholder="Confirm new password">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
