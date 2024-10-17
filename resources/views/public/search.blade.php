@extends("layouts.public")
@section('title', "Search for: $query")

@section("content")
    <h1>Search Results for: "{{ $query }}"</h1>

    <ul>
        @forelse ($books as $book)
            <li>
                <a href="{{ route('books.detail', ['title' => $book->title]) }}">
                    {{ $book->title }} by {{ $book->writer }}
                </a>
            </li>
        @empty
            <li>No books found for your search.</li>
        @endforelse
    </ul>
@endsection
