<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Categories</h1>
    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
        <a href="/categories/create" class="btn btn-success">Add New Category</a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Books Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($categories)): ?>
                <tr>
                    <td colspan="4" class="text-center">No categories found.</td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($category['name']); ?></td>
                        <td><?php echo e($category['description'] ?? 'N/A'); ?></td>
                        <td><?php echo e($category['books_count'] ?? 0); ?></td>
                        <td class="actions">
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
                                <a href="/categories/edit/<?php echo e($category['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/categories/delete/<?php echo e($category['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                            <?php else: ?>
                                <span class="text-muted">View Only</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/categories/index.blade.php ENDPATH**/ ?>