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
            <?php echo e(__('Skills Information Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Skills Information Record</h3>
                        <div class="flex space-x-2">
                            <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $skillsInformation->user_id): ?>
                                <a href="<?php echo e(route('skills-information.edit', $skillsInformation->id)); ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo e(route('skills-information.index')); ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">Basic Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-600">Date:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->created_at ? $skillsInformation->created_at->format('M d, Y') : 'N/A'); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Student Name:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->student_name); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Gender:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->gender); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Student ID:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->student_id); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">Skill Details</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-600">Skill Category:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->skill_category); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Specific Skills:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->specific_skills ?: 'Not specified'); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Skills Type:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->skills_type ?: 'Not specified'); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Skill Level:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->skill_level); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Submitted by:</span>
                                    <span class="ml-2"><?php echo e($skillsInformation->user->center_id ?? 'No Center ID'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-4">Additional Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if($skillsInformation->mentor): ?>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-blue-800 mb-2">Mentor</h5>
                                    <p class="text-gray-700"><?php echo e($skillsInformation->mentor); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if($skillsInformation->challenges): ?>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-yellow-800 mb-2">Challenges</h5>
                                    <p class="text-gray-700"><?php echo e($skillsInformation->challenges); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if($skillsInformation->support_received): ?>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-green-800 mb-2">Support Received</h5>
                                    <p class="text-gray-700"><?php echo e($skillsInformation->support_received); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if($skillsInformation->comments): ?>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-gray-800 mb-2">Comments</h5>
                                    <p class="text-gray-700"><?php echo e($skillsInformation->comments); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <p>Created: <?php echo e($skillsInformation->created_at ? $skillsInformation->created_at->format('M d, Y H:i') : 'N/A'); ?></p>
                            <?php if($skillsInformation->updated_at && $skillsInformation->created_at && $skillsInformation->updated_at != $skillsInformation->created_at): ?>
                                <p>Last updated: <?php echo e($skillsInformation->updated_at->format('M d, Y H:i')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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
<?php endif; ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/skills-information/show.blade.php ENDPATH**/ ?>