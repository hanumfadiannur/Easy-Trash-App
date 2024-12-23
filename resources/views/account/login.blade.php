<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body>
    @include('layouts.message')
    <div class="rectangle">
        <img src="{{ asset('images/ellipse-green-1-4.svg') }}" alt="Deskripsi Gambar" class="ellipse-green-1-4">
        <img src="{{ asset('images/ellipse-green-2-6.svg') }}" alt="Deskripsi Gambar" class="ellipse-green-2-6">
        <img src="{{ asset('images/ellipse-green-3-5.svg') }}" alt="Deskripsi Gambar" class="ellipse-green-3-5">
        <h2 class="text-2">Sign In</h2>
    </div>
    <div class="trashLogo">
        <img src="{{ asset('images/trash.svg') }}" alt="Deskripsi Gambar">
    </div>
    <div class="page-sign-user-1">
        <div class="form-container">
            <h3 class="text-3"><strong>Sign In</strong></h3>
            <form action="{{ route('account.authenticate') }}" method="post">
                @csrf
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                        placeholder="Enter your email">
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" placeholder="Enter your password">
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Field -->
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="recycleorg" {{ old('role') == 'recycleorg' ? 'selected' : '' }}>
                            Recycling Organization
                        </option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Sign In</button>
            </form>
        </div>
        <a href="{{ route('account.register') }}"
            style="color: black; text-decoration: underline; display: block; text-align: center;">Sign up if you don't
            have an account</a>



</body>

</html>
