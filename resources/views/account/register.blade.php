<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="rectangle">
        <img src="{{ asset('images/ellipse-1-4.svg') }}" alt="Deskripsi Gambar" class="ellipse-blue-1-4">
        <img src="{{ asset('images/ellipse-2-6.svg') }}" alt="Deskripsi Gambar" class="ellipse-blue-2-6">
        <img src="{{ asset('images/ellipse-3-5.svg') }}" alt="Deskripsi Gambar" class="ellipse-blue-3-5">
        <h2 class="text-2">Sign Up</h2>
    </div>
    <div class="trash">
        <img src="{{ asset('images/trash.svg') }}" alt="Deskripsi Gambar">
    </div>
    <div class="page-signup-user-1">
        <div class="form-container">
            <h3 class="text-3"><strong>Sign Up</strong></h3>
            <form action="{{ route('account.processRegister') }}" method="post">
                @csrf
                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                        placeholder="Enter your name">
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number Field -->
                <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" value="{{ old('phonenumber') }}"
                        class="form-control @error('phonenumber') is-invalid @enderror" name="phonenumber"
                        id="phonenumber" placeholder="Enter your phone number">
                    @error('phonenumber')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

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

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password" placeholder="Enter your password">
                    @error('password')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" id="password_confirmation" placeholder="Confirm your password">
                    @error('password_confirmation')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Sign Up</button>
            </form>
        </div>
</body>

</html>
