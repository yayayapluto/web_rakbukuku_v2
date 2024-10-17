@extends('layouts.public')
@section('title', 'Home')

@section('content')
    <h1>Home</h1>

    <h2>Books</h2>
    <ul>
        @forelse ($books as $book)
            <li>
                <a href="{{ route('books.detail', ['title' => $book->title]) }}">
                    {{ $book->title }} by {{ $book->writer }}
                </a>
            </li>
        @empty
            <li><b>No books available.</b></li>
        @endforelse
    </ul>

    <h2>Categories</h2>
    <ul>
        @forelse ($categories as $category)
            <li>
                <a href="{{ route('categories.detail', ['name' => $category->name]) }}">
                    {{ $category->name }}
                </a>
            </li>
        @empty
            <li><b>No categories available.</b></li>
        @endforelse
    </ul>

    <h2>Most Borrowed Books</h2>
    <ul>
        @forelse ($mostBorrowedBooks as $book)
            <li>{{ $book->title }} by {{ $book->writer }}</li>
        @empty
            <li>No borrowed books available.</li>
        @endforelse
    </ul>

    <h2>Most Active Users</h2>
    <ul>
        @forelse ($mostActiveUsers as $user)
            <li>{{ $user->name }} ({{ $user->email }})</li>
        @empty
            <li>No active users available.</li>
        @endforelse
    </ul>


    <h2>Popular Authors</h2>
    <ul>
        @forelse ($popularAuthors as $author)
            <li>{{ $author->writer }} ({{ $author->borrow_count }})</li>
        @empty
            <li>No popular authors available.</li>
        @endforelse
    </ul>

@endsection
