@extends("layouts.public")
@section('title', 'All Categories')

@section("content")
    <h1>Categories</h1>
    <ul>
        @forelse ($categories as $category)
            <li>
                <a href="{{ route('categories.detail', ['name' => $category->name]) }}">
                    {{ $category->name }}
                </a>
            </li>
        @empty
            <li>No categories available.</li>
        @endforelse
    </ul>
@endsection
