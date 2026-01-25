<div x-data="{ sidebarOpen: window.innerWidth > 1024 }" 
     @resize.window="sidebarOpen = window.innerWidth > 1024" 
     class="flex h-screen overflow-hidden bg-gray-100">

    <!-- Custom Scrollbar -->
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
    </style>

    <!-- Sidebar -->
    <aside
        :class="sidebarOpen ? 'w-72' : 'w-20'"
        class="z-30 flex flex-col h-full bg-gradient-to-b from-gray-900 to-gray-800 text-gray-300 shadow-xl transition-all duration-300 ease-in-out border-r border-gray-700 flex-shrink-0"
    >
        <!-- Brand -->
        <div class="flex items-center h-16 border-b border-gray-700 shrink-0" :class="sidebarOpen ? 'justify-between px-6' : 'justify-center'">
            <a x-show="sidebarOpen" href="{{ route('books.index') }}" class="font-bold text-xl text-white tracking-wide flex items-center gap-2">
                <span class="text-orange-500">👔</span> Staff Panel
            </a>
            <a x-show="!sidebarOpen" href="{{ route('books.index') }}" class="text-orange-500 text-2xl">👔</a>

            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-700 text-gray-400 hover:text-white transition-colors">
                <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18v-6a3 3 0 0 0-3-3H2v10h18"/><path d="M22 18h-2"/><path d="M2 6h6a3 3 0 0 1 3 3"/><rect x="6" y="14" width="6" height="6" rx="1"/></svg>
                <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/></svg>
            </button>
        </div>

        <!-- Scrollable Navigation Area -->
        <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1">
            
            <!-- Management Buku -->
            <a href="{{ route('staff.books.index') }}" class="relative flex items-center gap-3 px-3 py-3 rounded-lg group transition-all duration-200 {{ request()->routeIs('staff.books.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/50' : 'hover:bg-gray-800 text-gray-400 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><path d="M9 10h6"/><path d="M12 7v6"/></svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Management Buku</span>
            </a>

            <!-- Perpustakaan -->
            <a href="{{ route('staff.libraries.index') }}" class="relative flex items-center gap-3 px-3 py-3 rounded-lg group transition-all duration-200 {{ request()->routeIs('staff.libraries.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800 text-gray-400 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Perpustakaan</span>
                <div x-show="!sidebarOpen" x-transition.opacity class="absolute left-full ml-3 z-50 w-max px-2 py-1 bg-gray-900 text-white text-xs rounded-md shadow-lg">Perpustakaan</div>
            </a>

            <!-- Pending -->
            <a href="{{ route('staff.borrowings.index') }}" class="relative flex items-center gap-3 px-3 py-3 rounded-lg group transition-all duration-200 {{ request()->routeIs('staff.borrowings.index') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800 text-gray-400 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Pending</span>
                <div x-show="!sidebarOpen" x-transition.opacity class="absolute left-full ml-3 z-50 w-max px-2 py-1 bg-gray-900 text-white text-xs rounded-md shadow-lg">Pending</div>
            </a>

            <!-- Approved -->
            <a href="{{ route('staff.borrowings.approved') }}" class="relative flex items-center gap-3 px-3 py-3 rounded-lg group transition-all duration-200 {{ request()->routeIs('staff.borrowings.approved') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800 text-gray-400 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Approved</span>
                <div x-show="!sidebarOpen" x-transition.opacity class="absolute left-full ml-3 z-50 w-max px-2 py-1 bg-gray-900 text-white text-xs rounded-md shadow-lg">Approved</div>
            </a>

            <!-- Activity Log -->
            <a href="{{ route('staff.activity-log.index') }}" class="relative flex items-center gap-3 px-3 py-3 rounded-lg group transition-all duration-200 {{ request()->routeIs('staff.activity-log.*') ? 'bg-orange-600 text-white' : 'hover:bg-gray-800 text-gray-400 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Riwayat Aktivitas</span>
                <div x-show="!sidebarOpen" x-transition.opacity class="absolute left-full ml-3 z-50 w-max px-2 py-1 bg-gray-900 text-white text-xs rounded-md shadow-lg">Aktivitas</div>
            </a>
        </nav>

        <!-- Sidebar Footer (User) -->
        <div class="p-4 border-t border-gray-700 shrink-0 bg-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold text-xs ring-2 ring-gray-700">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div x-show="sidebarOpen" class="overflow-hidden">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">Staff</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 bg-gray-50/50">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 shadow-sm flex-shrink-0 z-20 h-16 flex items-center justify-between px-6">
            <!-- Breadcrumbs -->
            <div class="flex items-center text-sm text-gray-500">
                <span class="hover:text-gray-900 cursor-pointer">Staff</span>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">{{ request()->route()->getName() ? str_replace('.', ' > ', request()->route()->getName()) : 'Dashboard' }}</span>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3">
                <!-- Notifications -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 text-gray-400 hover:text-orange-600 transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        @if (auth()->user()->unreadNotifications->count())
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                        @endif
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg border z-50">
                        @forelse (auth()->user()->unreadNotifications as $notif)
                            <div class="p-3 border-b text-sm hover:bg-gray-50 transition">
                                <p class="text-gray-700">Buku <b>{{ $notif->data['book_title'] }}</b>
                                    @if ($notif->data['status'] === 'approved') <span class="text-green-600 font-semibold">disetujui</span>
                                    @elseif ($notif->data['status'] === 'rejected') <span class="text-red-600 font-semibold">ditolak</span>
                                    @elseif ($notif->data['status'] === 'returned') <span class="text-blue-600 font-semibold">dikembalikan</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <div class="p-4 text-sm text-gray-500 text-center">Tidak ada notifikasi</div>
                        @endforelse
                        @if (auth()->user()->unreadNotifications->count())
                            <div class="p-2 text-center border-t">
                                <form method="POST" action="/notifications/read">
                                    @csrf
                                    <button class="text-xs text-blue-600 hover:underline">Tandai semua dibaca</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                @endauth

                <div class="h-6 w-px bg-gray-300 mx-1"></div>

                <!-- Profile / Logout -->
                <div class="relative group">
                    <button class="flex items-center gap-2 focus:outline-none">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-700 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 mt-1">Staff Profile</p>
                        </div>
                        <div class="w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 border border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                    </button>
                    
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-48 bg-white shadow-xl rounded-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top-right">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">👤 Edit Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 border-t border-gray-100">🚪 Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content (Scrollable) -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 relative scroll-smooth">
            @isset($header)
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $header }}</h1>
                </div>
            @endisset

            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
            
            <!-- Spacer for bottom content -->
            <div class="h-12"></div>
        </main>
    </div>
</div>