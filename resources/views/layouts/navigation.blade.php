{{-- resources\views\layouts\navigation.blade.php --}}

<nav x-data="{ open: false, notifOpen: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('books.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">
                        Daftar Buku
                    </x-nav-link>
                </div>
            </div>

            <!-- RIGHT -->
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

                    <!-- DROPDOWN -->
                    <div
                        x-cloak
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded z-50"
                    >
                        @forelse (auth()->user()->unreadNotifications as $notif)
                            <div class="p-3 border-b text-sm">
                                Buku <b>{{ $notif->data['book_title'] }}</b>
                                @if ($notif->data['status'] === 'approved')
                                    disetujui
                                @elseif ($notif->data['status'] === 'rejected')
                                    ditolak
                                @elseif ($notif->data['status'] === 'returned')
                                    sudah dikembalikan
                                @endif
                            </div>
                        @empty
                            <div class="p-3 text-sm text-gray-500">
                                Tidak ada notifikasi
                            </div>
                        @endforelse

                        @if (auth()->user()->unreadNotifications->count())
                            <form method="POST" action="/notifications/read" class="p-2 text-center border-t">
                                @csrf
                                <button class="text-xs text-blue-600 hover:underline">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endauth

                <!-- USER DROPDOWN -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700">
                            {{ Auth::user()->name }}
                            <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
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
        </div>
    </div>
</nav>
