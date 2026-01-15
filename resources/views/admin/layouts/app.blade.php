<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen">

    {{-- Admin Navbar --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">
            <strong>Admin Panel</strong>

            <nav class="space-x-4">
                <a href="{{ route('admin.categories.index') }}">Categories</a>
                <a href="{{ route('admin.libraries.index') }}">Libraries</a>
            </nav>
        </div>
    </header>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    {{-- Optional Page Header --}}
    @hasSection('header')
        <header class="max-w-7xl mx-auto px-6 py-6">
            <h2 class="text-xl font-semibold">
                @yield('header')
            </h2>
        </header>
    @endif

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto px-6 py-6">
        @yield('content')
    </main>

</div>

</body>
</html>
