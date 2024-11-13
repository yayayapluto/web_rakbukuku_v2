@extends('layouts.public')

@section('title', 'Borrow Book')

@section('content')
    <div>
        <h2>Borrow Book: {{ $book->title }}</h2>

        <p><strong>Author:</strong> {{ $book->writer }}</p>
        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
        <p><strong>Available Stock:</strong> {{ $book->stock }}</p>

        <form id="borrowForm" method="POST">
            @csrf

            <div>
                <label for="user_note">Note (Optional):</label>
                <textarea id="user_note" name="user_note" placeholder="Add any note or request (optional)"></textarea>
            </div>

            <div>
                <input type="submit" value="Borrow Book">
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
        $(document).ready(function() {
            $("#borrowForm").on("submit", function(e) {
                e.preventDefault(); // Prevent the default form submission

                const formData = $(this).serialize(); // Serialize form datx    a
                console.log(formData);
                

                $.ajax({
                    url: '{{ route('borrow.submit', $book->book_id) }}',
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
                            window.location.href = '{{ route('profile') }}'; // Redirect to index page
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
