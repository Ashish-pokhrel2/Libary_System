<?php $__env->startSection('content'); ?>
            <div class="auth-form">
                <h2>Login</h2>
                
                <div class="demo-credentials">
                    <p><strong>Demo Credentials:</strong></p>
                    <p>Librarian: <code>admin</code> / <code>password</code></p>
                    <p>Reader: <code>john_reader</code> / <code>password</code></p>
                </div>

                <form action="/login" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>

                <div class="auth-links">
                    <p>Don't have an account? <a href="/register">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/auth/login.blade.php ENDPATH**/ ?>