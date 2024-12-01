<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Easy Trash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trash2.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('style')
    <style>
        .hover-grow:hover {
            transform: scale(1.05);
            transition: transform 0.3s;
        }

        .hover-move:hover {
            transform: translateY(-10px);
            transition: transform 0.3s;
        }
    </style>
</head>


<body class="bg-gray-100">
    @include('layouts.header')
    @include('layouts.message')
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('script')
    <script>
        document.getElementById("menu-icon-close").onclick = function() {
            document.getElementById("menu").style.display = "block";
        };
        document.getElementById("menu-icon-open").onclick = function() {
            document.getElementById("menu").style.display = "none";
        };
        document.getElementById("menu-background").onclick = function() {
            document.getElementById("menu").style.display = "none";
        }
    </script>
    {{-- <script>
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
            marker = L.marker([lat, lng], {
                draggable: "true",
            }).addTo(map);

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
            marker = L.marker([currentLat, currentLng], {
                draggable: "true",
            }).addTo(map);

            // Get address from user's coordinates
            getAddressFromLatLng(currentLat, currentLng);
        }
    </script> --}}




</body>

</html>
