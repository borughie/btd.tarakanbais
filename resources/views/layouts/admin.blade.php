<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard Admin' }} - SD Indo Tionghoa Tarakan</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif
    @livewireStyles
</head>

<body class="bg-[#FBF9F9] text-[#241B1B] antialiased font-['Plus_Jakarta_Sans',sans-serif]">
    <nav class="bg-linear-to-r from-[#B3202E] to-[#7A1620] shadow-lg shadow-[#B3202E]/10 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-17">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-[#E8C468]/40 shrink-0 overflow-hidden">
                        <img src="{{ asset('img/logo.webp') }}" alt="Logo SD" class="w-full h-full object-contain p-0.5" />
                    </div>
                    <div class="leading-tight">
                        <h1 class="font-['Fraunces',serif] text-white font-bold text-base">SD Indo Tionghoa Tarakan</h1>
                        <p class="text-[#E8C468] text-[10px] font-semibold uppercase tracking-[0.15em] mt-0.5">Dashboard
                            Admin</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <a href="{{ route('guest.checkin') }}"
                        class="text-white/80 hover:text-white text-sm font-medium transition relative after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-px after:bg-[#E8C468] after:transition-all hover:after:w-full">
                        Form Tamu
                    </a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-white/80 hover:text-white text-sm font-medium transition border border-white/20 hover:border-white/40 rounded-lg px-3.5 py-1.5">
                                Keluar
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>