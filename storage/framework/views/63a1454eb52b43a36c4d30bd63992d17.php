<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-building-check me-2"></i>
                        SCHOOL VISITATION FORM
                    </h5>
                    <a href="<?php echo e(route('school-visitation.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('school-visitation.store')); ?>" method="POST">
                        <?php echo $__env->make('school-visitation._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-visitation/create.blade.php ENDPATH**/ ?>