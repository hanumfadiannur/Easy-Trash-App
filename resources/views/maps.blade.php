@extends('layouts.app')

@section('style')
    <style>
        .organization-card.highlight {
            border: 2px solid green;
            /* Menambahkan stroke hijau */
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            /* Optional: Menambahkan efek glow */
        }

        /* Next Button */
        .next-button {
            position: absolute;
            right: 3vw;
            bottom: 1vh;
            background-color: #4eaf5b;
            /* Warna latar belakang hijau */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .next-button:hover {
            background-color: #45a049;
            /* Warna saat hover */
            transform: scale(1.05);
            /* Efek pembesaran saat hover */
        }

        /* Button's focus state */
        .next-button:focus {
            outline: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
    <div class="container2">
        <!-- Left side: search and organization list -->
        <div class="left-side">
            <div class="search-container">
                <div class="org-icon">
                    {{-- <img src="{{ asset('images/Ellipse48.svg') }}" alt="Organization Icon"> --}}
                    <div class="search-box">
                        <label for="start-location">Lokasi Anda:</label>
                        <input type="text" class="search-input" id="start-location"
                            value="{{ old('location', $user->location) }}" readonly />
                    </div>
                    <div class="search-box">
                        <p style="color: red;">Klik marker hijau pada maps, untuk memilih Recycling Organization.</p>
                        <label for="end-location">Tujuan:</label>
                        <input type="text" class="search-input" id="end-location" placeholder="Pilih tujuan...">
                    </div>
                </div>
            </div>

            <div class="organization-list" id="organization-list">
                @foreach ($recycleOrgs as $organization)
                    <div class="organization-card" id="org-{{ $organization->id }}">
                        <div class="org-avatar">
                            <img src="{{ asset('images/Ellips47.svg') }}" alt="Organization Avatar">
                        </div>
                        <div class="org-info">
                            <div class="org-name">{{ $organization->name }}</div>
                            <div class="org-type">Recycling Organization</div>
                            <div class="org-address">
                                {{ $organization->mapsRecycleOrg->address ?? 'Alamat tidak tersedia' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Map on the right side -->
        <div id="map">
        </div>
    </div>


    <!-- Hidden Form for waste request -->
    <form id="wasteRequestForm" action="{{ route('createwasterequest') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="recycleorg_id" id="recycleOrgId">
    </form>

    <button class="next-button" id="nextButton">Next</button>
@endsection

@section('script')
    <script>
        var map = L.map('map').setView([-6.9175, 107.6191], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Custom icon for the user's location (Blue marker)
        var blueIcon = new L.Icon({
            iconUrl: '{{ asset('images/Map pin2.svg') }}',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Custom icon for the recycling organizations (Green marker)
        var greenIcon = new L.Icon({
            iconUrl: '{{ asset('images/Map pin.svg') }}',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Add user's location marker if available
        @if ($mapData)
            var userMarker = L.marker([{{ $mapData->latitude }}, {{ $mapData->longitude }}], {
                    icon: blueIcon
                })
                .bindPopup("Lokasi Anda")
                .addTo(map);
            map.setView([{{ $mapData->latitude }}, {{ $mapData->longitude }}], 15);

            // Set the user's location address in the start-location field automatically
            document.getElementById('start-location').value = "{{ $user->location }}";
        @endif

        // Add markers for recycling organizations with green icon
        @foreach ($recycleOrgs as $organization)
            @if ($organization->mapsRecycleOrg)
                var marker = L.marker([{{ $organization->mapsRecycleOrg->latitude }},
                        {{ $organization->mapsRecycleOrg->longitude }}
                    ], {
                        icon: greenIcon
                    })
                    .bindPopup("<b>{{ $organization->name }}</b><br>{{ $organization->mapsRecycleOrg->address }}")
                    .addTo(map);

                // When a user clicks on a marker, set the address as the end-location
                marker.on('click', function() {
                    document.getElementById('end-location').value = "{{ $organization->mapsRecycleOrg->address }}";

                    // Set the recycleOrgId value
                    document.getElementById('recycleOrgId').value = "{{ $organization->id }}";

                    // Remove the highlight from all other cards
                    var allOrgCards = document.querySelectorAll('.organization-card');
                    allOrgCards.forEach(function(card) {
                        card.classList.remove('highlight');
                    });

                    // Add green stroke to the clicked card
                    var orgCard = document.getElementById('org-{{ $organization->id }}');
                    orgCard.classList.add('highlight');

                    // Move the selected card to the top
                    var orgList = document.getElementById('organization-list');
                    orgList.prepend(orgCard); // Moves the selected card to the top
                });
            @endif
        @endforeach


        // Handle the Next button click event
        document.getElementById('nextButton').addEventListener('click', function() {
            var recycleOrgId = document.getElementById('recycleOrgId').value;
            if (recycleOrgId) {
                // Submit the form if a recycling organization is selected
                document.getElementById('wasteRequestForm').submit();
            } else {
                alert('Please select a recycling organization.');
            }
        });

        // Optional: Remove highlight when the user changes the end-location input
        document.getElementById('end-location').addEventListener('input', function() {
            var highlightedCards = document.querySelectorAll('.organization-card.highlight');
            highlightedCards.forEach(function(card) {
                card.classList.remove('highlight');
            });
        });
    </script>
@endsection
