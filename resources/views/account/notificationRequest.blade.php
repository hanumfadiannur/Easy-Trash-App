@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/trash2.css') }}">
    <style>
        .no-requests {
            text-align: center;
            padding: 40px;
            background-color: #ffebee;
            border-radius: 8px;
            color: #d32f2f;
            font-size: 18px;
            border: 1px solid #f44336;
        }

        .note {
            font-size: 14px;
            color: #666;
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="container2">
            <h2>Notification Request</h2>
            <br>
            @if ($requests->isEmpty())
                <div class="no-requests">
                    <p>Maaf, saat ini tidak ada request yang masuk.</p>
                    <p class="note">Coba lagi nanti atau periksa kembali sistem.</p>
                </div>
            @else
                @foreach ($requests as $request)
                    @if ($request->status != 'done')
                        <!-- Pastikan status bukan 'done' -->
                        <div class="request-item">
                            <span class="user-name">Request from, <strong>{{ $request->user->name }}</strong></span>
                            <a href="{{ route('account.notificationRequest2', $request->id) }}" class="flex items-center">
                                <button class="show-button">Show Request</button>
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection
