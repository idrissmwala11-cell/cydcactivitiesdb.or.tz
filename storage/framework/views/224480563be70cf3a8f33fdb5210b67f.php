

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark"><?php echo e(__('Talent Attendance Records')); ?></h4>
                        <small class="text-muted"><?php echo e(__('Manage and review all submitted talent attendance sessions.')); ?></small>
                    </div>

                    <a href="<?php echo e(route('talent-attendance.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus me-1"></i> <?php echo e(__('Add Attendance Record')); ?>

                    </a>
                </div>

                <div class="card-body p-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($attendances->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="py-3"><?php echo e(__('Date')); ?></th>
                                        <th class="py-3"><?php echo e(__('Instructor')); ?></th>
                                        <th class="py-3"><?php echo e(__('Talent Taught')); ?></th>
                                        <th class="py-3"><?php echo e(__('Lesson Topic')); ?></th>
                                        <th class="py-3 text-center"><?php echo e(__('Total')); ?></th>
                                        <th class="py-3 text-center"><?php echo e(__('Present')); ?></th>
                                        <th class="py-3 text-center"><?php echo e(__('Absent')); ?></th>
                                        <?php if(auth()->user()->role === 'admin'): ?>
                                            <th class="py-3"><?php echo e(__('Submitted By')); ?></th>
                                        <?php endif; ?>
                                        <th class="py-3 text-center"><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-bottom" style="transition: all 0.2s ease;">
                                            <td>
                                                <span class="badge rounded-pill bg-info-subtle text-dark border px-3 py-2 fw-semibold">
                                                    <?php echo e($attendance->date ? $attendance->date->format('M d, Y') : 'N/A'); ?>

                                                </span>
                                            </td>

                                            <td class="fw-semibold text-dark">
                                                <?php echo e($attendance->instructor_name); ?>

                                            </td>

                                            <td>
                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    <?php echo e($attendance->talent_taught); ?>

                                                </span>
                                            </td>

                                            <td class="text-dark">
                                                <?php echo e(\Illuminate\Support\Str::limit($attendance->lesson_topic, 35)); ?>

                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                                                    <?php echo e($attendance->attendance_count); ?>

                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                                                    <?php echo e($attendance->present_count); ?>

                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">
                                                    <?php echo e($attendance->absent_count); ?>

                                                </span>
                                            </td>

                                            <?php if(auth()->user()->role === 'admin'): ?>
                                                <td class="fw-semibold text-dark">
                                                    <?php echo e($attendance->user->center_id ?? $attendance->user->name ?? 'N/A'); ?>

                                                </td>
                                            <?php endif; ?>

                                            <td class="text-center">
                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                    <a href="<?php echo e(route('talent-attendance.show', $attendance->id)); ?>"
                                                       class="btn btn-sm btn-info text-white fw-semibold px-3 rounded-pill shadow-sm"
                                                       title="View">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>

                                                    <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $attendance->user_id): ?>
                                                        <a href="<?php echo e(route('talent-attendance.edit', $attendance->id)); ?>"
                                                           class="btn btn-sm btn-warning text-dark fw-semibold px-3 rounded-pill shadow-sm"
                                                           title="Edit">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </a>

                                                        <form action="<?php echo e(route('talent-attendance.destroy', $attendance->id)); ?>"
                                                              method="POST"
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-danger text-white fw-semibold px-3 rounded-pill shadow-sm"
                                                                    title="Delete">
                                                                <i class="fas fa-trash me-1"></i> Delete
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($attendances->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-check fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted fw-bold"><?php echo e(__('No attendance records found')); ?></h5>
                            <p class="text-muted"><?php echo e(__('Start by adding your first attendance record.')); ?></p>
                            <a href="<?php echo e(route('talent-attendance.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-plus me-1"></i> <?php echo e(__('Add Attendance Record')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/talent-attendance/index.blade.php ENDPATH**/ ?>