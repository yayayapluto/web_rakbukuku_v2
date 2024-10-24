@extends('layouts.private')

@section('title', 'Edit Category')

@section('content')
<div class="mt-4">
    <h1 class="m-0">Edit Category</h1>

    <form id="editCategoryForm" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#editCategoryForm").on("submit", function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('categories.update', $category->category_id) }}",
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        Swal.fire({
                            icon: res.success ? "success" : "error",
                            title: res.success ? "Success" : "Error",
                            html: `<p>${res.msg}</p>`,
                            position: "center",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        }).then(function () {
                            if (res.success) {
                                location.href = '{{ route('categories.index') }}';
                            }
                        });
                    },
                    error: function(err) {
                        const res = err.responseJSON;
                        const message = res.msg || 'An error occurred. Please try again.';
                        Swal.fire({
                            icon: "error",
                            title: "Error",
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
