@extends('layouts.private')

@section('title', 'Book Details')

@section('content')
    <h1>Book Details</h1>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Book ID:</strong> {{ $book->book_id }}
            </div>
            <div class="mb-3">
                <strong>Title:</strong> {{ $book->title }}
            </div>
            <div class="mb-3">
                <strong>Author:</strong> {{ $book->writer }}
            </div>
            <div class="mb-3">
                <strong>Publisher:</strong> {{ $book->publisher }}
            </div>
            <div class="mb-3">
                <strong>Publish Year:</strong> {{ $book->publish_year }}
            </div>
            <div class="mb-3">
                <strong>Stock:</strong> {{ $book->stock }}
            </div>
            <div class="mb-3">
                <strong>Cover URL:</strong> <a href="{{ $book->cover }}" target="_blank">{{ $book->cover }}</a>
            </div>
            <div class="mb-3">
                <strong>Soft File URL:</strong> <a href="{{ $book->soft_file }}" target="_blank">{{ $book->soft_file }}</a>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Books</a>
        </div>
    </div>
@endsection
