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
            <?php echo e(__('Curriculum Attendance Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php
        $presentParticipants = $curriculumAttendance->participants->where('status', 'present');
        $absentParticipants = $curriculumAttendance->participants->where('status', 'absent');
    ?>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Date:</label>
                                    <p class="text-gray-900">
                                        <?php echo e($curriculumAttendance->tarehe ? $curriculumAttendance->tarehe->format('d-m-Y') : 'N/A'); ?>

                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Teacher Name:</label>
                                    <p class="text-gray-900"><?php echo e($curriculumAttendance->jina_la_mwalimu); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Lesson Topic:</label>
                                    <p class="text-gray-900"><?php echo e($curriculumAttendance->somo); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Total Participants:</label>
                                    <p class="text-gray-900"><?php echo e($curriculumAttendance->wahudhuria); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Submitted By:</label>
                                    <p class="text-gray-900">
                                        <?php echo e($curriculumAttendance->user->center_id ?? $curriculumAttendance->user->email ?? $curriculumAttendance->user->name ?? 'Legacy record'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Summary</h3>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 text-center">
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <div class="text-2xl font-bold text-blue-600"><?php echo e($curriculumAttendance->wahudhuria); ?></div>
                                        <div class="text-sm text-gray-600">Total</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-green-600"><?php echo e($curriculumAttendance->present_count); ?></div>
                                        <div class="text-sm text-gray-600">Present</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-red-600"><?php echo e($curriculumAttendance->absent_count); ?></div>
                                        <div class="text-sm text-gray-600">Absent</div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <div class="font-semibold text-green-700">Present Count</div>
                                            <div class="mt-1 inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                                <?php echo e($curriculumAttendance->present_count); ?> participants
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-red-700">Absent Count</div>
                                            <div class="mt-1 inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium">
                                                <?php echo e($curriculumAttendance->absent_count); ?> participants
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($curriculumAttendance->mada): ?>
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Lesson Topic Details</h3>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <p class="text-gray-900 whitespace-pre-wrap"><?php echo e($curriculumAttendance->mada); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($curriculumAttendance->maoni_ya_mwalimu || $curriculumAttendance->maoni_ya_msimamizi): ?>
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Comments</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Teacher Comments:</h4>
                                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 min-h-[90px] flex items-center justify-center">
                                        <p class="text-gray-900 whitespace-pre-wrap text-center">
                                            <?php echo e($curriculumAttendance->maoni_ya_mwalimu ?: 'No comments'); ?>

                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Supervisor Comments:</h4>
                                    <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 min-h-[90px] flex items-center justify-center">
                                        <p class="text-gray-900 whitespace-pre-wrap text-center">
                                            <?php echo e($curriculumAttendance->maoni_ya_msimamizi ?: 'No comments'); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($presentParticipants->count() > 0 || $absentParticipants->count() > 0): ?>
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Participants</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold text-green-700 mb-3">✔ Present Participants (<?php echo e($presentParticipants->count()); ?>)</h4>
                                    <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                                        <?php if($presentParticipants->count() > 0): ?>
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden bg-white">
                                                    <thead class="bg-slate-900 text-white">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $presentParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                                    <?php echo e($participant->participant_name); ?>

                                                                </td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                                    <?php echo e($participant->participant_number ?: 'No number provided'); ?>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No present participants recorded.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-red-700 mb-3">✖ Absent Participants (<?php echo e($absentParticipants->count()); ?>)</h4>
                                    <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                                        <?php if($absentParticipants->count() > 0): ?>
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden bg-white">
                                                    <thead class="bg-slate-900 text-white">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $absentParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                                    <?php echo e($participant->participant_name); ?>

                                                                </td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                                    <?php echo e($participant->participant_number ?: 'No number provided'); ?>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No absent participants recorded.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('curriculum-attendance.index')); ?>"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>

                        <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $curriculumAttendance->user_id): ?>
                            <div class="space-x-2">
                                <a href="<?php echo e(route('curriculum-attendance.edit', $curriculumAttendance->id)); ?>"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>

                                <form action="<?php echo e(route('curriculum-attendance.destroy', $curriculumAttendance->id)); ?>"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this curriculum attendance record?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
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
<?php endif; ?>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/curriculum-attendance/show.blade.php ENDPATH**/ ?>