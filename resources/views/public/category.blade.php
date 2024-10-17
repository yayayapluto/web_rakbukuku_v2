@extends("layouts.public")
@section('title', 'Category detail')

@section("content")
    <h1>{{ $category->name }}</h1>
    <p>Description: {{ $category->description ?? 'No description available.' }}</p> <!-- Add other properties as needed -->

    <h2>Books in this category:</h2>
    <ul>
        @forelse ($books as $book)
            <li>{{ $book->title }} by {{ $book->writer }}</li>
        @empty
            <li>No books available in this category.</li>
        @endforelse
    </ul>
@endsection
