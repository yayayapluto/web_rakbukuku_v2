@extends('layouts.public')

@section('title', 'Sign Up')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb Start -->
    <div class="m-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black">
            Sign Up
        </h2>
    </div>
    <!-- Breadcrumb End -->

    <!-- ====== Forms Section Start -->
    <div class="rounded-sm border border-stroke bg-white shadow-default">
        <div class="flex flex-wrap items-center">
            <div class="hidden w-full xl:block xl:w-1/2">
                <div class="px-10 py-6 text-center">
                    <span class="my-10 inline-block">
                        <img class="object-cover rounded-md" src="https://i.pinimg.com/736x/d6/23/91/d623916062eba3781fbfde80a579cdc6.jpg"
                            alt="illustration" />
                    </span>
                </div>
            </div>
            <div class="w-full border-stroke xl:w-1/2 xl:border-l-2">
                <div class="w-full p-6 sm:p-8 xl:p-10">
                    <span class="mb-1.5 block font-medium">Bergabunglah dengan kami..</span>
                    <h2 class="mb-6 text-xl font-bold text-black sm:text-title-xl2">
                        Daftar di RakBukuKu!!!
                    </h2>

                    <form>
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label class="mb-2 block font-medium text-black">Name</label>
                            <input type="text" id="input_name" name="name" placeholder="Enter your name"
                                class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-4 outline-none focus:border-primary"
                                required />
                        </div>

                        <div class="mb-3">
                            <label class="mb-2 block font-medium text-black">Email</label>
                            <input type="email" id="input_email" name="email" placeholder="Enter your email"
                                class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-4 outline-none focus:border-primary"
                                required />
                        </div>

                        <div class="mb-3">
                            <label class="mb-2 block font-medium text-black">Password</label>
                            <input type="password" id="input_password" name="password"
                                placeholder="6+ Characters, 1 Capital letter"
                                class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-4 outline-none focus:border-primary"
                                required />
                        </div>

                        <div class="mb-3">
                            <label class="mb-2 block font-medium text-black">Gender (optional)</label>
                            <input type="text" id="input_gender" name="gender"
                                placeholder="Enter your gender (optional)"
                                class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-4 outline-none focus:border-primary" />
                        </div>

                        <div class="mb-3">
                            <label class="mb-2 block font-medium text-black">Phone Number (optional)</label>
                            <input type="text" id="input_phone_number" name="phone_number"
                                placeholder="Enter your phone number (optional)"
                                class="w-full rounded-lg border border-stroke bg-transparent py-3 pl-4 outline-none focus:border-primary" />
                        </div>

                        <div class="mb-4">
                            <input type="submit" value="Sign Up"
                                class="w-full cursor-pointer rounded-lg border border-primary bg-blue-500 p-3 font-medium text-black transition hover:bg-opacity-90" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ====== Forms Section End -->
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("form").on("submit", function(e) {
            e.preventDefault();
            const name = $("#input_name").val();
            const email = $("#input_email").val();
            const password = $("#input_password").val();
            const gender = $("#input_gender").val();
            const phone_number = $("#input_phone_number").val();

            const formData = new FormData(this)

            $.ajax({
                url: '{{ route('register.submit') }}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    return Swal.fire({
                        icon: res.success ? "success" : "error",
                        title: res.success ? "Berhasil" : "Gagal",
                        html: `<p>${res.msg}</p>`,
                        position: "center",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    }).then(function() {
                        location.href = res.route
                    });
                },
                error: function(err) {
                    const res = err.responseJSON;
                    const message = res.msg || 'Terjadi kesalahan. Silakan coba lagi.';
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        html: `<p>${message}</p>`,
                        position: "center",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            })

            return true
        })
    })
</script>
@endsection