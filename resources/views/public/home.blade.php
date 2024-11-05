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
            <div class="swiper-button-prev nav-button hover:!opacity-100" ></div>
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



<h1>Home</h1>

<!-- Rest of your existing content -->

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
            delay: 3500,
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
</style>