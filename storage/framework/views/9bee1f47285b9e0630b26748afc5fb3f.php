<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit <?php echo e($section['title']); ?>

                    </h5>
                    <a href="<?php echo e(route($section['route'] . '.show', $schoolInformationRecord)); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route($section['route'] . '.update', $schoolInformationRecord)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-3">
                            <?php $__currentLoopData = ($schoolInformationRecord->form_data ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $raw = old("form_data.$key", is_array($value) ? json_encode($value) : $value);
                                    $isNumeric = is_numeric($raw);
                                    $isLong = is_string($raw) && strlen($raw) > 120;
                                ?>

                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(ucwords(str_replace(['_', '-'], ' ', $key))); ?></label>
                                    <?php if(is_array($value) || $isLong): ?>
                                        <textarea name="form_data[<?php echo e($key); ?>]" rows="4" class="form-control"><?php echo e($raw); ?></textarea>
                                    <?php elseif($isNumeric): ?>
                                        <input type="number" step="any" name="form_data[<?php echo e($key); ?>]" value="<?php echo e($raw); ?>" class="form-control">
                                    <?php else: ?>
                                        <input type="text" name="form_data[<?php echo e($key); ?>]" value="<?php echo e($raw); ?>" class="form-control">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo e(route($section['route'] . '.show', $schoolInformationRecord)); ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-info/edit.blade.php ENDPATH**/ ?>