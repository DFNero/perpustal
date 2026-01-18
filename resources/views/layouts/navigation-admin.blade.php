{{-- Admin Navigation with Sidebar --}}
<div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col">
    
    <!-- Header -->
    <header class="bg-white border-b border-orange-200 sticky top-0 z-40 shadow-sm">
        <div class="px-6 py-4 flex items-center justify-between">
            <!-- Logo + Sidebar Toggle -->
            <div class="flex items-center gap-4">
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-2 hover:bg-orange-50 rounded-lg transition-colors duration-200"
                    title="Toggle sidebar"
                >
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3" y1="6" y2="6"/><line x1="3" x2="3" y1="12" y2="12"/><line x1="3" x2="3" y1="18" y2="18"/></svg>
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg text-orange-600 hover:text-orange-700 transition-colors">
                    ⚙️ Admin Panel
                </a>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-md mx-6">
                <form action="{{ route('admin.books.index') }}" method="GET" class="relative">
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari buku..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                        value="{{ request('search') }}"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-2.5 text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </form>
            </div>

            <!-- Right: Notifications + Profile -->
            <div class="flex items-center gap-6">
                <!-- Notifications -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="relative p-2 hover:bg-gray-100 rounded-lg transition"
                        title="Notifications"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21h3.4"/></svg>
                        @if (auth()->user()->unreadNotifications->count())
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div
                        x-cloak
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg border border-gray-200 z-50"
                    >
                        @forelse (auth()->user()->unreadNotifications as $notif)
                            <div class="p-4 border-b text-sm hover:bg-gray-50 transition">
                                <p class="text-gray-700">
                                    Buku <b>{{ $notif->data['book_title'] }}</b>
                                    @if ($notif->data['status'] === 'approved')
                                        <span class="text-green-600 font-semibold">disetujui</span>
                                    @elseif ($notif->data['status'] === 'rejected')
                                        <span class="text-red-600 font-semibold">ditolak</span>
                                    @elseif ($notif->data['status'] === 'returned')
                                        <span class="text-blue-600 font-semibold">sudah dikembalikan</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <div class="p-4 text-sm text-gray-500 text-center">
                                Tidak ada notifikasi
                            </div>
                        @endforelse

                        @if (auth()->user()->unreadNotifications->count())
                            <div class="p-3 text-center border-t">
                                <form method="POST" action="/notifications/read" style="display:inline">
                                    @csrf
                                    <button class="text-xs text-blue-600 hover:underline">
                                        Tandai semua dibaca
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                @endauth

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-circle"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
                        <span class="text-sm font-medium text-gray-700 hidden sm:inline">{{ Auth::user()->name }}</span>
                    </button>

                    <!-- Profile Menu -->
                    <div
                        x-cloak
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg border border-gray-200 z-50"
                    >
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 first:rounded-t-lg">
                            🔧 Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 last:rounded-b-lg border-t">
                                🚪 Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside
            x-show="sidebarOpen"
            @click.outside="sidebarOpen = false"
            x-transition
            class="w-64 bg-gray-900 text-gray-100 flex flex-col fixed md:static inset-y-0 left-0 mt-16 md:mt-0 z-30 md:z-0 shadow-lg"
        >
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.books.*') ? 'bg-orange-600 hover:bg-orange-700' : 'hover:bg-gray-800' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    <span class="font-medium">Books</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-orange-600 hover:bg-orange-700' : 'hover:bg-gray-800' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3" y1="6" y2="6"/><line x1="3" x2="3" y1="12" y2="12"/><line x1="3" x2="3" y1="18" y2="18"/></svg>
                    <span class="font-medium">Categories</span>
                </a>

                <a href="{{ route('admin.libraries.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.libraries.*') ? 'bg-orange-600 hover:bg-orange-700' : 'hover:bg-gray-800' }} transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span class="font-medium">Libraries</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="border-t border-gray-700 px-4 py-4">
                <p class="text-xs text-gray-400">Admin: {{ Auth::user()->name }}</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-200 px-6 py-4">
                    {{ $header }}
                </header>
            @endisset

            <!-- Page Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
