{{-- resources\views\admin\layout.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<header>
    <strong>Admin Panel</strong>
    <nav>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
    </nav>
</header>

<hr>

@if (session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

<main>
    @yield('content')
</main>

</body>
</html>
