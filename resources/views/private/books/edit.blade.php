@extends('layouts.private')

@section('title', 'Edit Book')

@section('content')
    <h1>Edit Book</h1>

    <form id="editBookForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="book_id" value="{{ $book->book_id }}">
        <div class="form-group">
            <label for="rack_id">Rack</label>
            <select class="form-control" name="rack_id" id="rack_id" required>
                @foreach($racks as $rack)
                    <option value="{{ $rack->rack_id }}" {{ $rack->rack_id === $book->rack_id ? 'selected' : '' }}>{{ $rack->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ $category->category_id === $book->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ $book->title }}" required>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" class="form-control" name="isbn" id="isbn" value="{{ $book->isbn }}" required>
        </div>
        <div class="form-group">
            <label for="writer">Author</label>
            <input type="text" class="form-control" name="writer" id="writer" value="{{ $book->writer }}" required>
        </div>
        <div class="form-group">
            <label for="publisher">Publisher</label>
            <input type="text" class="form-control" name="publisher" id="publisher" value="{{ $book->publisher }}" required>
        </div>
        <div class="form-group">
            <label for="publish_year">Publish Year</label>
            <input type="number" class="form-control" name="publish_year" id="publish_year" value="{{ $book->publish_year }}" required>
        </div>
        <div class="form-group">
            <label for="cover">Cover URL</label>
            <input type="url" class="form-control" name="cover" id="cover" value="{{ $book->cover }}">
        </div>
        <div class="form-group">
            <label for="soft_file">Soft File URL</label>
            <input type="url" class="form-control" name="soft_file" id="soft_file" value="{{ $book->soft_file }}">
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="{{ $book->stock }}" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#editBookForm").on("submit", function(e) {
                e.preventDefault(); // Prevent the default form submission

                const formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: '{{ route('books.update', $book->book_id) }}',
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Book updated successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '{{ route('books.index') }}'; // Redirect to index page
                        });
                    },
                    error: function(err) {
                        const errors = err.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>'; // Concatenate error messages
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorMessage,
                        });
                    }
                });
            });
        });
    </script>
@endsection
