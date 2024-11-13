@extends('layouts.public')

@section('title', 'Return Book')

@section('content')
    <div>
        <h2>Return Book: {{ $book->title }}</h2>

        <p><strong>Author:</strong> {{ $book->writer }}</p>
        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
        <p><strong>Available Stock:</strong> {{ $book->stock }}</p>

        <form id="returnForm" method="POST">
            @csrf

            <div>
                <label for="user_note">Note (Optional):</label>
                <textarea id="user_note" name="user_note" placeholder="Add any note or request (optional)"></textarea>
            </div>

            <div>
                <input type="submit" value="Return Book">
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
        $(document).ready(function() {
            $("#returnForm").on("submit", function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('return.submit', $book->book_id) }}',
                    type: "POST",
                    data: formData,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.msg,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            window.location.href = res.route;
                        });
                    },
                    error: function(err) {
                        const errors = err.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
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
