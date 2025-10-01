<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Reserva System')</title>

    <!-- Tailwind CSS (RAPIDO PARA DESARROLLO) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts 
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

     Styles 
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

     Scripts 
    <script src="{{ asset('js/app.js') }}" defer></script>
-->
</head>

<body class="bg-gray-100 text-gray-800">
    <div class=" min-h-screen bg-gray-100">

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold"><a href="{{ url('/') }}">Reserva System</a></h1>
                <nav>
                    <a href="{{ route('resources.index') }}" class="mr-4">Resources</a>
                    <!-- aquí más enlaces cuando tengamos más módulos -->
                </nav>
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="container mx-auto px-4 py-6">
            @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white shadow mt-8">
            <div class="container mx-auto px-4 py-4 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} Reserva System. All rights reserved.
            </div>
        </footer>
    </div>
</body>