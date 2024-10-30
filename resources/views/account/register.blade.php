<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Link CSS untuk Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Link JS untuk Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body>
    <div class="rectangle">
        <img src="{{ asset('images/ellipse-1-4.svg') }}" alt="Deskripsi Gambar" class="ellipse-blue-1-4">
        <img src="{{ asset('images/ellipse-2-6.svg') }}" alt="Deskripsi Gambar" class="ellipse-blue-2-6">
        <img src="{{ asset('images/ellipse-3-5.svg') }}" alt="Deskripsi Gambar" class="ellipse-blue-3-5">
        <h2 class="text-2">Sign Up</h2>
    </div>
    <div class="trash">
        <img src="{{ asset('images/trash.svg') }}" alt="Deskripsi Gambar">
    </div>
    <div class="page-signup-user-1">
        <div class="form-container">
            <h3 class="text-3"><strong>Sign Up</strong></h3>
            <form action="{{ route('account.processRegister') }}" method="post">
                @csrf
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                        placeholder="Enter your name">
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number Field -->
                <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" value="{{ old('phonenumber') }}"
                        class="form-control @error('phonenumber') is-invalid @enderror" name="phonenumber"
                        id="phonenumber" placeholder="Enter your phone number">
                    @error('phonenumber')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                        placeholder="Enter your email">
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Field -->
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="recycleorg" {{ old('role') == 'recycleorg' ? 'selected' : '' }}>
                            Recycling Organization
                        </option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location">Lokasi:</label>
                    <input type="text" id="location" name="location" required readonly>
                    <input type="hidden" id="latitude" name="latitude" value="">
                    <input type="hidden" id="longitude" name="longitude" value="">

                </div>

                <!-- Tempat untuk menampilkan peta -->
                <div id="map" style="height: 400px;"></div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" placeholder="Enter your password">
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" id="password_confirmation" placeholder="Confirm your password">
                    @error('password_confirmation')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Sign Up</button>
            </form>
        </div>
        <script>
            // Inisialisasi peta
            var map = L.map('map').setView([-6.9175, 107.6191], 13); // Koordinat awal (Bandung)

            // Menambahkan layer peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker;

            // Fungsi untuk mendapatkan alamat dari koordinat
            function getAddressFromLatLng(lat, lng) {
                var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('location').value = data.display_name; // Simpan alamat ke input
                            document.getElementById('latitude').value = lat; // Simpan latitude ke input tersembunyi
                            document.getElementById('longitude').value = lng; // Simpan longitude ke input tersembunyi
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }


            // Fungsi untuk menangani klik pada peta
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // Menghapus marker sebelumnya
                if (marker) {
                    map.removeLayer(marker);
                }

                // Menambahkan marker baru
                marker = L.marker([lat, lng]).addTo(map);

                // Mendapatkan alamat dari koordinat
                getAddressFromLatLng(lat, lng);
            });
        </script>


</body>

</html>
