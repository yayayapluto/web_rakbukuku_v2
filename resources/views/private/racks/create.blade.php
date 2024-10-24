@extends('layouts.private')

@section('title', 'Create Rack')

@section('content')
<h1>Create New Rack</h1>

<form id="create-rack-form">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <button type="submit" class="btn btn-success mt-4">Create Rack</button>
    <a href="{{ route('racks.index') }}" class="btn btn-secondary mt-4">Cancel</a>
</form>

<div id="response-message" class="mt-3"></div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('create-rack-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form);

            fetch('{{ route('racks.store') }}', {
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
                    text: 'An error occurred while creating the rack.',
                });
            });
        });
    });
</script>
@endsection
