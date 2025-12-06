

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary: #3a4b41;
        --secondary: #E6CFA7;
    }
    
    /* Beige card styling for lawyers */
    .card-lawyer {
        background-color: #E6CFA7 !important;
        border: none !important;
    }
    
    .card-lawyer .card-body {
        background-color: #E6CFA7;
        color: #333;
    }
    
    .card-lawyer .card-title {
        font-weight: 600;
        color: #2d2d2d;
    }
    
    .card-lawyer .card-text {
        color: #555;
    }
    
    .card-lawyer .text-muted {
        color: #666 !important;
    }
    
    .card-lawyer .btn-book {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .card-lawyer .btn-book:hover {
        background-color: #2d3d33 !important;
        border-color: #2d3d33 !important;
    }
    
    /* Search card styling */
    .card-search {
        background-color: #E6CFA7 !important;
        border: none !important;
    }
    
    .card-search .form-select {
        border: 1px solid #999;
        background-color: white;
    }
    
    .card-search .btn {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: #E6CFA7 !important;
        font-weight: 500;
    }
    
    .card-search .btn:hover {
        background-color: #2d3d33 !important;
    }
    
    /* Hero Find Lawyer button */
    .hero-section .btn-primary {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: #E6CFA7 !important;
    }
    
    .hero-section .btn-primary:hover {
        background-color: #2d3d33 !important;
        border-color: #2d3d33 !important;
    }
</style>


<div class="row align-items-center mb-5 hero-section">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold">Welcome to LegalEase</h1>
        
        <p class="lead">Connect with verified lawyers quickly, securely, and conveniently.</p>
        
        <a href="<?php echo e(route('lawyers.index')); ?>" class="btn btn-primary btn-lg me-2">Find a Lawyer</a>
    </div>
    <div class="col-md-6 text-center">
        <img src="/images/logohome1.png" alt="LegalEase" class="img-fluid rounded">
    </div>
</div>


<div class="card shadow mb-5 p-4 card-search">
    <form action="<?php echo e(route('home')); ?>" method="GET" class="row g-3 align-items-center">
        <div class="col-md-5">
            <select name="specialization" class="form-select">
                <option value="">Select Specialization</option>
                <?php $__currentLoopData = $specializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($spec); ?>" <?php echo e($spec == $specialization ? 'selected' : ''); ?>><?php echo e($spec); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-5">
            <select name="province" class="form-select">
                <option value="">Select Province</option>
                <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($prov); ?>" <?php echo e($prov == $province ? 'selected' : ''); ?>><?php echo e($prov); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>
</div>


<?php $lawyersToShow = $searchResults ?? $featuredLawyers; ?>
<?php if($lawyersToShow): ?>
    <h2 class="mb-4"><?php echo e($searchResults ? 'Search Results' : 'Featured Lawyers'); ?></h2>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <?php $__empty_1 = true; $__currentLoopData = $lawyersToShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col">
                <div class="card h-100 shadow-sm card-lawyer">
                    <img src="<?php echo e($lawyer->avatar ?? '/images/default-lawyer.jpg'); ?>" class="card-img-top" alt="<?php echo e($lawyer->name); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($lawyer->name); ?></h5>
                        <p class="card-text"><?php echo e($lawyer->lawyerProfile->specialization ?? 'General Lawyer'); ?></p>
                        <p class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo e($lawyer->lawyerProfile->province ?? 'Nationwide'); ?></p>
                        <p>
                            <?php $avgRating = $lawyer->ratings->avg('rating'); ?>
                            <?php if($avgRating): ?>
                                <i class="bi bi-star-fill text-warning"></i>
                                <?php echo e(number_format($avgRating, 1)); ?>

                            <?php else: ?>
                                <span class="text-muted">No Ratings Yet</span>
                            <?php endif; ?>
                        </p>
                        <a href="<?php echo e(route('lawyers.show', $lawyer->id)); ?>" class="btn btn-book w-100 btn-primary">Book Appointment</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No lawyers found matching your criteria.</p>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>


<h2 class="mb-4">Legal Updates & Announcements</h2>
<div class="list-group mb-5 ">
    <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('announcements.index')); ?>" class="list-group-item list-group-item-action btn-primary"
                   style="
                        background-color: #3A4B41; 
                        color: #FFD700; 
                        padding: 20px; 
                        border-radius: 12px; 
                        margin-bottom: 12px; 
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        transition: 0.25s;
                    ">
            <div class="d-flex w-100 justify-content-between btn-primary">
                <h5 class="mb-1"><?php echo e($announcement->title); ?></h5>
                <small><?php echo e($announcement->created_at->format('d/m/Y')); ?></small>
            </div>
            <p class="mb-1 text-truncate"><?php echo e($announcement->content); ?></p>
        </a>
        <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\firstlaravel_demo\LegalEase\resources\views/home-auth.blade.php ENDPATH**/ ?>