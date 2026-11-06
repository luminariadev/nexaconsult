@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">NexaConsult</div>
            <p class="auth-subtitle">Welcome back</p>
            <h1 class="auth-title">Login to your account</h1>
        </div>

        <form id="loginForm" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" class="form-input"
                    required>
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="form-input"
                    required>
                <div class="error-message" id="password-error"></div>
            </div>

            <button type="submit" class="auth-button" id="loginButton">
                Sign In
            </button>

            <div class="error-message" id="login-error"></div>
        </form>

        <div class="auth-footer">
            <p class="auth-text">
                Don't have an account?
                <a href="{{ route('register') }}" class="auth-link">Create one here</a>
            </p>
        </div>
    </div>

    @stack('scripts')

@endsection
