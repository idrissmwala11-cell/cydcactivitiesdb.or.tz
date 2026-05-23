<?php echo csrf_field(); ?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">LOCAL SPONSORSHIP REGISTRATION</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="child_name" class="form-label">1. Child's Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['child_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="child_name" name="child_name" value="<?php echo e(old('child_name', $localSponsorship->child_name ?? '')); ?>" required>
                <?php $__errorArgs = ['child_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6">
                <label for="child_age" class="form-label">2. Child's Age <span class="text-danger">*</span></label>
                <input type="number" class="form-control <?php $__errorArgs = ['child_age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="child_age" name="child_age" value="<?php echo e(old('child_age', $localSponsorship->child_age ?? '')); ?>" min="0" required>
                <?php $__errorArgs = ['child_age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6">
                <label for="child_location" class="form-label">3. Location Where the Child is Found <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['child_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="child_location" name="child_location" value="<?php echo e(old('child_location', $localSponsorship->child_location ?? '')); ?>" required>
                <?php $__errorArgs = ['child_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6">
                <label for="local_number" class="form-label">4. Child's Local Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['local_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="local_number" name="local_number" value="<?php echo e(old('local_number', $localSponsorship->local_number ?? '')); ?>" required>
                <?php $__errorArgs = ['local_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6">
                <label for="sponsor_type" class="form-label">5. Local Sponsor Type <span class="text-danger">*</span></label>
                <select class="form-select <?php $__errorArgs = ['sponsor_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sponsor_type" name="sponsor_type" required>
                    <option value="">-- Select sponsor type --</option>
                    <option value="Church" <?php if(old('sponsor_type', $localSponsorship->sponsor_type ?? '') === 'Church'): echo 'selected'; endif; ?>>Church</option>
                    <option value="Group" <?php if(old('sponsor_type', $localSponsorship->sponsor_type ?? '') === 'Group'): echo 'selected'; endif; ?>>Group</option>
                    <option value="Individual" <?php if(old('sponsor_type', $localSponsorship->sponsor_type ?? '') === 'Individual'): echo 'selected'; endif; ?>>Individual</option>
                </select>
                <?php $__errorArgs = ['sponsor_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6">
                <label for="sponsor_name" class="form-label">6. Name of the Local Sponsor <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?php $__errorArgs = ['sponsor_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sponsor_name" name="sponsor_name" value="<?php echo e(old('sponsor_name', $localSponsorship->sponsor_name ?? '')); ?>" required>
                <?php $__errorArgs = ['sponsor_name'];
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

<div class="d-flex justify-content-end gap-2">
    <a href="<?php echo e(route('local-sponsorship.index')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Back
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> Save Record
    </button>
</div>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/local-sponsorship/_form.blade.php ENDPATH**/ ?>