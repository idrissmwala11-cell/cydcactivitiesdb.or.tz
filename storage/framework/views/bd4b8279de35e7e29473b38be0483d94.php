<?php $__env->startSection('title', 'Skills Attendance'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1 fw-bold text-dark">
                        <i class="bi bi-calendar2-check text-success me-2"></i>
                        Skills Attendance Records
                    </h3>
                    <p class="text-muted mb-0">Track class attendance, teachers, and submitted records clearly.</p>
                </div>

                <a href="<?php echo e(route('skills-attendance.create')); ?>" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-1"></i>Add New Record
                </a>
            </div>
        </div>

        <div class="card-body px-4 pb-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-3">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-3">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Total Records</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(number_format($attendances->total())); ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Visible On This Page</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(number_format($attendances->count())); ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-info bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Unique Teachers On This Page</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(number_format($attendances->pluck('teacher_name')->filter()->unique()->count())); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Teacher</th>
                            <th>Lesson Topic</th>
                            <th>Present Count</th>
                            <th>Absent Count</th>
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <th>Submitted By</th>
                            <?php endif; ?>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $submittedBy = $attendance->user->center_id
                                    ?? $attendance->user->email
                                    ?? $attendance->user->name
                                    ?? null;
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        <?php echo e($attendance->date ? $attendance->date->format('M d, Y') : 'N/A'); ?>

                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark"><?php echo e($attendance->teacher_name); ?></div>
                                </td>

                                <td style="min-width: 240px;">
                                    <div class="text-dark fw-medium"><?php echo e($attendance->lesson_topic); ?></div>
                                    <?php if(!empty($attendance->lesson_topic_details)): ?>
                                        <small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($attendance->lesson_topic_details, 70)); ?></small>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        <?php echo e($attendance->present_count); ?>

                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                        <?php echo e($attendance->absentParticipants->count()); ?>

                                    </span>
                                </td>

                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <td>
                                        <?php if($submittedBy): ?>
                                            <div class="fw-semibold text-dark"><?php echo e($submittedBy); ?></div>
                                            <?php if($attendance->user?->email && $attendance->user?->center_id): ?>
                                                <small class="text-muted"><?php echo e($attendance->user->email); ?></small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning">Legacy record</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?php echo e(route('skills-attendance.show', $attendance->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                        <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $attendance->user_id): ?>
                                            <a href="<?php echo e(route('skills-attendance.edit', $attendance->id)); ?>" class="btn btn-sm btn-outline-warning">
                                                Edit
                                            </a>

                                            <form action="<?php echo e(route('skills-attendance.destroy', $attendance->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                                    Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(auth()->user()->role === 'admin' ? 7 : 6); ?>" class="text-center py-5 text-muted">
                                    No skills attendance records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <?php echo e($attendances->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/skills-attendance/index.blade.php ENDPATH**/ ?>