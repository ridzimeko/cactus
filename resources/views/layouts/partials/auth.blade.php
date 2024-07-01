<div class="flex h-screen w-full">
    {{-- Form slot --}}
    <section class="h-full w-full overflow-auto bg-black p-10 lg:w-1/2">
        @yield('form')
    </section>

    {{-- Login Illustration Section --}}
    <section class="relative hidden w-full overflow-hidden bg-[#7f986f] text-[#111827] lg:block">
        <div class="mx-auto mb-12 mt-8 max-w-[65%] text-center">
            <h1 class="mb-4 text-5xl font-bold">@yield('header')</h1>
            <h3 class="text-2xl font-semibold">
                @yield('subheader')
            </h3>
        </div>

        <div class="mx-auto flex w-1/2 items-center justify-center">
            <img src="/img/login-illustration.svg" alt="Login illustration" class="h-full w-full" />
            <img class="absolute right-0 w-[25%]" src="/img/leaf.svg" alt="leafs" />
        </div>
    </section>

</div>
