@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/trash2.css') }}">
    <style>
        .btn-disabled {
            background-color: #999;
            /* Warna abu-abu gelap */
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: not-allowed;
            opacity: 0.7;
            text-transform: capitalize;
            /* Kapitalisasi status (accepted/rejected) */
        }

        .btn-disabled:focus {
            outline: none;
        }

        .done-btn {
            background-color: #28a745;
            /* Warna hijau */
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: capitalize;
            border: 2px solid rgb(0, 0, 0);
            border-radius: 30px;
            width: 10vw;
        }

        .done-btn:hover {
            background-color: #218838;
            /* Warna hijau gelap saat hover */
        }

        .done-btn:focus {
            outline: none;
        }
    </style>
@endsection

@section('content')
    <main>
        <h2 class="page-title">Notification Request</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="request-box">
            <p class="request-info">
                <strong>Request Recycling,</strong> from {{ $request->user->name }}
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
            <br>
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
                    <p><strong>Expiry Date: </strong>
                        @if ($request->status === 'accepted')
                            <span style="color: #44B1FF; font-weight: bold;">
                                {{ \Carbon\Carbon::parse($request->expiryDate)->format('l, d F Y') }}
                            </span>
                        @endif
                    </p>
                @endif
            </div>

            <div class="buttons">
                @if ($request->status === 'pending')
                    <form action="{{ route('account.notificationRequest.update', $request->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit" class="accept-btn">Accept</button>
                    </form>

                    <form action="{{ route('account.notificationRequest.update', $request->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="reject-btn">Reject</button>
                    </form>
                @elseif ($request->status === 'accepted')
                    <form action="{{ route('account.notificationRequest.update', $request->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="done">
                        <button type="submit" class="done-btn">Done</button>
                    </form>
                @else
                    <button class="btn-disabled">{{ ucfirst($request->status) }}</button>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        // Menonaktifkan tombol setelah form disubmit
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true; // Menonaktifkan tombol submit
                    submitButton.classList.add('btn-disabled'); // Menambahkan kelas untuk tombol disabled
                    submitButton.textContent =
                        'Processing...'; // Mengubah teks tombol menjadi "Processing..."
                }
            });
        });
    </script>
@endsection
