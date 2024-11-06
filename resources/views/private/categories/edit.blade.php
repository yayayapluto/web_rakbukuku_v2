@extends('layouts.private')

@section('title', 'Edit Category')

@section('content')
<div class="mt-4">
    <h1 class="m-0">Edit Category</h1>

    <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (Optional)</label>
            <input type="file" accept="image/*" class="form-control" id="image" name="image">
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

            // Show loading spinner while the request is being processed
            Swal.fire({
                icon: 'info',
                title: 'Updating Category...',
                text: 'Please wait while we process your request.',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Collect the form data using FormData (so we can include file uploads)
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('categories.update', $category->category_id) }}", // Dynamic route for the specific category
                type: "POST",  // POST method is used because we're sending the PUT method via a hidden input.
                data: formData,
                processData: false,  // Don't let jQuery process the form data (FormData will handle it)
                contentType: false,  // Let the browser set the content type (especially needed for file uploads)
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
