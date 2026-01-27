<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Authors</h1>
    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
        <a href="/authors/create" class="btn btn-success">Add New Author</a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Nationality</th>
                <th>Birth Year</th>
                <th>Books Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($authors)): ?>
                <tr>
                    <td colspan="5" class="text-center">No authors found.</td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($author['name']); ?></td>
                        <td><?php echo e($author['nationality'] ?? 'N/A'); ?></td>
                        <td><?php echo e($author['birth_year'] ?? 'N/A'); ?></td>
                        <td><?php echo e($author['books_count'] ?? 0); ?></td>
                        <td class="actions">
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
                                <a href="/authors/edit/<?php echo e($author['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/authors/delete/<?php echo e($author['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this author?')">Delete</a>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/authors/index.blade.php ENDPATH**/ ?>