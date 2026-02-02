@if(isset($_SESSION['user_id']))
    @extends('layouts.app')

    @section('content')
    <div class="error-container" style="text-align: center; padding: 60px 20px;">
        <div style="font-size: 120px; font-weight: bold; color: #e74c3c; margin-bottom: 20px;">404</div>
        <h1 style="font-size: 36px; color: #2c3e50; margin-bottom: 20px;">Page Not Found</h1>
        <p style="font-size: 18px; color: #7f8c8d; margin-bottom: 40px;">
            Sorry, the page you are looking for doesn't exist or has been moved.
        </p>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="margin-right: 10px;">Go to Dashboard</a>
            <a href="{{ route('books') }}" class="btn btn-secondary">Browse Books</a>
        </div>
    </div>
    @endsection
@else
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .error-page-wrapper {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .error-page-wrapper .error-container {
            background: #ffffff;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 600px;
            width: 100%;
            margin: 0;
        }
        
        .error-page-wrapper .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #e74c3c;
            margin: 0 0 20px 0;
            padding: 0;
            line-height: 1;
        }
        
        .error-page-wrapper .error-container h1 {
            font-size: 36px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 20px 0;
            padding: 0;
        }
        
        .error-page-wrapper .error-container p {
            font-size: 18px;
            color: #7f8c8d;
            margin: 0 0 40px 0;
            padding: 0;
            line-height: 1.6;
        }
        
        .error-page-wrapper .btn-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
        }
        
        .error-page-wrapper .btn-container .btn {
            display: inline-block;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            margin: 0;
        }
        
        .error-page-wrapper .btn-container .btn-primary {
            background-color: #667eea;
            color: #ffffff;
        }
        
        .error-page-wrapper .btn-container .btn-primary:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .error-page-wrapper .btn-container .btn-secondary {
            background-color: #48bb78;
            color: #ffffff;
        }
        
        .error-page-wrapper .btn-container .btn-secondary:hover {
            background-color: #38a169;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
        }
        
        @media (max-width: 600px) {
            .error-page-wrapper .error-code {
                font-size: 80px;
            }
            
            .error-page-wrapper .error-container h1 {
                font-size: 28px;
            }
            
            .error-page-wrapper .error-container p {
                font-size: 16px;
            }
            
            .error-page-wrapper .error-container {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="error-page-wrapper">
        <div class="error-container">
            <div class="error-code">404</div>
            <h1>Page Not Found</h1>
            <p>
                Oops! The page you are looking for doesn't exist or has been moved. 
                Please login or register to access the Library System.
            </p>
            <div class="btn-container">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
@endif
