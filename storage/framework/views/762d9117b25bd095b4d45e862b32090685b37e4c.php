
<?php $__env->startSection('title', 'Manage Lawyers'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .pagination {
        margin: 0;
    }
    .pagination .page-link {
        color: #3a4b41;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 4px;
    }
    .pagination .page-link:hover {
        background-color: #e6cfa7;
        border-color: #e6cfa7;
        color: #3a4b41;
    }
    .pagination .page-item.active .page-link {
        background-color: #3a4b41;
        border-color: #3a4b41;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    .table-hover tbody tr:hover td {
        background-color: #f5f5f5 !important;
    }
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    table tbody tr:hover {
        background-color: #f5f5f5 !important;
    }
    table tbody tr {
        cursor: pointer;
    }
</style>

<div class="container-fluid py-4 text-center">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 text-center">
        <div class="w-100 text-center">
            <h2 class="mb-0 text-center"><i class="bi bi-briefcase"></i> Manage Lawyers</h2>
            <p class="text-muted mb-0">View and manage all lawyer accounts</p>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.lawyers.index')); ?>" class="d-flex gap-3 align-items-center">
                <div class="input-group" style="max-width: 400px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search" 
                           value="<?php echo e(request('search')); ?>">
                </div>

                <select name="status" class="form-select" style="width: 150px;">
                    <option value="" disabled selected hidden>Status</option>
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="banned" <?php echo e(request('status') === 'banned' ? 'selected' : ''); ?>>Banned</option>
                </select>

                <select name="specialization" class="form-select" style="width: 200px;">
                    <option value="" disabled selected hidden>Specialization</option>
                    <option value="">All Specializations</option>
                    <option value="Criminal Law" <?php echo e(request('specialization') === 'Criminal Law' ? 'selected' : ''); ?>>Criminal Law</option>
                    <option value="Civil Law" <?php echo e(request('specialization') === 'Civil Law' ? 'selected' : ''); ?>>Civil Law</option>
                    <option value="Family Law" <?php echo e(request('specialization') === 'Family Law' ? 'selected' : ''); ?>>Family Law</option>
                    <option value="Corporate Law" <?php echo e(request('specialization') === 'Corporate Law' ? 'selected' : ''); ?>>Corporate Law</option>
                    <option value="Labor Law" <?php echo e(request('specialization') === 'Labor Law' ? 'selected' : ''); ?>>Labor Law</option>
                    <option value="Real Estate Law" <?php echo e(request('specialization') === 'Real Estate Law' ? 'selected' : ''); ?>>Real Estate Law</option>
                    <option value="Intellectual Property" <?php echo e(request('specialization') === 'Intellectual Property' ? 'selected' : ''); ?>>Intellectual Property</option>
                    <option value="Tax Law" <?php echo e(request('specialization') === 'Tax Law' ? 'selected' : ''); ?>>Tax Law</option>
                    <option value="Immigration Law" <?php echo e(request('specialization') === 'Immigration Law' ? 'selected' : ''); ?>>Immigration Law</option>
                    <option value="Environmental Law" <?php echo e(request('specialization') === 'Environmental Law' ? 'selected' : ''); ?>>Environmental Law</option>
                    <option value="Contract Law" <?php echo e(request('specialization') === 'Contract Law' ? 'selected' : ''); ?>>Contract Law</option>
                    <option value="Administrative Law" <?php echo e(request('specialization') === 'Administrative Law' ? 'selected' : ''); ?>>Administrative Law</option>
                </select>

                <button type="submit" class="btn btn-primary" style="width: 150px; height: 38px; background-color: #3a4b41; border-color: #3a4b41;">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                
                <?php if(request()->hasAny(['search', 'status', 'specialization'])): ?>
                <a href="<?php echo e(route('admin.lawyers.index')); ?>" class="btn btn-primary" style="width: 150px; height: 38px; background-color: #3a4b41; border-color: #3a4b41;">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Lawyers Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="background-color: #3a4b41 !important;">
                            <th style="width: 5%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">No.</th>
                            <th style="width: 22%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Name</th>
                            <th style="width: 25%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Email</th>
                            <th style="width: 18%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Specialization</th>
                            <th style="width: 12%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Status</th>
                            <th style="width: 18%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $lawyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lawyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr onclick="window.location.href='<?php echo e(route('admin.lawyers.show', $lawyer->id)); ?>'" style="cursor: pointer;">
                            <td><?php echo e($lawyers->firstItem() + $index); ?></td>
                            <td>
                                <strong><?php echo e($lawyer->name); ?></strong>
                            </td>
                            <td>
                                <small class="text-muted"><?php echo e($lawyer->email); ?></small>
                            </td>
                            <td>
                                <small><?php echo e($lawyer->lawyerProfile->specialization ?? 'N/A'); ?></small>
                            </td>
                            <td>
                                <?php if($lawyer->status === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php elseif($lawyer->status === 'inactive'): ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php elseif($lawyer->status === 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Banned</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted"><?php echo e($lawyer->created_at->format('M d, Y')); ?></small>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">No lawyers found</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($lawyers->hasPages()): ?>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing <?php echo e($lawyers->firstItem()); ?> to <?php echo e($lawyers->lastItem()); ?> of <?php echo e($lawyers->total()); ?> results
                </div>
                <nav aria-label="Page navigation">
                    <?php echo e($lawyers->appends(request()->query())->links('pagination::bootstrap-4')); ?>

                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\firstlaravel_demo\LegalEase\resources\views/admin/lawyers.blade.php ENDPATH**/ ?>