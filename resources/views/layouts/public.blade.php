<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>RakBukuKu || @yield('title')</title>
</head>

<body>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            @include("layouts.components.navbar")

            <!-- ===== Main Content Start ===== -->
            <main class="mt-20"> <!-- Adjust this margin as needed -->
                @yield("content")
            </main>
            <!-- ===== Main Content End ===== -->

        </div>
        <!-- ===== Content Area End ===== -->

    </div>
    <!-- ===== Page Wrapper End ===== -->
</body>

</html>
