

<?php $__env->startSection('title', 'Sign In - LegalEase'); ?>

<?php $__env->startSection('content'); ?>
<div>
    <h1 class="auth-title">
        <i class="fas fa-balance-scale me-2" style="color: #3a4b41;"></i>Welcome Back
    </h1>
    <p class="auth-subtitle">Sign in to your LegalEase account</p>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" novalidate>
        <?php echo csrf_field(); ?>
        
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2" style="color: #3a4b41;"></i>Email Address
            </label>
            <input type="text" 
                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="email" 
                   name="email" 
                   value="<?php echo e(old('email', request()->cookie('remember_email'))); ?>" 
                   required
                   autocomplete="email" 
                   autofocus
                   placeholder="Enter your email">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback" style="display: block;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2" style="color: #3a4b41;"></i>Password
            </label>
            <div class="password-input-wrapper">
                <input type="password" 
                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="password" 
                       name="password" 
                       required
                       autocomplete="current-password"
                       placeholder="Enter your password">
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback" style="display: block;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </div>

        <div class="text-center auth-divider">OR</div>

        <div class="text-center mb-4">
            <p class="mb-3 text-muted">Don't have an account yet?</p>
            <div class="row g-2">
                <div class="col-6">
                    <a href="<?php echo e(route('register.customer')); ?>" class="btn btn-outline-secondary w-100" style="border-color: #3a4b41; color: #3a4b41;">
                        <i class="fas fa-user me-1"></i>Customer
                    </a>
                </div>
                <div class="col-6">
                    <a href="<?php echo e(route('register.lawyer')); ?>" class="btn btn-outline-secondary w-100" style="border-color: #3a4b41; color: #3a4b41;">
                        <i class="fas fa-user-tie me-1"></i>Lawyer
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="#" style="color: #3a4b41; text-decoration: none; font-size: 14px;">
                <i class="fas fa-key me-1"></i>Forgot Password?
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
<div class="logo">
    <i class="fas fa-balance-scale"></i>
</div>
<h2>LegalEase</h2>
<p>Your trusted platform to connect with expert lawyers and manage your legal matters efficiently.</p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        this.classList.add('fa-eye');
        this.classList.remove('fa-eye-slash');
    }
});

document.getElementById('remember').addEventListener('change', function() {
    const label = document.querySelector('label[for="remember"]');
    if (this.checked) {
        label.classList.add('fw-semibold');
        label.style.color = '#3a4b41';
    } else {
        label.classList.remove('fw-semibold');
        label.style.color = '#666';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\firstlaravel_demo\LegalEase\resources\views/auth/login.blade.php ENDPATH**/ ?>