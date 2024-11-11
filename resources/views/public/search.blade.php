@extends("layouts.public")
@section('title', "Search for: $query")

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

    .all-categories {
        display: none;
        position: relative;
        z-index: 2;
        background: white;
    }

    .all-categories.show {
        display: block;
    }

    .nested-menu-item {
        position: relative;
        border-bottom: 1px solid #E5E7EB;
    }

    .nested-menu-item .dropdown-toggle {
        padding-left: 20px;
    }

    .nested-menu-item .submenu-item {
        padding-left: 32px;
    }

    .search-results {
        margin-left: 270px;
        padding: 20px;
    }

    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .book-card {
        transition: transform 0.2s;
    }

    .book-card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="flex">
    @forelse ($books as $book)
    @if ($loop->first)
    <aside class="aside-menu">
        <div class="filter-title">Filter</div>
        <div class="kategori-title">Kategori</div>

        <div class="menu-item">
            <button class="dropdown-toggle" id="bookToggle">
                Buku
                <span class="arrow"></span>
            </button>
            <div class="all-categories">
                @forelse ($categories as $cat)
                <div class="nested-menu-item">
                    <button class="dropdown-toggle">
                        {{ $cat->name }}
                        <span class="arrow"></span>
                    </button>
                    @if($cat->subcategories && count($cat->subcategories) > 0)
                    <div class="submenu">
                        @foreach($cat->subcategories as $sub)
                        <div class="submenu-item">{{ $sub->name }}</div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @empty
                <div class="nested-menu-item">
                    <div class="submenu-item">No categories found</div>
                </div>
                @endforelse
            </div>
        </div>
    </aside>
    @endif

    @if ($loop->first)
    <div class="search-results">
        <h1 class="font-urbanist font-medium text-neutral-700 text-lg">Hasil Pencarian <strong>"{{ $query }}"</strong></h1>
        <div class="results-grid">
            @endif

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

            @if ($loop->last)
        </div>
    </div>
    @endif

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

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookToggle = document.getElementById('bookToggle');
        const allCategories = document.querySelector('.all-categories');
        const nestedDropdowns = document.querySelectorAll('.nested-menu-item .dropdown-toggle');

       
        if (bookToggle) {
            bookToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('active');
                allCategories.classList.toggle('show');
            });
        }

        
        nestedDropdowns.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

               
                this.classList.toggle('active');
                const submenu = this.nextElementSibling;
                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('show');
                }

               
                nestedDropdowns.forEach(otherToggle => {
                    if (otherToggle !== this) {
                        otherToggle.classList.remove('active');
                        const otherSubmenu = otherToggle.nextElementSibling;
                        if (otherSubmenu && otherSubmenu.classList.contains('submenu')) {
                            otherSubmenu.classList.remove('show');
                        }
                    }
                });
            });
        });

        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.aside-menu')) {
                bookToggle.classList.remove('active');
                allCategories.classList.remove('show');
                nestedDropdowns.forEach(toggle => {
                    toggle.classList.remove('active');
                    const submenu = toggle.nextElementSibling;
                    if (submenu && submenu.classList.contains('submenu')) {
                        submenu.classList.remove('show');
                    }
                });
            }
        });

        
        const submenus = document.querySelectorAll('.submenu');
        submenus.forEach(submenu => {
            submenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endsection