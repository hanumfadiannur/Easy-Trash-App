@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/tukarpoin.css') }}">
@endsection

@section('content')
    <h2>Detail Transaksi Reward</h2>

    <div class="container  d-flex justify-content-center align-items-center">
        <!-- Transaction Detail Section -->
        <div class="transaction-detail">
            <h3>
                <span style="text-transform: uppercase; font-weight: bold; font-size: 24px;">
                    Transaksi ID: {{ $transaction->id }}
                </span>
            </h3>
            <br>
            <p><strong>User:</strong> {{ $transaction->user->name }}</p>
            <p><strong>Reward:</strong> {{ $transaction->reward->name }}</p>
            <p><strong>Poin yang Digunakan:</strong> {{ $transaction->points_used }}</p>
            <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <!-- Button Kembali -->
    <div class="container  d-flex justify-content-center align-items-center mt-3">

        <a href="{{ route('pointReward.pointReward') }}" class="btn btn-redeem">Kembali ke Beranda</a>
    </div>
@endsection
