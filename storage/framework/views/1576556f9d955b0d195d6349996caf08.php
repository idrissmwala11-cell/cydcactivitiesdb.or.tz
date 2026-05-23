<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-building-check me-2"></i>
                        School Visitation Records
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo e(route('reports.run', ['module' => 'school_visitation', 'center_id' => strtoupper(auth()->user()->center_id ?? ''), 'period' => 'all'])); ?>" class="btn btn-success">
                            <i class="bi bi-bar-chart-line me-1"></i>
                            Run Report
                        </a>
                        <a href="<?php echo e(route('school-visitation.create')); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Add New Record
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Participant Name</th>
                                    <th>Registration Number</th>
                                    <th>School</th>
                                    <th>Class</th>
                                    <th>Presence</th>
                                    <?php if(Auth::user()->role === 'admin'): ?>
                                        <th>Submitted By</th>
                                    <?php endif; ?>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $schoolVisitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($visitation->id); ?></td>
                                        <td><?php echo e($visitation->participant_name); ?></td>
                                        <td><?php echo e($visitation->registration_number); ?></td>
                                        <td><?php echo e($visitation->school_name); ?></td>
                                        <td><?php echo e($visitation->class_level); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($visitation->participant_presence === 'Present' ? 'success' : 'danger'); ?>">
                                                <?php echo e($visitation->participant_presence); ?>

                                            </span>
                                        </td>
                                        <?php if(Auth::user()->role === 'admin'): ?>
                                            <td><?php echo e($visitation->user->center_id ?? $visitation->user->email ?? $visitation->user->name ?? 'Legacy record'); ?></td>
                                        <?php endif; ?>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('school-visitation.show', $visitation)); ?>" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if(Auth::user()->role === 'admin' || Auth::id() === (int) $visitation->user_id): ?>
                                                    <a href="<?php echo e(route('school-visitation.edit', $visitation)); ?>" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('school-visitation.destroy', $visitation)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="<?php echo e(Auth::user()->role === 'admin' ? 8 : 7); ?>" class="text-center py-4">
                                            <i class="bi bi-building-check text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No school visitation records available at the moment.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($schoolVisitations->hasPages()): ?>
                        <div class="mt-4">
                            <?php echo e($schoolVisitations->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-visitation/index.blade.php ENDPATH**/ ?>