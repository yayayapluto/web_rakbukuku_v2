@extends('layouts.private')

@section("title", "Users Index")

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->user_id }}">Delete</button>
                            <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".delete-user").on("click", function() {
                const userId = $(this).data("id");
                const row = $(this).closest("tr");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('users.destroy', '') }}/' + userId, // Use route helper
                            type: "POST",
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'User has been deleted.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                row.fadeOut();
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
