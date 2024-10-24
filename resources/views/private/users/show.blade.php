@extends('layouts.private')

@section("title", "User Details")

@section('content')
<div class="mt-4">
    <h1 class="m-0">User Details</h1>
    
    <table class="table table-bordered mt-3">
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $user->gender }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $user->phone_number }}</td>
        </tr>
        <tr>
            <th>Photo</th>
            <td><a href="{{ $user->photo }}">{{ $user->photo }}</a></td>
        </tr>
    </table>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
    <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning">Edit User</a>
</div>
@endsection
