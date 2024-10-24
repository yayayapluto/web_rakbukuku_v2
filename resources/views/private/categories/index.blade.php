@extends('layouts.private')

@section('title', 'Categories Index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr id="category-{{ $category->category_id }}">
                <td>{{ $category->category_id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-category" data-id="{{ $category->category_id }}">Delete</button>
                    <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="response-message" class="mt-3"></div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-category');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                const row = document.getElementById('category-' + categoryId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('categories.destroy', '') }}/${categoryId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                row.remove();
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'success'
                                );
                            } else {
                                throw new Error(data.msg);
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'An error occurred: ' + error.message,
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
