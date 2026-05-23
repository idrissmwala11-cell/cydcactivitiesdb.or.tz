<form method="POST" action="<?php echo e(route('profile.destroy')); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">
            Confirm Password to Delete Account
        </label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
        Delete Account
    </button>
</form>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>