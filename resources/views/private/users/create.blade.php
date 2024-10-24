@extends('layouts.private')

@section("title", "Create User")

@section('content')
<div class="mt-4">
    <h1 class="m-0">Create User</h1>
    
    <form id="createUserForm" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <input type="text" class="form-control" id="gender" name="gender">
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo URL</label>
            <input type="url" class="form-control" id="photo" name="photo">
        </div>

        <button type="submit" class="btn btn-success">Create User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#createUserForm").on("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route('users.store') }}',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({
                            icon: res.success ? "success" : "error",
                            title: res.success ? "Berhasil" : "Gagal",
                            html: `<p>${res.msg}</p>`,
                            position: "center",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        }).then(function () {
                            if (res.success) {
                                location.href = res.route;
                            }
                        });
                    },
                    error: function(err) {
                        const res = err.responseJSON;
                        const message = res.msg || 'Terjadi kesalahan. Silakan coba lagi.';
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            html: `<p>${message}</p>`,
                            position: "center",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });

                return true;
            });
        });
    </script>
@endsection
