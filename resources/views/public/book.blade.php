@extends("layouts.public")
@section('title', 'Book Detail')

@section("content")
    <h1>{{ $book->title }}</h1>
    <p><strong>Author:</strong> {{ $book->writer }}</p>
    <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
    <p><strong>Published Year:</strong> {{ $book->publish_year }}</p>
    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
    <p><strong>Stock:</strong> {{ $book->stock }}</p>
    <p><strong>Category:</strong> {{ $book->category->name ?? 'Unknown' }}</p> <!-- Assuming there's a relationship with Category -->

    @if($book->cover)
        <img src="{{ asset($book->cover) }}" alt="{{ $book->title }} cover" />
    @endif

    <h2>Description</h2>
    <p>{{ $book->description ?? 'No description available.' }}</p> <!-- Adjust this based on your Book model -->
@endsection
