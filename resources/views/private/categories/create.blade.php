@extends('layouts.private')

@section("title", "Create Category")

@section('content')
<div class="mt-4">
    <h1 class="m-0">Create Category</h1>
    
    <form id="createCategoryForm" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
            
            <label for="image" class="form-label">Image</label>
            <input type="file" accept="image/*" class="form-control" id="image" name="image" required>
            
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Create Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#createCategoryForm").on("submit", function(e) {
            e.preventDefault();

            // Show loading state
            Swal.fire({
                icon: 'info',
                title: 'Creating Category...',
                text: 'Please wait while we process your request.',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('categories.store') }}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,  // Corrected typo
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
        });
    });
</script>
@endsection
