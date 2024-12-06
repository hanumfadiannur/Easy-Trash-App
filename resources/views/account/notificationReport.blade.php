@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/report_style.css') }}">
@endsection

@section('content')
    <div class="report-container">
        <h1 class="report-title">Notification Report</h1>

        @php
            // Gabungkan kedua data dan urutkan secara descending berdasarkan waktu relevan
            $allRecords = $recyclingPoints
                ->map(function ($point) {
                    return (object) [
                        'type' => 'point',
                        'date' => $point->wasteRequest->updated_at->format('Y-m-d'),
                        'timestamp' => $point->wasteRequest->updated_at, // Tetap gunakan created_at untuk recyclingPoints
                        'data' => $point,
                    ];
                })
                ->concat(
                    $recyclingRequests->map(function ($request) {
                        return (object) [
                            'type' => 'request',
                            'date' => $request->updated_at->format('Y-m-d'), // Gunakan updated_at untuk tanggal
                            'timestamp' => $request->updated_at, // Gunakan updated_at untuk pengurutan
                            'data' => $request,
                        ];
                    }),
                )
                ->sortByDesc('timestamp'); // Urutkan berdasarkan timestamp (bisa created_at atau updated_at)

            $lastDate = null; // Untuk menyimpan tanggal terakhir yang ditampilkan
        @endphp

        @foreach ($allRecords as $record)
            @if ($lastDate !== $record->date)
                <!-- Tampilkan tanggal hanya jika berbeda -->
                <h2 class="report-date">{{ \Carbon\Carbon::parse($record->date)->format('l, d F Y') }}</h2>
                @php
                    $lastDate = $record->date; // Update tanggal terakhir
                @endphp
            @endif

            @if ($record->type === 'point')
                <!-- Tampilkan Setoran Sampah hanya jika request sudah 'done' -->
                @if ($record->data->wasteRequest->status === 'done')
                    <div class="report-card">
                        <div class="report-card-header">
                            <div>
                                <h3>Setoran Sampah</h3>
                                <p class="report-total">Total: <span>{{ $record->data->total_weight }} Kg</span></p>
                            </div>
                            <div class="report-point-section">
                                <div class="report-point-label">Poin</div>
                                <div class="report-point-badge">{{ $record->data->points }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            @elseif ($record->type === 'request')
                <div class="report-card">
                    <div class="report-card-header">
                        <div>
                            <h3>Request Recycling</h3>
                            <p class="report-total">Total: <span>{{ $record->data->wasteData->sum('total_weight') }}
                                    Kg</span></p>
                            <p class="report-destination">to, {{ $record->data->recycleOrg->name }}</p>
                        </div>
                        <div class="report-status">
                            <span
                                class="report-status-badge
                                @if ($record->data->status == 'pending') report-status-pending
                                @elseif($record->data->status == 'accepted') report-status-accepted
                                @elseif($record->data->status == 'rejected') report-status-rejected
                                @else report-status-done @endif">
                                {{ ucfirst($record->data->status) }}
                            </span>
                            @if ($record->data->status == 'accepted')
                                <a href="{{ route('account.notificationReport2', $record->data->id) }}"
                                    class="flex items-center">
                                    <button class="report-show-request">Show Request</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
