
<?php $__env->startSection('title', 'Lawyer Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <!-- Flash Messages -->
    <?php if($message = session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #e6cfa7; color: #3a4b41; border: none;">
            <strong><i class="bi bi-check-circle"></i> Success!</strong> <?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($message = session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #3a4b41; color: #e6cfa7; border: none;">
            <strong><i class="bi bi-exclamation-circle"></i> Error!</strong> <?php echo e($message); ?>

            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-user"></i> Lawyer Profile Details
                        <a href="<?php echo e(url('/admin/lawyers')); ?>" class="btn btn-default btn-sm pull-right">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back to List
                        </a>
                    </h3>
                </div>
                <div class="panel-body">
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td><?php echo e($lawyer->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo e($lawyer->email); ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><span class="label label-info"><?php echo e(ucfirst($lawyer->role)); ?></span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php if($lawyer->status == 'active'): ?>
                                            <span class="label label-success">Active</span>
                                        <?php else: ?>
                                            <span class="label label-warning"><?php echo e(ucfirst($lawyer->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Approval Status</th>
                                    <td>
                                        <?php if($lawyer->approval_status == 'approved'): ?>
                                            <span class="label label-success">Approved</span>
                                        <?php elseif($lawyer->approval_status == 'pending'): ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email Verified</th>
                                    <td>
                                        <?php if($lawyer->email_verified_at): ?>
                                            <span class="label label-success">✓ Verified</span>
                                            <br><small><?php echo e($lawyer->email_verified_at->format('M d, Y H:i')); ?></small>
                                        <?php else: ?>
                                            <span class="label label-danger">Not Verified</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Joined Date</th>
                                    <td><?php echo e($lawyer->created_at->format('M d, Y H:i')); ?></td>
                                </tr>
                                <tr>
                                    <th>Last Active</th>
                                    <td><?php echo e($lawyer->last_login_at ? $lawyer->last_login_at->format('M d, Y H:i') : 'Never'); ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4>Professional Information</h4>
                            <?php if($lawyer->lawyerProfile): ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Specialization</th>
                                        <td><?php echo e($lawyer->lawyerProfile->specialization ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Experience</th>
                                        <td><?php echo e($lawyer->lawyerProfile->experience ?? 0); ?> years</td>
                                    </tr>
                                    <tr>
                                        <th>Bio</th>
                                        <td><?php echo e($lawyer->lawyerProfile->bio ?? 'No bio available'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Province</th>
                                        <td><?php echo e($lawyer->lawyerProfile->province ?? 'N/A'); ?></td>
                                    </tr>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign"></i> No professional profile created yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <!-- Documents/Certificates Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4><i class="glyphicon glyphicon-file"></i> Uploaded Documents & Certificates</h4>
                            
                            <?php if($lawyer->documents && $lawyer->documents->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>#</th>
                                                <th>File Name</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Uploaded Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $lawyer->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($index + 1); ?></td>
                                                    <td>
                                                        <i class="glyphicon glyphicon-file"></i>
                                                        <?php echo e($document->file_name); ?>

                                                    </td>
                                                    <td>
                                                        <span class="label label-info"><?php echo e(ucfirst($document->document_type)); ?></span>
                                                        <br>
                                                        <small class="text-muted"><?php echo e(strtoupper($document->file_extension)); ?></small>
                                                    </td>
                                                    <td><?php echo e($document->formatted_size); ?></td>
                                                    <td><?php echo e($document->created_at->format('M d, Y H:i')); ?></td>
                                                    <td>
                                                        <?php if(in_array($document->file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo e($document->id); ?>">
                                                                <i class="bi bi-eye"></i> View
                                                            </button>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(Storage::url($document->file_path)); ?>" class="btn btn-sm btn-primary" target="_blank">
                                                                <i class="bi bi-download"></i> Download
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                                <!-- Image Modal for Preview -->
                                                <?php if(in_array($document->file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                    <div class="modal fade" id="imageModal<?php echo e($document->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><?php echo e($document->file_name); ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="<?php echo e(Storage::url($document->file_path)); ?>" alt="<?php echo e($document->file_name); ?>" class="img-fluid" style="max-height: 600px;">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="<?php echo e(Storage::url($document->file_path)); ?>" class="btn btn-primary" download>
                                                                        <i class="bi bi-download"></i> Download
                                                                    </a>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="glyphicon glyphicon-exclamation-sign"></i> No documents uploaded yet.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>
                    <!-- Status Management Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4><i class="bi bi-sliders"></i> Status Management</h4>
                            
                            <?php if($lawyer->approval_status == 'pending'): ?>
                                <div class="alert alert-warning">
                                    <h5><i class="glyphicon glyphicon-exclamation-sign"></i> Action Required</h5>
                                    <p>This lawyer application is pending approval. Please review the information and take action.</p>
                                    
                                    <div class="d-flex gap-2 flex-wrap">
                                        <form action="<?php echo e(url('/admin/lawyers/' . $lawyer->id . '/approve')); ?>" method="POST" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this lawyer?')">
                                                <i class="glyphicon glyphicon-ok"></i> Approve
                                            </button>
                                        </form>

                                        <form action="<?php echo e(url('/admin/lawyers/' . $lawyer->id . '/reject')); ?>" method="POST" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this lawyer?')">
                                                <i class="glyphicon glyphicon-remove"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Current Status:</label>
                                                <p class="mb-0">
                                                    <?php if($lawyer->status == 'active'): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php elseif($lawyer->status == 'banned'): ?>
                                                        <span class="badge bg-danger">Banned</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning"><?php echo e(ucfirst($lawyer->status)); ?></span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-9">
                                                <?php if($lawyer->status === 'banned'): ?>
                                                    <div class="alert alert-danger mb-0">
                                                        <i class="bi bi-exclamation-triangle"></i> 
                                                        <strong>This account has been banned by the system.</strong>
                                                        <p class="mb-0 small">The account exists in the database but is restricted from accessing the system.</p>
                                                    </div>
                                                <?php else: ?>
                                                    <label class="form-label fw-bold d-block">Change Status:</label>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <?php if($lawyer->status !== 'active'): ?>
                                                            <form action="<?php echo e(route('admin.lawyers.update-status', $lawyer->id)); ?>" method="POST" style="display: inline;">
                                                                <?php echo csrf_field(); ?>
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    <i class="bi bi-check-circle"></i> Activate
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>

                                                        <form id="banForm" action="<?php echo e(route('admin.lawyers.update-status', $lawyer->id)); ?>" method="POST" style="display: inline;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <input type="hidden" name="status" value="banned">
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#banModal">
                                                            <i class="bi bi-exclamation-circle"></i> Ban
                                                        </button>

                                                        <?php if($lawyer->status !== 'inactive'): ?>
                                                            <form id="deactivateForm" action="<?php echo e(route('admin.lawyers.update-status', $lawyer->id)); ?>" method="POST" style="display: inline;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PUT'); ?>
                                                                <input type="hidden" name="status" value="inactive">
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                                                <i class="bi bi-pause-circle"></i> Deactivate
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ban Confirmation Modal -->
<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="banModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Ban
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to ban this lawyer?</p>
                <p class="text-muted small mb-3">This action will prevent the lawyer from accessing the system and an email notification will be sent.</p>
                
                <div class="mb-3">
                    <label for="banReasonSelect" class="form-label fw-bold">Select Ban Reason:</label>
                    <select class="form-select" id="banReasonSelect" name="ban_reason_id" required>
                        <option value="">-- Choose a reason --</option>
                        <?php $__currentLoopData = \App\Models\BanReason::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($reason->id); ?>"><?php echo e($reason->reason); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="submitBanForm();">
                    <i class="bi bi-exclamation-circle"></i> Yes, Ban Lawyer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Confirmation Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="deactivateModalLabel">
                    <i class="bi bi-pause-circle"></i> Confirm Deactivate
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to deactivate this lawyer?</p>
                <p class="text-muted small mb-0">The lawyer will not be able to receive new appointments but their profile will remain in the system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('deactivateForm').submit();">
                    <i class="bi bi-pause-circle"></i> Yes, Deactivate Lawyer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function submitBanForm() {
    const reasonSelect = document.getElementById('banReasonSelect');
    const selectedReason = reasonSelect.value;
    
    if (!selectedReason) {
        alert('Please select a ban reason.');
        return;
    }
    
    // Thêm ban_reason_id vào form
    const form = document.getElementById('banForm');
    const reasonInput = document.createElement('input');
    reasonInput.type = 'hidden';
    reasonInput.name = 'ban_reason_id';
    reasonInput.value = selectedReason;
    form.appendChild(reasonInput);
    
    // Submit form
    form.submit();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH G:\firstlaravel_demo\LegalEase\resources\views/admin/lawyers/show.blade.php ENDPATH**/ ?>