@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/trash2.css') }}">
    <style>
        .item-list {
            width: 100%;
            background-color: #d8ebbf;
            padding: 8px 16px;
            border-radius: 16px;
            font-weight: bold;
        }

        .item,
        .total {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .total {
            border-top: none;
        }

        .request-box {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
        }

        .dropdown-content {
            display: none;
            margin-top: 10px;
            padding-left: 20px;
        }

        .request-info {
            display: flex;
            justify-content: space-between;
        }

        .request-info .name {
            align-items: flex-start;
        }

        .request-info .dropdown-button {
            cursor: pointer;
            font-weight: bold;
            align-items: flex-end;
        }

        .no-requests {
            text-align: center;
            padding: 40px;
            background-color: #ffebee;
            border-radius: 8px;
            color: #d32f2f;
            font-size: 18px;
            border: 1px solid #f44336;
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="container4">
            <h2>Riwayat Recycling</h2>
            <br>

            <!-- Bagian permintaan yang sudah selesai -->
            @if ($requests->isEmpty())
                <div class="no-requests">
                    <p>There are currently no completed requests.</p>
                </div>
            @else
                @foreach ($requests as $request)
                    <div class="request-box">
                        <!-- Ringkasan info yang akan ditampilkan sebelum dropdown -->
                        <p class="request-info">
                            <span class="name"><strong>Complete Recycling,</strong> from {{ $request->user->name }}</span>
                            <!-- Tombol dropdown untuk menampilkan detail -->
                            <span class="dropdown-button" onclick="toggleDropdown({{ $request->id }})">
                                <!-- Gambar panah yang akan berubah -->
                                <img id="arrow-{{ $request->id }}" src="{{ asset('images/arrow-up-icon.svg') }}"
                                    alt="Dropdown Icon" style="width: 40px; height: 40px;">
                            </span>
                        </p>

                        <!-- Konten dropdown yang tersembunyi, akan muncul saat diklik -->
                        <div class="dropdown-content" id="dropdown-{{ $request->id }}">
                            <table class="item-list">
                                @foreach ($request->categories as $category)
                                    <tr class="item">
                                        <td>{{ $category->type }}</td>
                                        <td>{{ $category->pivot->weight }} kg</td>
                                    </tr>
                                @endforeach
                                <tr class="total">
                                    <td>Total</td>
                                    <td>{{ $request->total_weight }} kg</td>
                                </tr>
                            </table>
                            <p><strong>Date: </strong>

                                <span style="color: #44B1FF; font-weight: bold;">
                                    {{ \Carbon\Carbon::parse($request->updated_at)->format('l, d F Y') }}
                                </span>

                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Menambahkan skrip untuk menangani dropdown -->
    <script>
        function toggleDropdown(requestId) {
            var dropdown = document.getElementById('dropdown-' + requestId);
            var arrow = document.getElementById('arrow-' + requestId);

            if (dropdown.style.display === "none" || dropdown.style.display === "") {
                dropdown.style.display = "block";
                arrow.src = "{{ asset('images/arrow-down-icon.svg') }}"; // Ganti dengan ikon panah ke atas
            } else {
                dropdown.style.display = "none";
                arrow.src = "{{ asset('images/arrow-up-icon.svg') }}"; // Ganti dengan ikon panah ke bawah
            }
        }
    </script>
@endsection
