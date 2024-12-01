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
        </div>
    </main>
@endsection
