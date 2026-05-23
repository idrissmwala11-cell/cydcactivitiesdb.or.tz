<?php $__env->startSection('title', 'Local Sponsorship'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1">Local Sponsorship</h2>
            <p class="text-muted mb-0">Manage children registered under local sponsorship.</p>
        </div>
        <a href="<?php echo e(route('local-sponsorship.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Record
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?php if($localSponsorships->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Age</th>
                                <th>Location</th>
                                <th>Sponsor</th>
                                <th>Local Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $localSponsorships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($record->child_name); ?></td>
                                    <td><?php echo e($record->child_age); ?></td>
                                    <td><?php echo e($record->child_location); ?></td>
                                    <td>
                                        <div><?php echo e($record->sponsor_name); ?></div>
                                        <small class="text-muted"><?php echo e($record->sponsor_type); ?></small>
                                    </td>
                                    <td><?php echo e($record->local_number); ?></td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="<?php echo e(route('local-sponsorship.show', $record)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="<?php echo e(route('local-sponsorship.edit', $record)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-heart text-primary" style="font-size: 2.25rem;"></i>
                    <p class="text-muted mt-3 mb-0">No local sponsorship records found yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-3">
        <?php echo e($localSponsorships->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/local-sponsorship/index.blade.php ENDPATH**/ ?>