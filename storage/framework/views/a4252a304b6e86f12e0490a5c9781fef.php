<?php $__env->startSection('title', 'Add Local Sponsorship'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Local Sponsorship</h2>
            <p class="text-muted mb-0">Register a child under local sponsorship.</p>
        </div>
    </div>

    <form action="<?php echo e(route('local-sponsorship.store')); ?>" method="POST">
        <?php echo $__env->make('local-sponsorship._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/local-sponsorship/create.blade.php ENDPATH**/ ?>