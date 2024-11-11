<!-- ===== Navbar Start ===== -->
@php
use Illuminate\Support\Facades\Auth;
@endphp

<navbar class="fixed top-0 z-40 w-full bg-white h-20">
    <div class="l-container mx-auto px-4">
        <div class="mt-4 flex items-center justify-evenly ">
            <!-- Logo -->
            <div class="w-2/12 text-center">
                <span class="font-bold text-lg">RakbBukuKu</span>
            </div>

            <!-- Category Dropdown Button -->


            <!-- Search Bar -->
            <div class="flex w-4/12 relative">
                <form id="search-form" class="w-full relative">
                    <input type="text" id="search-input"
                        class="w-full h-12 pl-10 pr-4 rounded-full border border-neutral-200 bg-background text-sm placeholder:text-neutral-200 focus:border-neutral-700 focus:outline-none"
                        maxlength="50"
                        placeholder="Cari Produk, Judul Buku, atau Penulis" data-url="{{ route('search') }}">

                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.5 3a5.5 5.5 0 0 1 4.38 8.82l4.15 4.15a.75.75 0 0 1-.98 1.13l-.08-.07-4.15-4.15A5.5 5.5 0 1 1 8.5 3Zm0 1.5a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z"></path>
                    </svg>
                </form>
            </div>

            <!-- Authentication Links -->
            @if (Auth::check())
            @if (Auth::user()->is_admin)
            <div class="w-2/12 text-center">
                <a href="{{ route('admin.dashboard') }}">
                    <button class="relative inline-flex items-center font-bold bg-blue-500 text-white py-3 px-4 rounded">
                        Dashboard
                    </button>
                </a>
            </div>
            @else
            <div class="w-2/12 text-center">
                <a href="{{ route('profile.history') }}">
                    <button class="relative inline-flex items-center font-bold bg-white border border-neutral-200 text-neutral-700 py-3 px-4 rounded">
                        History
                    </button>
                </a>
                <a href="{{ route('profile') }}">
                    <button class="relative inline-flex items-center font-bold bg-blue-500 text-white py-3 px-4 rounded">
                        Profile
                    </button>
                </a>
            </div>
            @endif
            @else
            <div class="w-2/12 text-center">
                <a href="{{ route('register') }}">
                    <button class="relative inline-flex items-center font-bold bg-white border border-neutral-200 text-textColor py-3 px-4 rounded-xl">
                        Register
                    </button>
                </a>
                <a href="{{ route('login') }}">
                    <button class="relative inline-flex items-center font-bold bg-butonColor text-white py-3 px-4 rounded-xl">
                        Login
                    </button>
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="border-neutral-200 border-t-[1px]"></div>
</navbar>
<!-- ===== Navbar End ===== -->

<script>
    // Dropdown toggle functionality
    function toggleDropdown() {
        const dropdownContent = document.getElementById('dropdown-content');
        const dropdownIcon = document.getElementById('dropdown-icon');

        dropdownContent.classList.toggle('hidden');
        dropdownIcon.classList.toggle('rotate-180'); // Rotate icon when open
    }

    // Search form submission
    document.getElementById('search-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            const query = this.value;
            const url = this.getAttribute('data-url') + '?q=' + encodeURIComponent(query);
            window.location.href = url; // Redirect to the search URL
        }
    });
</script>