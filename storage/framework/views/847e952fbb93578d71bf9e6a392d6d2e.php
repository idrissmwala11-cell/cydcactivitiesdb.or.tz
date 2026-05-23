<?php echo csrf_field(); ?>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">SCHOOL VISITATION INFORMATION</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="participant_name" class="form-label">1. Participant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['participant_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="participant_name" name="participant_name" value="<?php echo e(old('participant_name', $schoolVisitation->participant_name ?? '')); ?>" required>
                <?php $__errorArgs = ['participant_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="registration_number" class="form-label">2. Registration Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['registration_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="registration_number" name="registration_number" value="<?php echo e(old('registration_number', $schoolVisitation->registration_number ?? '')); ?>" required>
                <?php $__errorArgs = ['registration_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="school_name" class="form-label">3. School Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="school_name" name="school_name" value="<?php echo e(old('school_name', $schoolVisitation->school_name ?? '')); ?>" required>
                <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="class_level" class="form-label">4. Class Level <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['class_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="class_level" name="class_level" value="<?php echo e(old('class_level', $schoolVisitation->class_level ?? '')); ?>" required>
                <?php $__errorArgs = ['class_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="participant_presence" class="form-label">5. Participant Presence <span class="text-danger">*</span></label>
                <select class="form-select <?php $__errorArgs = ['participant_presence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="participant_presence" name="participant_presence" required>
                    <option value="">-- Select --</option>
                    <option value="Present" <?php if(old('participant_presence', $schoolVisitation->participant_presence ?? '') === 'Present'): echo 'selected'; endif; ?>>Present</option>
                    <option value="Absent" <?php if(old('participant_presence', $schoolVisitation->participant_presence ?? '') === 'Absent'): echo 'selected'; endif; ?>>Absent</option>
                </select>
                <?php $__errorArgs = ['participant_presence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="academic_progress" class="form-label">6. Academic Progress <span class="text-danger">*</span></label>
                <select class="form-select <?php $__errorArgs = ['academic_progress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="academic_progress" name="academic_progress" required>
                    <option value="">-- Select --</option>
                    <option value="Satisfactory" <?php if(old('academic_progress', $schoolVisitation->academic_progress ?? '') === 'Satisfactory'): echo 'selected'; endif; ?>>Satisfactory</option>
                    <option value="Unsatisfactory" <?php if(old('academic_progress', $schoolVisitation->academic_progress ?? '') === 'Unsatisfactory'): echo 'selected'; endif; ?>>Unsatisfactory</option>
                </select>
                <?php $__errorArgs = ['academic_progress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-12">
                <label for="academic_challenges" class="form-label">7. If unsatisfactory, what are the challenges?</label>
                <textarea class="form-control <?php $__errorArgs = ['academic_challenges'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="academic_challenges" name="academic_challenges" rows="3"><?php echo e(old('academic_challenges', $schoolVisitation->academic_challenges ?? '')); ?></textarea>
                <?php $__errorArgs = ['academic_challenges'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="discipline_status" class="form-label">8. Discipline Status <span class="text-danger">*</span></label>
                <select class="form-select <?php $__errorArgs = ['discipline_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="discipline_status" name="discipline_status" required>
                    <option value="">-- Select --</option>
                    <option value="Good" <?php if(old('discipline_status', $schoolVisitation->discipline_status ?? '') === 'Good'): echo 'selected'; endif; ?>>Good</option>
                    <option value="Average" <?php if(old('discipline_status', $schoolVisitation->discipline_status ?? '') === 'Average'): echo 'selected'; endif; ?>>Average</option>
                    <option value="Poor" <?php if(old('discipline_status', $schoolVisitation->discipline_status ?? '') === 'Poor'): echo 'selected'; endif; ?>>Poor</option>
                </select>
                <?php $__errorArgs = ['discipline_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label for="cleanliness_status" class="form-label">9. Cleanliness Status <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['cleanliness_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cleanliness_status" name="cleanliness_status" value="<?php echo e(old('cleanliness_status', $schoolVisitation->cleanliness_status ?? '')); ?>" placeholder="Example: Clean, Average, Unsatisfactory" required>
                <?php $__errorArgs = ['cleanliness_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-12">
                <label for="bad_behaviors" class="form-label">10. If discipline is poor, what bad behavior does the participant have?</label>
                <textarea class="form-control <?php $__errorArgs = ['bad_behaviors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="bad_behaviors" name="bad_behaviors" rows="3"><?php echo e(old('bad_behaviors', $schoolVisitation->bad_behaviors ?? '')); ?></textarea>
                <?php $__errorArgs = ['bad_behaviors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-12">
                <label for="teacher_comments" class="form-label">11. Teacher Comments</label>
                <textarea class="form-control <?php $__errorArgs = ['teacher_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="teacher_comments" name="teacher_comments" rows="3"><?php echo e(old('teacher_comments', $schoolVisitation->teacher_comments ?? '')); ?></textarea>
                <?php $__errorArgs = ['teacher_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-12">
                <label for="visitor_comments" class="form-label">12. Visitor Comments</label>
                <textarea class="form-control <?php $__errorArgs = ['visitor_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="visitor_comments" name="visitor_comments" rows="4"><?php echo e(old('visitor_comments', $schoolVisitation->visitor_comments ?? '')); ?></textarea>
                <?php $__errorArgs = ['visitor_comments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="<?php echo e(route('school-visitation.index')); ?>" class="btn btn-secondary me-md-2">
        <i class="bi bi-x-circle me-1"></i> Cancel
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> Save
    </button>
</div>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-visitation/_form.blade.php ENDPATH**/ ?>