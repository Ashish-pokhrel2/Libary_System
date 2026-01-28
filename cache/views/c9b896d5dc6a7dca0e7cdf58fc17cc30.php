<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="/css/style.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="/dashboard">Library System</a>
            </div>
            <div class="navbar-menu">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="/dashboard">Dashboard</a>
                    <a href="/books">Books</a>
                    <a href="/authors">Authors</a>
                    <a href="/categories">Categories</a>
                    <a href="/books/search">Search</a>
                    <div class="navbar-user">
                        <span>Welcome, <?php echo e($_SESSION['full_name'] ?? 'User'); ?></span>
                        <a href="/logout" class="btn-logout">Logout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <?php if($success ?? false): ?>
                <div class="alert alert-success">
                    <?php echo e($success); ?>

                </div>
            <?php endif; ?>

            <?php if($errors ?? false): ?>
                <div class="alert alert-error">
                    <?php echo e($errors); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo e(date('Y')); ?> Library System. All rights reserved.</p>
        </div>
    </footer>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/app.js"></script>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/layouts/app.blade.php ENDPATH**/ ?>