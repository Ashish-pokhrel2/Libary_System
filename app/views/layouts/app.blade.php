<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="{{ route('css/style.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Base URL for JavaScript -->
    <script>
        window.baseUrl = '{{ route("") }}';
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="{{ route('dashboard') }}">Library System</a>
            </div>
            <div class="navbar-menu">
                @if(isset($_SESSION['user_id']))
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('books') }}">Books</a>
                    <a href="{{ route('authors') }}">Authors</a>
                    <a href="{{ route('categories') }}">Categories</a>
                    <a href="{{ route('books/search') }}">Search</a>
                    <div class="navbar-user">
                        <span>Welcome, {{ $_SESSION['full_name'] ?? 'User' }}</span>
                        <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            @if($success ?? false)
                <div class="alert alert-success">
                    {{ $success }}
                </div>
            @endif

            @if($errors ?? false)
                <div class="alert alert-error">
                    {{ $errors }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Library System. All rights reserved.</p>
        </div>
    </footer>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ route('js/app.js') }}"></script>
</body>
</html>
