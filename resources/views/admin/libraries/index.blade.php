{{-- resources\views\admin\libraries\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Daftar Perpustakaan
                </h2>
                <p class="mt-1 text-sm text-gray-500">Kelola data perpustakaan, lokasi, dan koleksi buku.</p>
            </div>
            
            <!-- Top Right Action -->
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('libraries.map') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    Lihat Peta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Main Content Card -->
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
            
            <!-- Toolbar -->
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <!-- Search Form -->
                <form action="{{ route('admin.libraries.index') }}" method="GET" class="relative w-full sm:max-w-md group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari nama perpustakaan..."
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
                        value="{{ $search ?? '' }}"
                    >
                    @if($search ?? false)
                        <a href="{{ route('admin.libraries.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer hover:text-red-500 text-gray-400 transition-colors" title="Reset Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </a>
                    @endif
                </form>

                <div>
                    <a href="{{ route('admin.libraries.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm hover:shadow-md transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Tambah Perpustakaan
                    </a>
                </div>
            </div>

            <!-- Table Area -->
            @if($libraries->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th width="60" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                                <th width="25%" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Perpustakaan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat & Lokasi</th>
                                <th width="120" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($libraries as $lib)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                        {{ $loop->iteration + ($libraries->firstItem() ?? 0) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <div class="flex items-center">
                                                <span class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3 border border-blue-200">
                                                    {{ substr($lib->name, 0, 1) }}
                                                </span>
                                                <div class="overflow-hidden">
                                                    <span class="text-sm font-bold text-gray-900 block truncate w-full" title="{{ $lib->name }}">
                                                        {{ $lib->name }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mt-1 ml-11">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $lib->city->name ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-sm text-gray-700 mb-1 flex items-start">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5 text-gray-400 mt-0.5 flex-shrink-0"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                            <span class="break-words">{{ $lib->address }}</span>
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded w-max hover:bg-gray-200 cursor-pointer transition-colors border border-gray-100" title="Klik untuk copy koordinat">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                            {{ $lib->latitude }}, {{ $lib->longitude }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium align-middle">
                                        <div class="flex items-center justify-end gap-1">
                                            
                                            <!-- Books Button -->
                                            <a href="{{ route('admin.libraries.books.index', $lib) }}" class="inline-flex items-center justify-center p-1.5 rounded-md text-purple-600 hover:bg-purple-100 transition-colors" title="Kelola Buku">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                            </a>
                                            
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.libraries.edit', $lib) }}" class="inline-flex items-center justify-center p-1.5 rounded-md text-blue-600 hover:bg-blue-100 transition-colors" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            </a>
                                            
                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.libraries.destroy', $lib) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perpustakaan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-md text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if(method_exists($libraries, 'links') && $libraries->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 flex items-center justify-between">
                        {{ $libraries->links() }}
                    </div>
                @endif

            @else
                <!-- Enhanced Empty State -->
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <div class="bg-gray-50 rounded-full p-6 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada data perpustakaan</h3>
                    <p class="mt-1 text-sm text-gray-500 max-w-sm">
                        Mulai dengan menambahkan perpustakaan baru ke dalam sistem untuk melihatnya di sini.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.libraries.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Tambah Perpustakaan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>