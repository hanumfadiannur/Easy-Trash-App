@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div>
        <div class="container">
            <section class="profile-section">

                <h2><span class="bold-text">Hi, {{ $user->name }}</span>!</h2>

                <form action="{{ route('account.updateProfile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name"
                            id="name" disabled />
                        @error('name')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="text" value="{{ old('phonenumber', $user->phonenumber) }}"
                            class="form-control @error('phonenumber') is-invalid @enderror" placeholder="Phone Number"
                            name="phonenumber" id="phonenumber" disabled />
                        @error('phonenumber')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
                            id="email" disabled />
                        @error('email')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}"
                            required readonly disabled />
                        <input type="hidden" id="latitude" name="latitude"
                            value="{{ old('latitude', $mapData->latitude ?? '') }}">
                        <input type="hidden" id="longitude" name="longitude"
                            value="{{ old('longitude', $mapData->longitude ?? '') }}">
                    </div>
                    <div id="map" style="height: 400px;"></div>
                    <div class="buttons">
                        <button type="button" class="btn btn-edit" id="edit-btn">Edit</button>
                        <button type="submit" class="btn btn-save" disabled>Save
                        </button>
                    </div>
                </form>
            </section>
            <div class="image-container">
                <img src="{{ asset('images/trash.svg') }}" alt="Trash bin" class="trash-image">
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('edit-btn').addEventListener('click', function() {
            // Menemukan semua input yang dalam keadaan disabled
            let inputs = document.querySelectorAll('input[disabled]');
            inputs.forEach(input => input.disabled = false); // Mengubah menjadi editable

            // Sembunyikan tombol Edit dan tampilkan tombol Save
            document.getElementById('edit-btn').style.display = 'none';
            document.querySelector('.btn-save').style.display = 'inline-block';

            // Mengaktifkan tombol Save
            document.querySelector('.btn-save').disabled = false; // Mengaktifkan tombol Save
        });
    </script>
    <script>
        // Inisialisasi peta dengan Leaflet
        var map = L.map('map').setView([{{ old('latitude', $mapData->latitude ?? '-6.9175') }},
            {{ old('longitude', $mapData->longitude ?? '107.6191') }}
        ], 13);

        // Menambahkan tile layer ke peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Fungsi untuk mendapatkan alamat dari koordinat
        function getAddressFromLatLng(lat, lng) {
            var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        // Update input alamat dan koordinat
                        document.getElementById('location').value = data.display_name;
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Cek apakah lokasi pengguna tersedia
        const currentLat = {{ $mapData->latitude ?? 'null' }};
        const currentLng = {{ $mapData->longitude ?? 'null' }};

        // Menambahkan marker berdasarkan lokasi pengguna jika tersedia
        var marker;
        if (currentLat && currentLng) {
            map.setView([currentLat, currentLng], 13);

            // Menambahkan marker yang bisa dipindahkan
            marker = L.marker([currentLat, currentLng], {
                draggable: true // Membuat marker bisa dipindahkan
            }).addTo(map);

            // Update alamat saat marker dipindahkan
            marker.on('dragend', function(event) {
                var position = event.target.getLatLng();
                getAddressFromLatLng(position.lat, position.lng);
            });

            // Menampilkan alamat saat pertama kali dimuat
            getAddressFromLatLng(currentLat, currentLng);
        } else {
            // Jika lokasi pengguna tidak tersedia, set lokasi default (Bandung)
            map.setView([-6.9175, 107.6191], 13);

            // Menambahkan marker yang bisa dipindahkan pada lokasi default
            marker = L.marker([-6.9175, 107.6191], {
                draggable: true // Membuat marker bisa dipindahkan
            }).addTo(map);

            // Update alamat saat marker dipindahkan
            marker.on('dragend', function(event) {
                var position = event.target.getLatLng();
                getAddressFromLatLng(position.lat, position.lng);
            });
        }

        // Menyimpan nilai latitude dan longitude ke dalam form saat form disubmit
        document.querySelector('form').addEventListener('submit', function() {
            if (marker) {
                // Pastikan bahwa nilai latitude dan longitude terbaru sudah disimpan
                document.getElementById('latitude').value = marker.getLatLng().lat;
                document.getElementById('longitude').value = marker.getLatLng().lng;
            }
        });
    </script>
@endsection
