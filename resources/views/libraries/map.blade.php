<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Lokasi Perpustakaan
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Map Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div id="map" style="width: 100%; height: 600px;"></div>
        </div>

        <!-- Libraries List -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Perpustakaan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($libraries as $library)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer library-card" onclick="focusLibrary({{ $library->latitude }}, {{ $library->longitude }}, '{{ addslashes($library->name) }}')">
                        <h4 class="font-semibold text-gray-900">{{ $library->name }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $library->address }}</p>
                        <p class="text-xs text-gray-500 mt-2">📍 {{ $library->latitude }}, {{ $library->longitude }}</p>
                        <a href="https://www.openstreetmap.org/?mlat={{ $library->latitude }}&mlon={{ $library->longitude }}&zoom=16" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-2 inline-block">
                            Buka di Peta →
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <p>Tidak ada perpustakaan dengan koordinat yang valid</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS (Free, No API Key Needed!) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        let map;
        let markers = [];
        let markerLayer = L.featureGroup();

        function initMap() {
            const libraries = {!! json_encode($libraries) !!};
            
            // Default center (Jakarta)
            let center = [-6.2088, 106.8456];
            let zoom = 12;

            if (libraries.length > 0) {
                // Hitung center point
                let totalLat = 0, totalLng = 0;
                libraries.forEach(lib => {
                    totalLat += parseFloat(lib.latitude);
                    totalLng += parseFloat(lib.longitude);
                });
                center = [totalLat / libraries.length, totalLng / libraries.length];
                zoom = 13;
            }

            // Inisialisasi map dengan OpenStreetMap
            map = L.map('map').setView(center, zoom);

            // Tambah tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            // Tambah markers
            libraries.forEach(lib => {
                const lat = parseFloat(lib.latitude);
                const lng = parseFloat(lib.longitude);
                
                const marker = L.marker([lat, lng])
                    .bindPopup(`
                        <div style="font-family: Arial, sans-serif;">
                            <h4 style="margin: 0 0 5px 0; color: #333; font-weight: bold;">` + lib.name + `</h4>
                            <p style="margin: 0 0 8px 0; color: #666; font-size: 13px;">` + lib.address + `</p>
                            <a href="https://www.openstreetmap.org/?mlat=` + lat + `&mlon=` + lng + `&zoom=16" target="_blank" style="color: #0066cc; text-decoration: none; font-size: 12px;">Buka di Peta OpenStreetMap</a>
                        </div>
                    `, {
                        maxWidth: 250,
                    })
                    .addTo(map);
                
                markers.push({ marker, lat, lng, name: lib.name });
            });
        }

        function focusLibrary(lat, lng, name) {
            map.setView([lat, lng], 16);
            
            // Find and open the marker popup
            markers.forEach(m => {
                if (m.lat === lat && m.lng === lng) {
                    m.marker.openPopup();
                }
            });
        }

        // Initialize map when page loads
        window.addEventListener('load', initMap);
    </script>
</x-app-layout>
