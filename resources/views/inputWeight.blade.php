@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles_input.css') }}">
@endsection

@section('content')
    <form action="{{ route('storeData') }}" method="POST">
        @csrf
        <div class="container2">
            <h2>Input Weight</h2>
            <div class="card">
                <div class="user-profile">
                    <div class="avatar"></div>
                    <div>Request for, <strong>{{ $wasteRequest->recycleOrg->name }}</strong></div>
                </div>

                <div class="input-container">
                    {{-- Looping melalui data dari tabel waste_category --}}
                    @foreach ($categories as $category)
                        <div class="input-row">
                            <div>{{ $category->type }}</div>
                            <div class="input-group">
                                <button class="btn minus-btn" data-category="{{ $category->id }}">
                                    <img src="{{ asset('images/minus.svg') }}" alt="minus">
                                </button>
                                <span class="value">0</span>
                                <button class="btn plus-btn" data-category="{{ $category->id }}">
                                    <img src="{{ asset('images/add.svg') }}" alt="Add">
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="total-row">
                        <div>Total</div>
                        <div>0 kg</div>
                    </div>
                </div>

                <button type="submit" class="send-btn">Send</button>
            </div>

            <!-- Hidden field untuk mengirim data kategori dan berat -->
            <input type="hidden" name="wasteRequestID" value="{{ $wasteRequestID }}">
            <input type="hidden" name="categories" id="categories">
    </form>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.input-group').forEach(group => {
            const minusBtn = group.querySelector('.minus-btn');
            const plusBtn = group.querySelector('.plus-btn');
            const valueSpan = group.querySelector('.value');

            // Prevent form submission when buttons are clicked
            minusBtn.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent the form from being submitted
                let value = parseInt(valueSpan.textContent);
                if (value > 0) {
                    valueSpan.textContent = value - 1;
                    updateTotal();
                }
            });

            plusBtn.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent the form from being submitted
                let value = parseInt(valueSpan.textContent);
                valueSpan.textContent = value + 1;
                updateTotal();
            });
        });

        function updateTotal() {
            const values = [...document.querySelectorAll('.value')]
                .map(span => parseInt(span.textContent));
            const total = values.reduce((a, b) => a + b, 0);
            document.querySelector('.total-row div:last-child').textContent = total + ' kg';

            // Update input hidden categories
            const categories = [...document.querySelectorAll('.input-group')].map(group => {
                const categoryId = group.querySelector('.minus-btn').dataset.category;
                const weight = parseInt(group.querySelector('.value').textContent);
                return {
                    category_id: categoryId,
                    weight: weight
                };
            });
            document.getElementById('categories').value = JSON.stringify(categories);
        }
    </script>
@endsection
