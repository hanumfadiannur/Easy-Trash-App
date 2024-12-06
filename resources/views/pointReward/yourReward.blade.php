@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/tukarpoin.css') }}">
@endsection

@section('content')
    <h2>Your Redeemed Rewards</h2>
    <div class="container">

        <section class="rewards" style="padding-top:10px">
            <div class="reward-category">
                <div class="reward-items">
                    @foreach ($redeemedRewards as $rewardTransaction)
                        @php
                            $reward = $rewardTransaction->reward;
                        @endphp
                        <!-- Redeemed Reward Item -->
                        <div class="reward-item">
                            <img src="{{ asset('images/reward/' . $reward->image) }}" alt="{{ $reward->name }}"
                                style="width: 100%; height: auto;">
                            <p><strong>{{ $reward->name }}</strong></p>
                            <p>Points Used: {{ $reward->points_required }}</p>
                            <button type="button" class="btn btn-custom" data-bs-toggle="modal"
                                data-bs-target="#rewardDetailModal{{ $reward->id }}">
                                View Details
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <!-- Modal untuk melihat detail reward -->
    @foreach ($redeemedRewards as $rewardTransaction)
        @php
            $reward = $rewardTransaction->reward;
        @endphp
        <div class="modal fade" id="rewardDetailModal{{ $reward->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="rewardDetailModalLabel{{ $reward->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rewardDetailModalLabel{{ $reward->id }}">
                            Reward Details for <strong>{{ $reward->name }}</strong>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('images/reward/' . $reward->image) }}" alt="{{ $reward->name }}"
                            style="width: 100%; max-height: 300px; max-width: 300px; display: block; margin: 0 auto; border-radius: 15px;">
                        <p><strong>Description:</strong></p>
                        <p>{{ $reward->description }}</p>
                        <p><strong>Points Used:</strong> {{ $reward->points_required }}</p>

                        <!-- No Redeem Button, only View Details -->
                        <div class="mb-3">
                            <p>You have already redeemed this reward.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
