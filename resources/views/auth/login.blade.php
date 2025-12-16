@extends('layouts.app')

@section('title', 'Auth')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="auth-container">
        <div class="auth-box" id="authBox">
        <!-- Login Form -->
        <div class="form login">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="login-email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="login-email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">{{ __('Password') }}</label>
                            <input id="login-password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                        <p class="mt-3">Don't have an account? <a href="javascript:void(0)" onclick="showRegister()">Register</a></p>
                    </form>
                </div>
            </div>
        </div>

        <!-- Register Form -->
        <div class="form register">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="register-email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="register-email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">{{ __('Password') }}</label>
                            <input id="register-password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                        <p class="mt-3">Already have an account? <a href="javascript:void(0)" onclick="showLogin()">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showRegister() {
    document.getElementById("authBox").style.transform = "translateX(-50%)";
}
function showLogin() {
    document.getElementById("authBox").style.transform = "translateX(0)";
}
</script>
<style>
.auth-container{
    width: 100%;
    overflow: hidden; /* ← これが重要！ */ 
    position: relative;
}
.auth-box {
    display: flex;
    width: 200%;
    transition: transform 0.8s ease-in-out;
}

.form {
    width: 100%;
    padding: 30px;
    box-sizing: border-box;
}

.card {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.btn-primary {
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    border: none;
}

a {
    cursor: pointer;
    color: #007bff;
    text-decoration: underline;
}
</style>
@endsection

