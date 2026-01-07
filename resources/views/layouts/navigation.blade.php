<nav x-data="{ open: false, notifOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            <!-- Right -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">

                <!-- 🔔 NOTIFICATION -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="relative focus:outline-none"
                    >
                        🔔
                        @if (auth()->user()->unreadNotifications->count())
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div
                        x-show="open"
                        @click.outside="open = false"
                        class="absolute right-0 mt-2 w-80 bg-white border rounded shadow z-50"
                    >
                        <div class="p-3 border-b flex justify-between items-center">
                            <span class="font-semibold text-sm">Notifikasi</span>

                            @if(auth()->user()->unreadNotifications->count())
                            <form method="POST" action="/notifications/read">
                                @csrf
                                <button class="text-xs text-blue-600 hover:underline">
                                    Tandai semua dibaca
                                </button>
                            </form>
                            @endif
                        </div>

                        <div class="max-h-64 overflow-y-auto">
                            @forelse (auth()->user()->notifications->take(5) as $notif)
                                <div class="p-3 text-sm border-b
                                    {{ $notif->read_at ? 'bg-white' : 'bg-gray-100' }}">
                                    <p>
                                        Buku <b>{{ $notif->data['book_title'] }}</b>
                                        {{ $notif->data['status'] === 'approved'
                                            ? 'disetujui'
                                            : 'ditolak'
                                        }}
                                    </p>
                                </div>
                            @empty
                                <div class="p-3 text-sm text-gray-500">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endauth

                <!-- USER DROPDOWN -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
