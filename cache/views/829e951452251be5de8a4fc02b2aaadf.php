<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Edit Book</h1>
    <a href="/books" class="btn btn-secondary">Back to Books</a>
</div>

<div class="form-container">
    <form action="/books/update/<?php echo e($book['id']); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-row">
            <div class="form-group">
                <label for="isbn">ISBN *</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo e($book['isbn']); ?>" required>
            </div>

            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" value="<?php echo e($book['title']); ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="author_id">Author *</label>
                <select id="author_id" name="author_id" required>
                    <option value="">Select Author</option>
                    <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($author['id']); ?>" <?php echo ($book['author_id'] == $author['id']) ? 'selected' : ''; ?>>
                            <?php echo e($author['name']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category['id']); ?>" <?php echo ($book['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo e($category['name']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="publication_year">Publication Year</label>
                <input type="number" id="publication_year" name="publication_year" value="<?php echo e($book['publication_year']); ?>" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" id="publisher" name="publisher" value="<?php echo e($book['publisher']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" value="<?php echo e($book['pages']); ?>" min="1">
            </div>

            <div class="form-group">
                <label for="quantity">Quantity *</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo e($book['quantity']); ?>" min="1" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="available_quantity">Available Quantity *</label>
                <input type="number" id="available_quantity" name="available_quantity" value="<?php echo e($book['available_quantity']); ?>" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"><?php echo e($book['description']); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Book</button>
            <a href="/books" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/books/edit.blade.php ENDPATH**/ ?>