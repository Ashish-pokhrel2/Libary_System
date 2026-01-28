<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Books</h1>
    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
        <a href="/books/create" class="btn btn-success">Add New Book</a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Year</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($books)): ?>
                <tr>
                    <td colspan="7" class="text-center">No books found.</td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($book['isbn']); ?></td>
                        <td><?php echo e($book['title']); ?></td>
                        <td><?php echo e($book['author_name'] ?? 'N/A'); ?></td>
                        <td><?php echo e($book['category_name'] ?? 'N/A'); ?></td>
                        <td><?php echo e($book['publication_year'] ?? 'N/A'); ?></td>
                        <td><?php echo e($book['available_quantity']); ?>/<?php echo e($book['quantity']); ?></td>
                        <td class="actions">
                            <a href="/books/show/<?php echo e($book['id']); ?>" class="btn btn-sm btn-info">View</a>
                            <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'librarian'): ?>
                                <a href="/books/edit/<?php echo e($book['id']); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/books/delete/<?php echo e($book['id']); ?>" onclick="return confirmDelete(this.href, 'book')" class="btn btn-sm btn-danger">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/books/index.blade.php ENDPATH**/ ?>