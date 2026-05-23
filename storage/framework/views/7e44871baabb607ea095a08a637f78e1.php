<?php $__env->startSection('title', 'View Local Sponsorship'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1"><?php echo e($localSponsorship->child_name); ?></h2>
            <p class="text-muted mb-0">Local sponsorship record details.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('local-sponsorship.edit', $localSponsorship)); ?>" class="btn btn-outline-primary">Edit</a>
            <a href="<?php echo e(route('local-sponsorship.index')); ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <strong>Child's Name</strong>
                    <div class="text-muted"><?php echo e($localSponsorship->child_name); ?></div>
                </div>
                <div class="col-md-6">
                    <strong>Child's Age</strong>
                    <div class="text-muted"><?php echo e($localSponsorship->child_age); ?></div>
                </div>
                <div class="col-md-6">
                    <strong>Location</strong>
                    <div class="text-muted"><?php echo e($localSponsorship->child_location); ?></div>
                </div>
                <div class="col-md-6">
                    <strong>Child's Local Number</strong>
                    <div class="text-muted"><?php echo e($localSponsorship->local_number); ?></div>
                </div>
                <div class="col-md-6">
                    <strong>Sponsor Type</strong>
                    <div class="text-muted"><?php echo e($localSponsorship->sponsor_type); ?></div>
                </div>
                <div class="col-md-6">
                    <strong>Local Sponsor Name</strong>
                    <div class="text-muted"><?php echo e($localSponsorship->sponsor_name); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/local-sponsorship/show.blade.php ENDPATH**/ ?>