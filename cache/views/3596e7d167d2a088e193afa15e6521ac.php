<?php $__env->startSection('content'); ?>
<div class="dashboard">
    <h1>Reader Dashboard</h1>
    <p class="dashboard-subtitle">Welcome, <?php echo e($_SESSION['full_name']); ?>! Browse and search the library collection.</p>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-icon">📚</div>
            <h3>Browse Books</h3>
            <p>View all books available in the library.</p>
            <div class="card-actions">
                <a href="/books" class="btn btn-primary">View All Books</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">✍️</div>
            <h3>Browse Authors</h3>
            <p>Explore books by different authors.</p>
            <div class="card-actions">
                <a href="/authors" class="btn btn-primary">View All Authors</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">🗂️</div>
            <h3>Browse Categories</h3>
            <p>Discover books in various categories.</p>
            <div class="card-actions">
                <a href="/categories" class="btn btn-primary">View All Categories</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-icon">🔍</div>
            <h3>Search Books</h3>
            <p>Find books using advanced search filters.</p>
            <div class="card-actions">
                <a href="/books/search" class="btn btn-primary">Search Books</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/dashboard/reader.blade.php ENDPATH**/ ?>