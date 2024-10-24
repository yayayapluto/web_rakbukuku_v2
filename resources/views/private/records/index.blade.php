@extends('layouts.private')

@section('title', 'Records Index')

@section('content')
<h1>Records</h1>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Record ID</th>
            <th>User</th>
            <th>Book</th>
            <th>Status</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
            <tr id="record-{{ $record->record_id }}">
                <td>{{ $record->record_id }}</td>
                <td>{{ $record->user->name }}</td>
                <td>{{ $record->book->title }}</td>
                <td>{{ $record->status }}</td>
                <td>{{ $record->borrow_date }}</td>
                <td>{{ $record->return_date }}</td>
                <td>
                    <a href="{{ route('records.show', $record->record_id) }}" class="btn btn-info btn-sm">View</a>
                    <button class="btn btn-danger btn-sm delete-record" data-id="{{ $record->record_id }}">Delete</button>
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
        document.querySelectorAll('.delete-record').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                const row = document.getElementById('record-' + recordId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('records.destroy', '') }}/${recordId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
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
                                Swal.fire(
                                    'Error!',
                                    data.msg || 'An error occurred while deleting the record.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the record.',
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
