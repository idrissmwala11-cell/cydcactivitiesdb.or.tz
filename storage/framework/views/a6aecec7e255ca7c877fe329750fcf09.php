<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">
                        <i class="bi bi-stars text-warning me-2"></i>
                        Talents Management
                    </h4>
                    <p class="text-muted mb-0">Manage participant talents, training needs, and submitted records clearly.</p>
                </div>

                <a href="<?php echo e(route('talents.create')); ?>" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-1"></i>Add New Talent
                </a>
            </div>
        </div>

        <div class="card-body px-4 pb-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-3">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-3">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-warning bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Total Talent Records</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(number_format($talents->total())); ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Needs Training</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(number_format($talents->where('needs_training', true)->count())); ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-info bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Competed</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(number_format($talents->where('has_competed', true)->count())); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($talents->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Participant #</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Talent Type</th>
                                <th>Duration</th>
                                <th>Competed</th>
                                <th>Needs Training</th>
                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <th>Submitted By</th>
                                <?php endif; ?>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $talents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $submittedBy = $talent->user->center_id
                                        ?? $talent->user->email
                                        ?? $talent->user->name
                                        ?? null;
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark"><?php echo e($talent->student_name); ?></div>
                                    </td>

                                    <td><?php echo e($talent->participant_number); ?></td>

                                    <td><?php echo e($talent->age); ?></td>

                                    <td>
                                        <span class="badge bg-<?php echo e($talent->gender === 'Male' ? 'primary' : 'secondary'); ?> px-3 py-2">
                                            <?php echo e($talent->gender); ?>

                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-medium text-dark"><?php echo e($talent->talent_type); ?></div>
                                    </td>

                                    <td><?php echo e($talent->talent_duration); ?></td>

                                    <td>
                                        <span class="badge bg-<?php echo e($talent->has_competed ? 'success' : 'secondary'); ?> px-3 py-2">
                                            <?php echo e($talent->has_competed ? 'Yes' : 'No'); ?>

                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-<?php echo e($talent->needs_training ? 'warning text-dark' : 'secondary'); ?> px-3 py-2">
                                            <?php echo e($talent->needs_training ? 'Yes' : 'No'); ?>

                                        </span>
                                    </td>

                                    <?php if(auth()->user()->role === 'admin'): ?>
                                        <td>
                                            <?php if($submittedBy): ?>
                                                <div class="fw-semibold text-dark"><?php echo e($submittedBy); ?></div>
                                                <?php if($talent->user?->email && $talent->user?->center_id): ?>
                                                    <small class="text-muted"><?php echo e($talent->user->email); ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge bg-warning-subtle text-warning">Legacy record</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="<?php echo e(route('talents.show', $talent->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>

                                            <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $talent->user_id): ?>
                                                <a href="<?php echo e(route('talents.edit', $talent->id)); ?>" class="btn btn-sm btn-outline-warning">
                                                    Edit
                                                </a>

                                                <form action="<?php echo e(route('talents.destroy', $talent->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this talent record?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($talents->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-stars text-muted mb-3" style="font-size: 2.5rem;"></i>
                    <h5 class="text-muted">No talent records found</h5>
                    <p class="text-muted">Start by adding your first talent record.</p>
                    <a href="<?php echo e(route('talents.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add New Talent
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/talents/index.blade.php ENDPATH**/ ?>