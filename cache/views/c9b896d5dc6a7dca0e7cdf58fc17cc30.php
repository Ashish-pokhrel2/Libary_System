<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="<?php echo e(route('css/style.css')); ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Base URL for JavaScript -->
    <script>
        window.baseUrl = '<?php echo e(route("")); ?>';
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="<?php echo e(route('dashboard')); ?>">Library System</a>
            </div>
            <div class="navbar-menu">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                    <a href="<?php echo e(route('books')); ?>">Books</a>
                    <a href="<?php echo e(route('authors')); ?>">Authors</a>
                    <a href="<?php echo e(route('categories')); ?>">Categories</a>
                    <a href="<?php echo e(route('books/search')); ?>">Search</a>
                    <div class="navbar-user">
                        <span>Welcome, <?php echo e($_SESSION['full_name'] ?? 'User'); ?></span>
                        <a href="<?php echo e(route('logout')); ?>" class="btn-logout">Logout</a>
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
    <script src="<?php echo e(route('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/layouts/app.blade.php ENDPATH**/ ?>