<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-book me-2"></i>
                        <?php echo e($section['title']); ?> Details
                    </h5>
                    <div>
                        <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $schoolInformationRecord->user_id): ?>
                            <a href="<?php echo e(route($section['route'] . '.edit', $schoolInformationRecord)); ?>" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route($section['route'] . '.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">RECORD INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $__currentLoopData = ($schoolInformationRecord->form_data ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <strong><?php echo e(ucwords(str_replace(['_', '-'], ' ', $key))); ?>:</strong>
                                        <?php if(is_array($value)): ?>
                                            <pre class="mb-0 mt-1"><?php echo e(json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); ?></pre>
                                        <?php else: ?>
                                            <p class="mb-0"><?php echo e($value ?: 'No information provided'); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">SUBMISSION INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Submitted by:</strong>
                                    <p class="mb-0"><?php echo e($schoolInformationRecord->user->center_id ?? $schoolInformationRecord->user->email ?? $schoolInformationRecord->user->name ?? 'Legacy record'); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Submission date:</strong>
                                    <p class="mb-0"><?php echo e($schoolInformationRecord->created_at?->format('d/m/Y H:i')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-info/show.blade.php ENDPATH**/ ?>