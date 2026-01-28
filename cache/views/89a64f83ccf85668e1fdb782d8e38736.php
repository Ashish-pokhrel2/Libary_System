<?php $__env->startSection('content'); ?>
            <div class="auth-form">
                <h2>Register</h2>

                <form action="/register" method="POST" id="registerForm">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo e(old('username')); ?>" required autofocus>
                        <small>Minimum 3 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo e(old('full_name')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <small>Minimum 6 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>

                <div class="auth-links">
                    <p>Already have an account? <a href="/login">Login here</a></p>
                </div>
            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /opt/lampp/htdocs/LibarySystem/app/views/auth/register.blade.php ENDPATH**/ ?>