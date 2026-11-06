@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">NexaConsult</div>
            <p class="auth-subtitle">Create your account</p>
            <h1 class="auth-title">Register</h1>
        </div>

        <form id="registerForm" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" class="form-input"
                    required>
                <div class="error-message" id="name-error"></div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" class="form-input"
                    required>
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" class="form-input"
                    required>
                <div class="error-message" id="password-error"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Confirm your password" class="form-input" required>
                <div class="error-message" id="password-confirm-error"></div>
            </div>

            <button type="submit" class="auth-button" id="registerButton">
                Create Account
            </button>

            <div class="success-message" id="success-message"></div>
        </form>

        <div class="auth-footer">
            <p class="auth-text">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">Sign in here</a>
            </p>
        </div>
    </div>

    @stack('scripts')

@endsection
