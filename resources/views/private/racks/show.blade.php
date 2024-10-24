@extends('layouts.private')

@section('title', 'Rack Details')

@section('content')
    <h1>Rack Details</h1>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Rack ID:</strong> {{ $rack->rack_id }}
            </div>
            <div class="mb-1">
                <strong>Name:</strong> {{ $rack->name }}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('racks.edit', $rack->rack_id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('racks.index') }}" class="btn btn-secondary">Back to Racks</a>
        </div>
    </div>
@endsection
