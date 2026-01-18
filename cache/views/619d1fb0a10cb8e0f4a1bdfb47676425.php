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
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/layouts/auth.blade.php ENDPATH**/ ?>