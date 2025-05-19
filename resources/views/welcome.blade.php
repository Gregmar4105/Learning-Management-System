<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-black min-h-screen">

    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-6">
        <!-- Logos Side by Side -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/philsca-logo.png') }}" alt="ICS Logo" class="h-15 w-14">
            <img src="{{ asset('images/ICS.png') }}" alt="ICS Logo" class="mt-3 h-17 w-16" >
        </div>

        <!-- Navigation -->
        @if (Route::has('login'))
            <nav class="space-x-4 hidden md:flex items-center">

                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="px-4 py-2 border border-black text-black font-semibold rounded hover:bg-black hover:text-white transition"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="px-4 py-2 bg-black text-white font-semibold rounded shadow hover:bg-gray-800 transition"
                    >
                        Log in
                    </a>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center px-4 py-20">
        <p class="uppercase tracking-widest text-lg mb-2">ASRAD & QA | AIM</p>
        <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">Learning Management System</h1>
        <p class="text-lg md:text-xl text-gray-700 max-w-2xl mb-8">
            Designed to streamline education by providing an easy-to-use platform for students, teachers, and administrators. It supports course management and file sharing — all in one place.
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-black text-white font-semibold rounded hover:bg-gray-800 transition">Log In</a>
            <a href="{{ route('about-us') }}" class="px-6 py-3 border border-black text-black font-semibold rounded hover:bg-black hover:text-white transition">About Us</a>
        </div>
    </section>

</body>
<footer class="flex flex-col items-center justify-center text-center mt-20">
     <p>© 2025 Web Application developed by BSAIT 2-3 Resurreccion Group Inc.</p>
</footer>
</html>
