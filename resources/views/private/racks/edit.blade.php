@extends('layouts.private')

@section('title', 'Edit Rack')

@section('content')
<h1>Edit Rack</h1>

<form id="edit-rack-form">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $rack->name }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Rack</button>
    <a href="{{ route('racks.index') }}" class="btn btn-secondary">Cancel</a>
</form>

<div id="response-message" class="mt-3"></div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('edit-rack-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form);

            fetch('{{ route('racks.update', $rack->rack_id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Success' : 'Error',
                    text: data.msg,
                }).then(() => {
                    if (data.success) {
                        location.href = '{{ route('racks.index') }}';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the rack.',
                });
            });
        });
    });
</script>
@endsection
