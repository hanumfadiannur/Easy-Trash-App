@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/tukarpoin.css') }}">
@endsection

@section('content')
    <h2>Reward and Point</h2>

    <!-- Menampilkan Poin Pengguna -->
    <div class="points">
        <div class="buletan">
            <!-- Grup pertama -->
            <div class="item">
                <img src="{{ asset('images/stars.png') }}" alt="Star Icon">
                <p>Your Points</p>
                <p>{{ $user->points }}</p>
            </div>
            <!-- Grup kedua -->
            <a href="{{ route('pointReward.yourReward') }}" class="flex items-center">
                <div class="item">
                    <img src="{{ asset('images/Trophy Cup.png') }}" alt="Trophy Icon">
                    <p style="text-decoration: underline; text-decoration-color: rgb(37, 37, 157);">Your Rewards</p>
                    <p>{{ $redeemedCount }}</p>
                </div>
            </a>
        </div>
    </div>

    <div class="container">

        <section class="rewards" style="padding-top:10px">
            <h2>Reward Untukmu</h2>

            <!-- Hiasan Category -->
            <div class="reward-category">
                <h3>Hiasan</h3>
                <div class="reward-items">
                    @foreach ($rewards->where('category', 'Hiasan') as $reward)
                        <!-- Reward Item with Modal Trigger -->
                        <div class="reward-item">
                            <img src="{{ asset('images/reward/' . $reward->image) }}" alt="{{ $reward->name }}">
                            <p><strong>{{ $reward->name }}</strong></p>
                            <p>Points Required: {{ $reward->points_required }}</p>
                            <!-- View Details Button -->
                            <button type="button" class="btn btn-custom" data-bs-toggle="modal"
                                data-bs-target="#rewardDetailModal{{ $reward->id }}">
                                View Details
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Peralatan Category -->
            <div class="reward-category">
                <h3>Peralatan</h3>
                <div class="reward-items">
                    @foreach ($rewards->where('category', 'Peralatan') as $reward)
                        <!-- Reward Item with Modal Trigger -->
                        <div class="reward-item">
                            <img src="{{ asset('images/reward/' . $reward->image) }}" alt="{{ $reward->name }}">
                            <p><strong>{{ $reward->name }}</strong></p>
                            <p>Points Required: {{ $reward->points_required }}</p>
                            <!-- View Details Button -->
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

    <!-- Modal untuk melihat detail reward dan menukarkan reward -->
    @foreach ($rewards as $reward)
        <div class="modal fade" id="rewardDetailModal{{ $reward->id }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="rewardDetailModalLabel{{ $reward->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rewardDetailModalLabel{{ $reward->id }}">
                            Reward Details for <strong>{{ $reward->name }}</strong>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('reward.redeem') }}" method="POST" id="rewardRedeemForm{{ $reward->id }}">
                        @csrf
                        <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                        <div class="modal-body">
                            <img src="{{ asset('images/reward/' . $reward->image) }}" alt="{{ $reward->name }}"
                                style="width: 100%; max-height: 300px; max-width: 300px; display: block; margin: 0 auto; border-radius: 15px;">
                            <p><strong>Description:</strong></p>
                            <p>{{ $reward->description }}</p>
                            <p><strong>Points Required:</strong> {{ $reward->points_required }}</p>

                            <!-- Redeem or Exchange Reward Button -->
                            <div class="mb-3">
                                <p>Are you sure you want to redeem this reward?</p>
                                <button type="submit" class="btn btn-redeem">Redeem Reward</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        // Example of form submission via AJAX
        @foreach ($rewards as $reward)
            $("#rewardRedeemForm{{ $reward->id }}").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('reward.redeem') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: $("#rewardRedeemForm{{ $reward->id }}").serialize(),
                    // success: function(response) {
                    //     if (response.status == true) {
                    //         alert("Reward successfully redeemed!");
                    //         window.location.reload();
                    //     } else {
                    //         alert("You don't have enough points to redeem this reward.");
                    //     }
                    // }
                });
            });
        @endforeach
    </script>
@endsection
