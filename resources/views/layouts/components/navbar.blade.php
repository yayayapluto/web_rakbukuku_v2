<!-- ===== Navbar Start ===== -->
@php
use Illuminate\Support\Facades\Auth;
@endphp

<navbar class="fixed top-0 z-40 w-full bg-white h-20">
    <div class="l-container mx-auto px-4">
        <div class="mt-4 flex items-center justify-evenly ">
            <!-- Logo -->
            <div class="w-2/12 text-center">
                <a href="{{route("home")}}">
                    <span class="font-bold text-lg">RakbBukuKu</span>
                </a>
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
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-600 rounded-full" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                        </svg>
                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="user-menu" class="absolute right-0 mt-2 w-64 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <div class="p-4 text-start flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                            </svg>
                            <div class="">
                                <p class="mt-2 font-semibold text-gray-700">{{$user->name}}</p>
                                <p class="text-sm text-gray-500">{{$user->email}}</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-200">
                            <a href="{{ route('profile.history') }}" class="flex items-center justify-between px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                <span>History</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{route("logout")}}" class="flex items-center justify-between px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <span>Keluar Akun</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                        </div>
                    </div>
                </div>
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

    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    userMenuButton.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', (event) => {
        if (!event.target.closest('#user-menu-button') && !event.target.closest('#user-menu')) {
            userMenu.classList.add('hidden');
        }
    });
</script>