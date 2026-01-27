<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1>Search Books</h1>
    <a href="/books" class="btn btn-secondary">Back to Books</a>
</div>

<div class="search-container">
    <form action="/books/search" method="POST" class="search-form">
        <?php echo csrf_field(); ?>
        
        <div class="form-row">
            <div class="form-group autocomplete-container">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" placeholder="Start typing to search..." autocomplete="off">
                <div id="autocomplete-results" class="autocomplete-results"></div>
            </div>

            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" id="author" name="author" placeholder="Author name">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category['id']); ?>"><?php echo e($category['name']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="year_from">Publication Year (From)</label>
                <input type="number" id="year_from" name="year_from" min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="year_to">Publication Year (To)</label>
                <input type="number" id="year_to" name="year_to" min="1000" max="<?php echo date('Y'); ?>">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Search</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
        </div>
    </form>
</div>

<?php if($searchPerformed): ?>
    <div class="search-results">
        <h2>Search Results (<?php echo e(count($results)); ?> found)</h2>
        
        <?php if(empty($results)): ?>
            <p class="no-results">No books found matching your criteria.</p>
        <?php else: ?>
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
                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($book['isbn']); ?></td>
                                <td><?php echo e($book['title']); ?></td>
                                <td><?php echo e($book['author_name'] ?? 'N/A'); ?></td>
                                <td><?php echo e($book['category_name'] ?? 'N/A'); ?></td>
                                <td><?php echo e($book['publication_year'] ?? 'N/A'); ?></td>
                                <td><?php echo e($book['available_quantity']); ?>/<?php echo e($book['quantity']); ?></td>
                                <td class="actions">
                                    <a href="/books/show/<?php echo e($book['id']); ?>" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/books/search.blade.php ENDPATH**/ ?>