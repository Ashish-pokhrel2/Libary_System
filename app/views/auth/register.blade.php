@extends('layouts.auth')

@section('content')
            <div class="auth-form">
                <h2>Register</h2>

                <form action="/register" method="POST" id="registerForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                        <small>Minimum 3 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <small>Minimum 6 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>

                <div class="auth-links">
                    <p>Already have an account? <a href="/login">Login here</a></p>
                </div>
            </div>
@endsection