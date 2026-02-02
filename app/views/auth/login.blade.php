@extends('layouts.auth')

@section('content')
            <div class="auth-form">
                <h2>Login</h2>
                
                {{-- <div class="demo-credentials">
                    <p><strong>Demo Credentials:</strong></p>
                    <p>Librarian: <code>admin</code> / <code>password</code></p>
                    <p>Reader: <code>john_reader</code> / <code>password</code></p>
                </div> --}}

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>

                <div class="auth-links">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection