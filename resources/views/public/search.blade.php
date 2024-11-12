@extends("layouts.public")
@section('title', "Search for: $query")

@section("content")

<div class="flex">
    @forelse ($books as $book)
    <div class="flex items-center ">
        <h1 class="font-urbanist font-medium text-neutral-700 text-lg">Hasil Pencarian <strong>"{{ $query }}"</strong></h1>
        <div class="results-grid">

            <div class="book-card p-4 w-[150px] h-auto rounded-xl border border-gray-200 hover:drop-shadow-md bg-white">
                <a href="{{route('books.detail', $book->title)}}">
                    <div class="flex items-center justify-center">
                        <img src="{{($book->cover)}}" alt="Book cover" class="w-[128px] h-[165px] rounded-xl object-cover">
                    </div>
                    <div class="mt-2">
                        <p class="text-neutral-500 text-xs font-medium">{{$book->writer}}</p>
                        <p class="text-xs font-medium">{{$book->title}}</p>
                    </div>
                    <div class="mt-4">
                        <p class="font-bold">Detail</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @empty
    <div class="flex items-center justify-center w-full mt-48 gap-x-5">
        <img src="https://i.pinimg.com/736x/b2/ec/71/b2ec71a7f323b9e54ef96ce7dfc06cae.jpg" alt="page not found" class="w-[250px] h-auto">
        <div class="mb-20">
            <h1 class="font-urbanist font-extrabold text-neutral-700 text-lg">Hasil Pencarian "{{ $query }}" Tidak Ditemukan</h1>
            <p class="text-neutral-500 text-sm">Coba kata kunci lain atau lihat rekomendasi yang mirip <br> dengan pencarian kamu di atas.</p>
        </div>
    </div>
    @endforelse
</div>

@endsection

