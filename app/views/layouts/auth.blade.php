<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Library System</h1>
            </div>

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
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
