@extends('layouts.app')

@section('content')
    <div>
        <div class="container">
            <section class="profile-section">
                <div class="profile-header">
                    <h2><span class="bold-text">Hai,{{ $user->name }}</span>!</h2>
                </div>

                <form action="{{ route('account.updateProfile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name"
                            id="name" disabled />
                        @error('name')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="text" value="{{ old('phonenumber', $user->phonenumber) }}"
                            class="form-control @error('phonenumber') is-invalid @enderror" placeholder="Phone Number"
                            name="phonenumber" id="phonenumber" disabled />
                        @error('phonenumber')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email"
                            id="email" disabled />
                        @error('email')
                            <p class='invalid-feedback'>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}"
                            required readonly disabled />
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $user->latitude) }}">
                        <input type="hidden" id="longitude" name="longitude"
                            value="{{ old('longitude', $user->longitude) }}">
                    </div>
                    <div id="map" style="height: 400px;"></div>
                    <div class="buttons">
                        <button type="button" class="btn btn-edit" id="edit-btn">Edit</button>
                        <button type="submit" class="btn btn-save">Save</button>
                    </div>
                </form>
            </section>
            <div class="image-container">
                <img src="{{ asset('images/trash.svg') }}" alt="Trash bin" class="trash-image">
            </div>
        </div>
    </div>
@endsection
