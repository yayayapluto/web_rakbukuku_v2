@extends('layouts.public')
@section('title', 'Home')
@section('content')
@vite('resources/css/app.css')


<button @click="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 rounded-full p-2 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
</button>
<button @click="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 rounded-full p-2 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
</button>


<!-- Banner -->
<div class="flex justify-center items-center  mt-2 cursor-pointer gap-x-5">
    <!-- Swiper container on the left -->
    <div class="w-[800px] h-[500px] "> <!-- Reduced width slightly -->
        <div class="swiper-container relative flex justify-center items-center">
            <!-- Swiper slides -->
            <div class="swiper-wrapper">
                <div class="swiper-slide flex justify-center items-center hover-nav-trigger">
                    <img src="{{Storage::url('banner.jpg')}}" alt="" class="rounded-xl h-[400px] w-[800px] ">
                </div>
                <div class="swiper-slide flex justify-center items-center hover-nav-trigger">
                    <img src="{{Storage::url('banner.jpg')}}" alt="" class="rounded-xl h-[400px] w-[800px]">
                </div>
                <div class="swiper-slide flex justify-center items-center hover-nav-trigger">
                    <img src="{{Storage::url('banner.jpg')}}" alt="" class="rounded-xl h-[400px] w-[800px]">
                </div>
            </div>

            <!-- Pagination and navigation -->
            <div class="swiper-pagination absolute z-10 text-white" style="bottom: 20%"></div>
            <div class="swiper-button-prev nav-button hover:!opacity-100"></div>
            <div class="swiper-button-next nav-button hover:!opacity-100"></div>
        </div>
    </div>

    <!-- Right side with two stacked images -->
    <div class="flex flex-col space-y-3 mr-2">
        <div class="w-[300px] h-[191px] flex items-center">
            <img src="{{Storage::url('banner.jpg')}}" alt="" class="rounded-xl object-cover w-full h-full">
        </div>
        <div class="w-[300px] h-[191px] flex items-center">
            <img src="{{Storage::url('banner.jpg')}}" alt="" class="rounded-xl object-cover w-full h-full">
        </div>
    </div>
</div>


<!-- Kategori -->
<div class="w-full overflow-x-auto scrollbar-hide">
    <div class="flex gap-4 p-4 justify-center items-center">
        </a>
        @forelse ($categories as $cat)
        <a href="{{route("categories.detail", $cat->name)}}" class="flex-none w-[152px] h-[176px] p-4 flex flex-col items-center no-underline rounded-lg hover:shadow-md transition-shadow duration-200">
            <img class="w-24 h-24 object-contain mb-2" src="{{Storage::url($cat->image)}}" alt="Buku Baru Andalan">
            <p class="text-gray-600 text-center text-sm h-9 m-0 leading-tight overflow-hidden line-clamp-2">{{$cat->name}}</p>
        </a>
        @empty
        <li><b>No books available.</b></li>
        @endforelse
    </div>
</div>

<div class="relative mx-44 mt-4 mb-4 flex items-center justify-start">
    <span class="text-neutral-700 text-2xl font-extrabold">Buku Terlaris</span>
</div>

<div class="flex items-center justify-center flex-wrap gap-4">
    @forelse ($mostBorrowedBooks as $most)
    <div class="p-4 w-[150px] h-auto rounded-xl border border-gray-200 hover:drop-shadow-md bg-white">
        <a href="{{route('books.detail', $most->title)}}">
            <div class="flex items-center">
                <img src="{{($most->cover)}}" alt="Book cover" class="w-[128px] h-[165px] rounded-xl">
            </div>
            <div class="mt-2">
                <p class="text-neutral-500 text-xs font-medium">{{$most->writer}}</p>
                <p class="text-xs font-medium">{{$most->title}}</p>
            </div>
            <div class="mt-4">
                <p class="font-bold">Detail</p>
            </div>
        </a>
    </div>
    @empty
    <li><b>No books available.</b></li>
    @endforelse
</div>

<div class="relative mx-44 mt-4 mb-4 flex items-center justify-start">
    <span class="text-neutral-700 text-2xl font-extrabold">Rekomendasi Buku</span>
</div>

<div class="flex overflow-x-auto justify-center gap-4 mb-12">
    @forelse ($books as $most)
    <div class="p-4 w-[150px] h-auto rounded-xl border border-gray-200 hover:drop-shadow-md bg-white">
        <a href="{{ route('books.detail', $most->title) }}">
            <div class="flex items-center">
                <img src="{{ $most->cover }}" alt="Book cover" class="w-[128px] h-[165px] rounded-xl">
            </div>
            <div class="mt-2">
                <p class="text-neutral-500 text-xs font-medium">{{ $most->writer }}</p>
                <p class="text-xs font-medium">{{ $most->title }}</p>
            </div>
            <div class="mt-4">
                <p class="font-bold">Detail</p>
            </div>
        </a>
    </div>
    @empty
    <li><b>No books available.</b></li>
    @endforelse
</div>

<div class="relative mx-44 mt-4 mb-4 flex items-center justify-start">
    <span class="text-neutral-700 text-2xl font-extrabold">Author Populer</span>
</div>

<!-- Author Populer -->

@forelse ($popularAuthors as $populer)
<div class="bg-white rounded-t-2xl shadow p-4 flex items-center justify-between max-w-sm mb-16 ml-48">
    <div class="flex items-center gap-3">
        <div class="relative">
            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                <span class="text-teal-800 text-lg">👨</span>
            </div>
        </div>

        <div class="flex flex-col">
            <span class="font-semibold text-gray-800">{{$populer->writer}}</span>
            <span class="text-sm text-gray-500">{{$populer->borrow_count}} orang meminjam</span>
        </div>
    </div>

    <div class="bg-amber-400 p-2 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
        </svg>
    </div>
    @empty
    <li><b>No Author available.</b></li>
    @endforelse
</div>

<div class="relative mx-44 mt-4 mb-4 flex items-center justify-start">
    <span class="text-neutral-700 text-2xl font-extrabold">User Paling Aktif</span>
</div>

<!-- User Populer -->
@forelse ($mostActiveUsers as $active)
<div class="bg-white rounded-t-2xl shadow p-4 flex items-center justify-between max-w-sm mb-10 ml-48">
    <div class="flex items-center gap-3">
        <div class="relative">
            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                <span class="text-teal-800 text-lg">👨</span>
            </div>
        </div>

        <div class="flex flex-col">
            <span class="font-semibold text-gray-800">{{$active->name}}</span>
            <span class="text-sm text-gray-500">{{$active->borrow_count}}</span>
        </div>
    </div>

    <div class="bg-amber-400 p-2 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
        </svg>
    </div>
    @empty
    <li><b>No Author available.</b></li>
    @endforelse
</div>




@endsection

@section('scripts')
<script>
    const swiper = new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        grabCursor: false,
        freeMode: false,
        keyboard: {
            enabled: true
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
    });

    const slides = document.querySelectorAll('.hover-nav-trigger');
    const navButtons = document.querySelectorAll('.nav-button');

    slides.forEach(slide => {
        slide.addEventListener('mouseenter', () => {
            navButtons.forEach(button => {
                button.classList.remove('opacity-0');
                button.classList.add('opacity-100');
            });
        });

        slide.addEventListener('mouseleave', () => {
            navButtons.forEach(button => {
                button.classList.remove('opacity-100');
                button.classList.add('opacity-0');
            });
        });
    });
</script>
@endsection

<style>
    .swiper-button-next::after,
    .swiper-button-prev::after {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        opacity: 0.9;
        border-radius: 50%;
        color: white;
        background: #FFFFFF !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2) !important;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .swiper-container {
        width: 100%;
        height: 500px;
        overflow: hidden;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        color: black !important;
    }

    .swiper-pagination-bullet {
        background-color: white !important;
    }

    img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .scrollbar-hide {
        scrollbar-width: none;
    }

    /* For Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* For IE, Edge */
    .scrollbar-hide {
        -ms-overflow-style: none;
    }
</style>