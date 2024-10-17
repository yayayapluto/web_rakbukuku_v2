@extends('layouts.public')

@section('title', 'Sign In')

@section('content')
    <div class="mx-auto my-12 max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb Start -->
        <div class="m-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black">
                Sign In
            </h2>
        </div>
        <!-- Breadcrumb End -->

        <!-- ====== Forms Section Start -->
        <div class="rounded-sm border border-stroke bg-white shadow-default">
            <div class="flex flex-wrap items-center">
                <div class="hidden w-full xl:block xl:w-1/2">
                    <div class="px-26 py-17.5 text-center">
                        <span class="my-10 inline-block">
                            <img class="object-cover rounded-md" src="{{ asset('assets/login.jpeg') }}"
                                alt="illustration" />
                        </span>
                    </div>
                </div>
                <div class="w-full border-stroke xl:w-1/2 xl:border-l-2">
                    <div class="w-full p-10 sm:p-12.5 xl:p-17.5">
                        <span class="mb-1.5 block font-medium">Mulai literasi..</span>
                        <h2 class="mb-9 text-2xl font-bold text-black sm:text-title-xl2">
                            Masuk ke RakBukuKu!!!
                        </h2>

                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="mb-2.5 block font-medium text-black">Email</label>
                                <div class="relative">
                                    <input type="email" name="email" placeholder="Enter your email"
                                        class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none" />
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="mb-2.5 block font-medium text-black">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" placeholder="6+ Characters, 1 Capital letter"
                                        class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none" />
                                </div>
                            </div>

                            <div class="mb-5">
                                <input type="submit" value="Sign In"
                                    class="w-full cursor-pointer rounded-lg border border-primary bg-blue-500 p-4 font-medium text-black transition hover:bg-opacity-90" />
                                
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== Forms Section End -->
    </div>
@endsection
