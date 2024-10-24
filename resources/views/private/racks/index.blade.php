@extends('layouts.private')

@section('title', 'Racks Index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Racks</h1>
    <a href="{{ route('racks.create') }}" class="btn btn-primary">Create New Rack</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Rack ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($racks as $rack)
            <tr id="rack-{{ $rack->rack_id }}">
                <td>{{ $rack->rack_id }}</td>
                <td>{{ $rack->name }}</td>
                <td>
                    <a href="{{ route('racks.edit', $rack->rack_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-rack" data-id="{{ $rack->rack_id }}">Delete</button>
                    <a href="{{ route('racks.show', $rack->rack_id) }}" class="btn btn-info btn-sm">View</a>
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
        document.querySelectorAll('.delete-rack').forEach(button => {
            button.addEventListener('click', function() {
                const rackId = this.getAttribute('data-id');
                const row = document.getElementById('rack-' + rackId);

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
                        fetch(`{{ route('racks.destroy' ,'') }}/${rackId}`, {
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
                                    data.msg || 'An error occurred while deleting the rack.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the rack.',
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
