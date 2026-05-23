<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-journal-richtext me-2"></i><?php echo e(__('School Information: Secondary')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="alert alert-success mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-bottom" style="background: linear-gradient(135deg, #4f46e5, #2563eb); color: #fff;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h3 class="h5 mb-1"><i class="bi bi-building-check me-2"></i>Secondary School Information</h3>
                            <p class="mb-0" style="color: rgba(255,255,255,.9);">Fill in the student's secondary school information in a clean, simple format.</p>
                        </div>
                        <span class="badge bg-light text-primary px-3 py-2">Secondary Form</span>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route($sectionRoute . '.store')); ?>" class="p-4 p-md-5">
                    <?php echo csrf_field(); ?>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-person me-2 text-primary"></i>Student Name</label>
                            <input type="text" name="form_data[student_name]" class="form-control form-control-lg" value="<?php echo e(old('form_data.student_name')); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-2 text-primary"></i>School Name</label>
                            <input type="text" name="form_data[school_name]" class="form-control form-control-lg" value="<?php echo e(old('form_data.school_name')); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-journal-bookmark me-2 text-primary"></i>Current Class</label>
                            <input type="text" name="form_data[class_level]" class="form-control form-control-lg" value="<?php echo e(old('form_data.class_level')); ?>" placeholder="Example: Form 1, Form 2" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-2 text-primary"></i>Graduation Year</label>
                            <input type="number" name="form_data[graduation_year]" min="2000" max="2100" class="form-control form-control-lg" value="<?php echo e(old('form_data.graduation_year')); ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Overall Performance</label>
                            <div class="row g-3">
                                <?php $__currentLoopData = ['Excellent', 'Good', 'Average', 'Poor']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $performance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-6 col-lg-3">
                                        <label class="w-100 border rounded-3 px-3 py-3 d-flex align-items-center gap-2" style="cursor: pointer; background: #f8fafc;">
                                            <input type="radio" name="form_data[performance]" value="<?php echo e($performance); ?>" class="form-check-input mt-0" <?php echo e(old('form_data.performance') == $performance ? 'checked' : ''); ?>>
                                            <span class="fw-semibold"><?php echo e($performance); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-award me-2 text-primary"></i>Best Subjects</label>
                            <input type="text" name="form_data[best_subjects]" class="form-control form-control-lg" value="<?php echo e(old('form_data.best_subjects')); ?>" placeholder="Example: Biology, English">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-x-octagon me-2 text-primary"></i>Subjects with Challenges</label>
                            <input type="text" name="form_data[failed_subjects]" class="form-control form-control-lg" value="<?php echo e(old('form_data.failed_subjects')); ?>" placeholder="Example: Physics, Chemistry">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-lightbulb me-2 text-primary"></i>Child's Dream</label>
                            <input type="text" name="form_data[child_dream]" class="form-control form-control-lg" value="<?php echo e(old('form_data.child_dream')); ?>" placeholder="Example: Engineer">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-chat-left-dots me-2 text-primary"></i>Comments</label>
                            <textarea name="form_data[general_comments]" class="form-control form-control-lg" rows="5"><?php echo e(old('form_data.general_comments')); ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4 pt-4 border-top">
                        <a href="<?php echo e(route($sectionRoute . '.index')); ?>" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                        <button type="submit" name="action" value="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-send-check me-2"></i>Submit Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-info/secondary.blade.php ENDPATH**/ ?>