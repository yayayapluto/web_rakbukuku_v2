@extends('layouts.public')
@section('title', 'Book Detail')

@section('content')
    <div class="w-[1000px] h-auto mt-8 ml-48">
        <div class="flex">
            <div class="flex-col">
                @if ($book->cover)
                    <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}" class="w-[280px] h-[400px]" />
                @endif
            </div>
            <div class="flex-grow ml-16">
                <p class="text-sm font-semibold text-[#0060AE] mb-1 mt-16">{{ $book->writer }}</p>
                <h1 class="text-3xl font-extrabold text-neutral-600">{{ $book->title }}</h1>
                <p class="text-[16px] font-semibold text-neutral-700 mt-5 mb-4">Deskripsi</p>
                <p class="text-sm font-medium text-neutral-500 mb-2">{{ $book->description ?? 'No description available.' }}</p>
                <p class="text-[16px] font-semibold text-neutral-700 mb-4">Detail Buku</p>
                <div class="flex flex-wrap gap-y-4 gap-x-16">
                    <div class="basis-1/2">
                        <p><strong>Publisher:</strong> <br> {{ $book->publisher }}</p>
                    </div>
                    <div>
                        <p><strong>Published Year:</strong> <br> {{ $book->publish_year }}</p>
                    </div>
                    <div class="basis-1/2">
                        <p><strong>ISBN:</strong> <br> {{ $book->isbn }}</p>
                    </div>
                    <div>
                        <a href="{{ route('categories.detail', $book->category->name) }}">
                            <p><strong>Category:</strong> <br> {{ $book->category->name ?? 'Unknown' }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!Auth::user()->is_admin)
        <div class="fixed bottom-10 left-0 right-0 w-full bg-white ">
            <div class="mx-auto w-[1216px] h-[150px] bg-white drop-shadow-2xl rounded-xl">
                <div class="flex items-center gap-4 h-full p-4">
                    <div class="relative h-24 w-16 shrink-0">
                        @if ($book->cover)
                            <img src="{{ asset($book->cover) }}" alt="{{ $book->title }} cover" class="rounded object-contain h-full w-full" />
                        @endif
                    </div>
                    <div class="flex flex-col min-w-0 grow gap-1">
                        <div class="flex gap-2">
                            <span class="text-neutral-500 bg-neutral-50 text-xs rounded py-[2px] px-1 flex items-center gap-1">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11 1H5a2 2 0 0 0-2 2v10c0 1.1.9 2 2 2h7.5a.5.5 0 0 0 0-1H5a1 1 0 0 1-1-1h8.5a.5.5 0 0 0 .5-.5V3a2 2 0 0 0-2-2Z" />
                                </svg>
                                {{ $book->isbn }}
                            </span>
                            <span class="text-neutral-500 bg-neutral-50 text-xs rounded py-[2px] px-1 flex items-center gap-1">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10 10v1h1v-1h-1ZM4.19 1.11l-2.5 2c-.17.13-.19.36-.19.56V5.5c0 .56.19 1.08.5 1.5v7.5c0 .28.22.5.5.5H4V9.5c0-.28.22-.5.5-.5h3c.28 0 .5.22.5.5V15h5.5a.5.5 0 0 0 .5-.5V7c.31-.42.5-.94.5-1.5V3.67c0-.2-.02-.43-.19-.56l-2.5-2A.5.5 0 0 0 11.5 1h-7a.5.5 0 0 0-.31.11Z" />
                                </svg>
                                {{ $book->stock }}
                            </span>
                        </div>
                        <div class="text-xs text-neutral-500 truncate">{{ $book->writer }}</div>
                        <div class="text-lg font-medium text-neutral-700 truncate">{{ $book->title }}</div>
                    </div>

                    @auth
                        <div class="ml-auto">
                            @if (is_null($record) || $record->status == "return")
                                <button class="bg-[#0060AE] hover:bg-[#004681] active:bg-[#003561] text-white py-3 px-4 text-sm font-bold w-[186px] flex justify-center items-center gap-2 rounded-xl"
                                    id="borrowButton" data-action="borrow">
                                    <svg fill="currentColor" class="h-5 w-5" viewBox="0 0 20 20">
                                        <path d="M10.5 2.75a.75.75 0 0 0-1.5 0V9H2.75a.75.75 0 0 0 0 1.5H9v6.25a.75.75 0 0 0 1.5 0V10.5h6.25a.75.75 0 0 0 0-1.5H10.5V2.75Z" />
                                    </svg>
                                    Pinjam
                                </button>
                            @elseif ($record && $record->status == 'borrow')
                                <button class="bg-[#0060AE] hover:bg-[#004681] active:bg-[#003561] text-white py-3 px-4 text-sm font-bold w-[186px] flex justify-center items-center gap-2 rounded-xl"
                                    id="returnButton" data-action="return">
                                    <svg fill="currentColor" class="h-5 w-5" viewBox="0 0 20 20">
                                        <path d="M10.5 2.75a.75.75 0 0 0-1.5 0V9H2.75a.75.75 0 0 0 0 1.5H9v6.25a.75.75 0 0 0 1.5 0V10.5h6.25a.75.75 0 0 0 0-1.5H10.5V2.75Z" />
                                    </svg>
                                    Kembalikan
                                </button>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    @endif
@endsection

@section("scripts")
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const borrowButton = document.getElementById('borrowButton');
    const returnButton = document.getElementById('returnButton');

    const handleBookAction = (action) => {
        const bookId = "{{ $book->book_id }}";
        const url = action === 'borrow' ? '{{ route('borrow.submit', ':bookId') }}' : '{{ route('return.submit', ':bookId') }}';
        const finalUrl = url.replace(':bookId', bookId);

        console.log(`Attempting ${action} action for book ID: ${bookId}`);

        fetch(finalUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ action: action })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);

            if (data.success) {
                console.log(`${action} action successful.`);

                if (action === 'borrow' && borrowButton && returnButton) {
                    borrowButton.classList.add('hidden');
                    returnButton.classList.remove('hidden');
                } else if (action === 'return' && borrowButton && returnButton) {
                    returnButton.classList.add('hidden');
                    borrowButton.classList.remove('hidden');
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                });

                // Redirect to the new route provided by the server (res.route)
                if (data.route) {
                    location.href = data.route;
                }
            } else {
                console.log(`Error during ${action} action: ${data.message}`);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            console.error('Error during fetch request:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.',
            });
        });
    };

    if (borrowButton) {
        borrowButton.addEventListener('click', function() {
            console.log('Borrow button clicked');
            handleBookAction('borrow');
        });
    }

    if (returnButton) {
        returnButton.addEventListener('click', function() {
            console.log('Return button clicked');
            handleBookAction('return');
        });
    }
});

</script>
@endsection