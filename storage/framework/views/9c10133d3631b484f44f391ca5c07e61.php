

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><?php echo e(__('Add Attendance Record')); ?></h4>
                    <a href="<?php echo e(route('talent-attendance.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> <?php echo e(__('Back to List')); ?>

                    </a>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('talent-attendance.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label"><?php echo e(__('Date')); ?> <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="date" name="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="instructor_name" class="form-label"><?php echo e(__('Instructor Name')); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['instructor_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="instructor_name" name="instructor_name" value="<?php echo e(old('instructor_name')); ?>" required>
                                <?php $__errorArgs = ['instructor_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="attendance_count" class="form-label"><?php echo e(__('Attendance Count')); ?></label>
                                <input type="number" class="form-control bg-light"
                                       id="attendance_count" name="attendance_count" value="<?php echo e(old('attendance_count', 0)); ?>" min="0" readonly>
                                <small class="text-muted">Calculated automatically from participants below.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="talent_taught" class="form-label"><?php echo e(__('Talent Taught')); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['talent_taught'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="talent_taught" name="talent_taught" value="<?php echo e(old('talent_taught')); ?>" required>
                                <?php $__errorArgs = ['talent_taught'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lesson_topic" class="form-label"><?php echo e(__('Lesson Topic')); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['lesson_topic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="lesson_topic" name="lesson_topic" value="<?php echo e(old('lesson_topic')); ?>" required>
                                <?php $__errorArgs = ['lesson_topic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instructor_comments" class="form-label"><?php echo e(__('Instructor Comments')); ?></label>
                                <textarea class="form-control <?php $__errorArgs = ['instructor_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="instructor_comments" name="instructor_comments" rows="3"><?php echo e(old('instructor_comments')); ?></textarea>
                                <?php $__errorArgs = ['instructor_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="supervisor_comments" class="form-label"><?php echo e(__('Supervisor Comments')); ?></label>
                                <textarea class="form-control <?php $__errorArgs = ['supervisor_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          id="supervisor_comments" name="supervisor_comments" rows="3"><?php echo e(old('supervisor_comments')); ?></textarea>
                                <?php $__errorArgs = ['supervisor_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="text-primary mb-1"><?php echo e(__('Participants Attendance')); ?></h5>
                                    <p class="text-muted small mb-0"><?php echo e(__('Add present and absent participants for this session.')); ?></p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-participant">
                                    <i class="fas fa-plus"></i> <?php echo e(__('Add Participant')); ?>

                                </button>
                            </div>

                            <div id="participants-container">
                                <?php
                                    $oldParticipants = old('participants', [
                                        ['participant_name' => '', 'participant_number' => '', 'status' => 'present']
                                    ]);
                                ?>

                                <?php $__currentLoopData = $oldParticipants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row mb-2 participant-row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                   name="participants[<?php echo e($index); ?>][participant_name]"
                                                   placeholder="<?php echo e(__('Participant Name')); ?>"
                                                   value="<?php echo e($participant['participant_name'] ?? ''); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                   name="participants[<?php echo e($index); ?>][participant_number]"
                                                   placeholder="<?php echo e(__('Participant Number')); ?>"
                                                   value="<?php echo e($participant['participant_number'] ?? ''); ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control participant-status"
                                                    name="participants[<?php echo e($index); ?>][status]">
                                                <option value="present" <?php echo e((($participant['status'] ?? '') === 'present') ? 'selected' : ''); ?>>Present</option>
                                                <option value="absent" <?php echo e((($participant['status'] ?? '') === 'absent') ? 'selected' : ''); ?>>Absent</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-participant w-100">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo e(route('talent-attendance.index')); ?>" class="btn btn-secondary me-md-2">
                                <?php echo e(__('Cancel')); ?>

                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?php echo e(__('Save Attendance')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let participantIndex = <?php echo e(old('participants') ? count(old('participants')) : 1); ?>;
    const container = document.getElementById('participants-container');
    const addButton = document.getElementById('add-participant');
    const attendanceCountInput = document.getElementById('attendance_count');

    function updateAttendanceCount() {
        const rows = container.querySelectorAll('.participant-row');
        let count = 0;

        rows.forEach(row => {
            const nameInput = row.querySelector('input[name*="[participant_name]"]');
            if (nameInput && nameInput.value.trim() !== '') {
                count++;
            }
        });

        attendanceCountInput.value = count;
    }

    addButton.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'row mb-2 participant-row';
        row.innerHTML = `
            <div class="col-md-4">
                <input type="text" class="form-control"
                       name="participants[${participantIndex}][participant_name]"
                       placeholder="<?php echo e(__('Participant Name')); ?>">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control"
                       name="participants[${participantIndex}][participant_number]"
                       placeholder="<?php echo e(__('Participant Number')); ?>">
            </div>
            <div class="col-md-3">
                <select class="form-control participant-status"
                        name="participants[${participantIndex}][status]">
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-outline-danger remove-participant w-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        participantIndex++;
        updateAttendanceCount();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-participant') || (e.target.parentElement && e.target.parentElement.classList.contains('remove-participant'))) {
            const row = e.target.closest('.participant-row');
            if (row) {
                const rows = container.querySelectorAll('.participant-row');
                if (rows.length > 1) {
                    row.remove();
                    updateAttendanceCount();
                }
            }
        }
    });

    container.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.includes('[participant_name]')) {
            updateAttendanceCount();
        }
    });

    updateAttendanceCount();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/talent-attendance/create.blade.php ENDPATH**/ ?>