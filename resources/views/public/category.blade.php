@extends("layouts.public")
@section('title', "Category detail")

@section("content")
<style>
    .aside-menu {
        width: 250px;
        background: white;
        padding: 20px;
        font-family: Arial, sans-serif;
        position: fixed;
        left: 0;
        top: 100px;
        z-index: 10;
    }

    .main-content {
        margin-left: 300px;
        padding: 20px;
        width: calc(100% - 270px);
        margin-top: 100px;
    }

    .filter-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .kategori-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .menu-item {
        border-bottom: 1px solid #E5E7EB;
        margin: 0;
        position: relative;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        padding: 12px 8px;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        color: #333;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }

    .dropdown-toggle:hover {
        background-color: #f5f5f5;
    }

    .dropdown-toggle .arrow {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropdown-toggle .arrow::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        border-right: 2px solid #333;
        border-bottom: 2px solid #333;
        transform: rotate(45deg);
        transition: transform 0.3s ease;
        margin-top: -4px;
    }

    .dropdown-toggle.active .arrow::before {
        transform: rotate(-135deg);
        margin-top: 4px;
    }

    .submenu {
        display: none;
        position: relative;
        background: white;
        z-index: 3;
        padding-left: 20px;
    }

    .submenu.show {
        display: block;
    }

    .submenu-item {
        padding: 8px;
        cursor: pointer;
        color: #666;
        font-size: 14px;
    }

    .submenu-item:hover {
        color: #000;
    }

    .book-card {
        transition: transform 0.2s;
    }

    .book-card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="flex">
    <!-- Filter / Aside Menu -->
    <aside class="aside-menu">
        <div class="filter-title">Filter</div>
        <div class="kategori-title">Kategori</div>

        <div class="menu-item">
            <button class="dropdown-toggle" id="categoryToggle">
                Buku
                <span class="arrow"></span>
            </button>
            <div class="all-categories submenu">
                @forelse ($categories as $cat)
                <a href="{{ route('categories.detail', $cat->name) }}">
                    <div class="submenu-item">{{ $cat->name }}</div>
                </a>
                @empty
                <div class="submenu-item">No categories found</div>
                @endforelse
            </div>
        </div>
    </aside>

    <!-- Books Section -->
    <div class="main-content">
        <h1 class="font-urbanist font-medium text-neutral-700 text-lg">{{ $category->name }}</h1>
        <p class="text-neutral-500">Description: {{ $category->description ?? 'No description available.' }}</p>

        <h2 class="mt-6 font-urbanist font-medium text-neutral-700 text-lg">Books in this category:</h2>
        <div class="flex justify-start gap-x-5 mt-5">
            @forelse ($books as $book)
            <div class="p-4 w-[170px] h-auto rounded-xl border border-gray-200 hover:drop-shadow-md bg-white">
                <a href="{{ route('books.detail', $book->title) }}">
                    <div class="flex items-center justify-center">
                        <img src="{{ $book->cover }}" alt="Book cover" class="w-[120px] h-[165px] rounded-xl items-center justify-center">
                    </div>
                    <div class="mt-2 ml-2">
                        <p class="text-neutral-500 text-xs font-medium">{{ $book->writer }}</p>
                        <p class="text-xs font-medium">{{ $book->title }}</p>
                    </div>
                    <div class="mt-4 ml-2">
                        <p class="font-bold">Detail</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="flex items-center justify-center w-full mt-16 gap-x-5">
                <img src="https://i.pinimg.com/736x/b2/ec/71/b2ec71a7f323b9e54ef96ce7dfc06cae.jpg" alt="page not found" class="w-[250px] h-auto">
                <div class="mb-20">
                    <h1 class="font-urbanist font-extrabold text-neutral-700 text-lg">No books available in this category</h1>
                    <p class="text-neutral-500 text-sm">Please check back later.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryToggle = document.getElementById('categoryToggle');
        const allCategories = document.querySelector('.all-categories');
        const submenuItems = document.querySelectorAll('.submenu-item');

        if (categoryToggle) {
            categoryToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('active');
                allCategories.classList.toggle('show');
            });
        }

        submenuItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.aside-menu')) {
                categoryToggle.classList.remove('active');
                allCategories.classList.remove('show');
            }
        });
    });
</script>
@endsection