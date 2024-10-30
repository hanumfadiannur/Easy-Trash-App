<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <!-- Link CSS for Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Link JS for Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <ul class="nav-list">
                <!-- Left side menu items -->
                <div class="nav-left">
                    <li class="nav-item">
                        <div class="hamburger">
                            <div class="bar"></div>
                            <div class="bar"></div>
                            <div class="bar"></div>
                        </div>
                        <ul class="hamburger-dropdown">
                            <li><a href="/profile">Profile</a></li>
                            <li><a href="#">Notification Report</a></li>
                            <li><a href="#">Point and Reward</a></li>
                        </ul>
                    </li>
                </div>

                <!-- Right side menu items -->
                <div class="nav-right">
                    <li class="nav-item">
                        <a href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact">About</a>
                    </li>
                </div>

            </ul>
        </div>
        <script src="js\script.js"></script>

    </nav>



    <!-- Example content below navbar -->
    <div>

        <div class="container">
            <section class="profile-section">
                <div class="profile-header">
                    <h2>Hai, <span id="display-username">{{ $user->name }}</span>!</h2>
                </div>

                <form action="{{ route('account.updateProfile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name"
                            id="" />
                        @error('name')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="text" value="{{ old('phonenumber', $user->phonenumber) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Phone Number"
                            name="phonenumber" id="" />
                        @error('phonenumber')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
                            id="" />
                        @error('email')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <!-- Populate the location with the user's saved location if it exists -->
                        <input type="text" id="location" name="location"
                            value="{{ old('location', $user->location) }}" required readonly>

                        <!-- Populate latitude and longitude hidden inputs with the user's saved data -->
                        <input type="hidden" id="latitude" name="latitude"
                            value="{{ old('latitude', $user->latitude) }}">
                        <input type="hidden" id="longitude" name="longitude"
                            value="{{ old('longitude', $user->longitude) }}">
                    </div>

                    <!-- Map container -->
                    <div id="map" style="height: 400px;"></div>

                    <div class="buttons">
                        <button type="button" class="btn btn-edit" id="edit-btn">Edit</button>
                        <button type="submit" class="btn btn-save">Save</button>
                    </div>
                </form>
            </section>
            <div class="image-container">
                <img src="{{ asset('images/trash.svg') }}" alt="Trash bin " class="trash-image">
            </div>
        </div>
    </div>
    <script>
        // Initialize the map
        var map = L.map('map').setView([-6.9175, 107.6191], 13); // Fallback initial coordinates (Bandung)

        // Add tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Variable to store marker
        var marker;

        // Function to get address from coordinates
        function getAddressFromLatLng(lat, lng) {
            var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('location').value = data.display_name; // Save address to input
                        document.getElementById('latitude').value = lat; // Save latitude to hidden input
                        document.getElementById('longitude').value = lng; // Save longitude to hidden input
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Handle map click event
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Remove previous marker if exists
            if (marker) {
                map.removeLayer(marker);
            }

            // Add a new marker
            marker = L.marker([lat, lng]).addTo(map);

            // Get address from coordinates
            getAddressFromLatLng(lat, lng);
        });

        // If you want to pre-fill the map with user's current location
        const currentLat = {{ $mapData->latitude ?? 'null' }};
        const currentLng = {{ $mapData->longitude ?? 'null' }};
        if (currentLat && currentLng) {
            // Set view to the user's registered location
            map.setView([currentLat, currentLng], 13);

            // Add a marker for the user's location
            marker = L.marker([currentLat, currentLng]).addTo(map);

            // Get address from user's coordinates
            getAddressFromLatLng(currentLat, currentLng);
        }
    </script>



</body>

</html>
