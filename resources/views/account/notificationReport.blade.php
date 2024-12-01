@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/report_style.css') }}">
@endsection

@section('content')
    <div class="report-container">
        <h1 class="report-title">Notification Report</h1>

        @php
            $lastDate = null; // Untuk menyimpan tanggal terakhir yang ditampilkan
        @endphp

        @foreach ($recyclingPoints as $point)
            <!-- Cek status wasteRequest sebelum menampilkan tanggal dan lainnya -->
            @if ($point->wasteRequest->status === 'done')
                @php
                    $currentDate = $point->wasteRequest->created_at->format('Y-m-d'); // Ambil tanggal dari waste_request
                @endphp

                @if ($lastDate !== $currentDate)
                    <!-- Cek apakah tanggal berbeda dari yang terakhir -->
                    <h2 class="report-date">{{ $point->wasteRequest->created_at->format('l, d F Y') }}</h2>
                    <!-- Tampilkan tanggal -->
                    @php
                        $lastDate = $currentDate; // Update tanggal terakhir
                    @endphp
                @endif

                <div class="report-card">
                    <div class="report-card-header">
                        <div>
                            <h3>Setoran Sampah</h3>
                            <p class="report-total">Total: <span>{{ $point->total_weight }} Kg</span></p>
                        </div>
                        <div class="report-point-section">
                            <div class="report-point-label">Poin</div>
                            <div class="report-point-badge">{{ $point->points }}</div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @php
            $lastDate = null; // Reset untuk request recycling
        @endphp

        @foreach ($recyclingRequests as $request)
            @php
                $currentDate = $request->created_at->format('Y-m-d'); // Ambil tanggal dari waste_request
            @endphp

            @if ($lastDate !== $currentDate)
                <!-- Cek apakah tanggal berbeda dari yang terakhir -->
                <h2 class="report-date">{{ $request->created_at->format('l, d F Y') }}</h2> <!-- Tampilkan tanggal -->
                @php
                    $lastDate = $currentDate; // Update tanggal terakhir
                @endphp
            @endif

            <div class="report-card">
                <div class="report-card-header">
                    <div>
                        <h3>Request Recycling</h3>
                        <p class="report-total">Total: <span>{{ $request->wasteData->sum('total_weight') }} Kg</span></p>
                        <p class="report-destination">to, {{ $request->recycleOrg->name }}</p>
                    </div>
                    <div class="report-status">
                        <span
                            class="report-status-badge
                            @if ($request->status == 'pending') report-status-pending
                            @elseif($request->status == 'accepted') report-status-accepted
                            @else report-status-done @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                        @if ($request->status == 'accepted')
                            <a href="{{ route('account.notificationReport2', $request->id) }}" class="flex items-center">
                                <button class="report-show-request">Show Request</button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
