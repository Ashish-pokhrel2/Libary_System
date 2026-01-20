<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Edit Author</h1>
    <a href="/authors" class="btn btn-secondary">Back to Authors</a>
</div>

<div class="form-container">
    <form action="/authors/update/<?php echo e($author['id']); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo e($author['name']); ?>" required autofocus>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="birth_year">Birth Year</label>
                <input type="number" id="birth_year" name="birth_year" value="<?php echo e($author['birth_year']); ?>" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="nationality">Nationality</label>
                <input type="text" id="nationality" name="nationality" value="<?php echo e($author['nationality']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="biography">Biography</label>
            <textarea id="biography" name="biography" rows="5"><?php echo e($author['biography']); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Update Author</button>
            <a href="/authors" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/authors/edit.blade.php ENDPATH**/ ?>