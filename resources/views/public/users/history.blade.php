@extends("layouts.public")
@section('title', 'History')

@section("content")
    <h1>Your Borrow History</h1>

    @forelse ($records as $record)
        <div class="record-item">
            <p><strong>Book Title:</strong> {{ $record->book->title }}</p>
            <p><strong>ISBN:</strong> {{ $record->book->isbn }}</p>
            <p><strong>Status:</strong> {{ ucfirst($record->status) }}</p>
            <p><strong>Borrow Date:</strong> {{ \Carbon\Carbon::parse($record->borrow_date)->format('M d, Y') }}</p>
            <p><strong>Return Date:</strong> {{ \Carbon\Carbon::parse($record->return_date)->format('M d, Y') }}</p>
        </div>
        <br>
    @empty
        <p>You have no borrowing history.</p>
    @endforelse
@endsection
