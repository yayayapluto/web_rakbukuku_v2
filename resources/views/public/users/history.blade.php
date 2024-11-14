@extends("layouts.public")
@section('title', 'History')

@section("content")
<h1 class="font-semibold items-center flex justify-center mb-8">Your Borrow History</h1>

<div class="flex overflow-x-auto justify-center gap-4 mb-12">
    @forelse ($records as $record)
    <div class="p-4 w-[150px] h-auto rounded-xl border border-gray-200 hover:drop-shadow-md bg-white">
            <div class="flex items-center">
                <img src="{{ $record->book->cover }}" alt="Book cover" class="w-[128px] h-[165px] rounded-xl">
            </div>
            <div class="mt-2">
                <p class="text-neutral-500 text-xs font-medium">{{ $record->book->title }}</p>
                <p class="text-xs font-medium">{{ ucfirst($record->status) }}</p>
            </div>
            <div class="mt-4">
                <p class="font-bold">{{ \Carbon\Carbon::parse($record->borrow_date) ->format('M d, Y') }}</p>
		<p class="font-bold">{{ \Carbon\Carbon::parse($record->return_date)->format('M d, Y') }}</p>
            </div>
    </div>
    @empty
    <p>You have no borrowing history.</p>
    @endforelse
</div>
@endsection