<?php $__env->startSection('title', '500 - Internal Server Error'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container">
                <h1 class="display-1 text-danger">500</h1>
                <h2 class="mb-4">Internal Server Error</h2>
                <p class="lead text-muted mb-4">
                    Oops! Something went wrong on our end. We're working to fix the issue.
                </p>
                
                <div class="error-actions mt-4">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> Go to Dashboard
                    </a>
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go Back
                    </a>
                </div>

                <div class="mt-5">
                    <p class="text-muted">
                        If the problem persists, please contact the system administrator.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-container {
    padding: 50px 20px;
}

.error-container h1 {
    font-size: 120px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.error-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.error-actions .btn {
    min-width: 150px;
    padding: 12px 24px;
    font-size: 16px;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/errors/500.blade.php ENDPATH**/ ?>