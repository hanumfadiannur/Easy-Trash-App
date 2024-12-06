@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/report_style.css') }}">
@endsection

@section('content')
    <main>
        <h2 class="page-title">Your Request</h2>
        <div class="request-box">
            <p class="request-info">
                <strong>Request Recycling,</strong> to {{ $request->recycleOrg->name }}
            </p>

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

            <div class="request-info">
                @if ($request->status === 'accepted' || $request->status === 'rejected')
                    <p><strong>Status:</strong>
                        @if ($request->status === 'accepted')
                            <span style="color: green; font-weight: bold;">{{ $request->status }}</span>
                        @elseif($request->status === 'rejected')
                            <span style="color: red; font-weight: bold;">{{ $request->status }}</span>
                        @else
                            <span>{{ $request->status }}</span>
                        @endif
                    </p>
                    @if ($request->status === 'accepted')
                        <p><strong>Expiry Date: </strong>
                            <span style="color: #44B1FF; font-weight: bold;">
                                {{ \Carbon\Carbon::parse($request->expiryDate)->format('l, d F Y') }}
                            </span>
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </main>
@endsection
