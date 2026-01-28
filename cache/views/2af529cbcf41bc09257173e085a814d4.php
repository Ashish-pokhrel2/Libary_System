<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Book Details</h1>
    <div>
        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
            <a href="/books/edit/<?php echo e($book['id']); ?>" class="btn btn-primary">Edit</a>
        <?php endif; ?>
        <a href="/books" class="btn btn-secondary">Back to Books</a>
    </div>
</div>

<div class="details-container">
    <div class="details-section">
        <h3>Basic Information</h3>
        <div class="details-grid">
            <div class="detail-item">
                <strong>ISBN:</strong>
                <span><?php echo e($book['isbn']); ?></span>
            </div>
            <div class="detail-item">
                <strong>Title:</strong>
                <span><?php echo e($book['title']); ?></span>
            </div>
            <div class="detail-item">
                <strong>Author:</strong>
                <span><?php echo e($book['author_name'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-item">
                <strong>Category:</strong>
                <span><?php echo e($book['category_name'] ?? 'N/A'); ?></span>
            </div>
        </div>
    </div>

    <div class="details-section">
        <h3>Publication Details</h3>
        <div class="details-grid">
            <div class="detail-item">
                <strong>Publication Year:</strong>
                <span><?php echo e($book['publication_year'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-item">
                <strong>Publisher:</strong>
                <span><?php echo e($book['publisher'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-item">
                <strong>Pages:</strong>
                <span><?php echo e($book['pages'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-item">
                <strong>Nationality:</strong>
                <span><?php echo e($book['nationality'] ?? 'N/A'); ?></span>
            </div>
        </div>
    </div>

    <div class="details-section">
        <h3>Availability</h3>
        <div class="details-grid">
            <div class="detail-item">
                <strong>Total Quantity:</strong>
                <span><?php echo e($book['quantity']); ?></span>
            </div>
            <div class="detail-item">
                <strong>Available Quantity:</strong>
                <span class="<?php echo ($book['available_quantity'] > 0) ? 'text-success' : 'text-danger'; ?>">
                    <?php echo e($book['available_quantity']); ?>

                </span>
            </div>
        </div>
    </div>

    <?php if(!empty($book['description'])): ?>
        <div class="details-section">
            <h3>Description</h3>
            <p><?php echo e($book['description']); ?></p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/books/show.blade.php ENDPATH**/ ?>