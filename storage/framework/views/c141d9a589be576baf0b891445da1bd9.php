<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h3 class="mb-4">Skills To Learn - Video Clips</h3>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5><?php echo e($video->title); ?></h5>
                        <p><?php echo e($video->description); ?></p>

                        <video class="w-100 rounded" controls>
                            <source src="<?php echo e(asset('storage/' . $video->video_path)); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No videos available right now.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/skill-videos/public.blade.php ENDPATH**/ ?>