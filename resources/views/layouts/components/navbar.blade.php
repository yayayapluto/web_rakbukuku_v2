<!-- ===== Navbar Start ===== -->
<navbar class="fixed top-0 z-40 w-full bg-white h-20">
    <div class="l-container mx-auto px-4">
        <div class="my-4 flex items-center justify-evenly">
            <div class="w-2/12 text-center">
                <span class="font-bold text-lg">RakbBukuKu</span>
            </div>
            <div class="flex w-7/12">
                <form id="search-form" class="w-full">
                    <input type="text" id="search-input"
                        class="bg-background w-full rounded-lg border border-neutral-200 py-2 text-s-medium placeholder:text-neutral-200 focus:border-neutral-700 h-10 px-4"
                        placeholder="Search..." data-url="{{ route('search') }}">
                </form>
            </div>
            <div class="w-2/12 text-center">
                <div class="flex justify-center space-x-4">
                    <button
                        class="relative inline-flex items-center font-bold bg-white border border-neutral-200 text-neutral-700 py-3 px-4 rounded">
                        Login
                    </button>
                    <button
                        class="relative inline-flex items-center font-bold bg-blue-500 text-white py-3 px-4 rounded">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="border-neutral-200 border-t-[1px]"></div>
</navbar>
<!-- ===== Navbar End ===== -->

<script>
    document.getElementById('search-input').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            const query = this.value;
            const url = this.getAttribute('data-url') + '?q=' + encodeURIComponent(query);
            window.location.href = url; // Redirect to the search URL
        }
    });
</script>
