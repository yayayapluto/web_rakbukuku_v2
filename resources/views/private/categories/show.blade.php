@extends('layouts.private')

@section('title', 'Category Details')

@section('content')
    <h1>Category Details</h1>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Category ID:</strong> {{ $category->category_id }}
            </div>
            <div class="mb-1">
                <strong>Name:</strong> {{ $category->name }}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
        </div>
    </div>
@endsection
