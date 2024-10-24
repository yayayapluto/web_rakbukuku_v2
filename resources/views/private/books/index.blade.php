@extends('layouts.private')

@section('title', 'Books Index')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Create New Book</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->book_id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->writer }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>
                        <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-book" data-id="{{ $book->book_id }}">Delete</button>
                        <a href="{{ route('books.show', $book->book_id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".delete-book").on("click", function() {
                const bookId = $(this).data("id");
                const row = $(this).closest("tr");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the book!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('books.destroy', '') }}/${bookId}`,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Book has been deleted.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                row.fadeOut(); // Remove the row from the table
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
