

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><?php echo e(__('Skills Information Records')); ?></h4>
                    <a href="<?php echo e(route('skills-information.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> <?php echo e(__('Add New Record')); ?>

                    </a>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($skillsInformation->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><?php echo e(__('Student Name')); ?></th>
                                        <th><?php echo e(__('Gender')); ?></th>
                                        <th><?php echo e(__('Skill Category')); ?></th>
                                        <th><?php echo e(__('Skill Level')); ?></th>
                                        <?php if(auth()->user()->role === 'admin'): ?>
                                            <th><?php echo e(__('Submitted By')); ?></th>
                                        <?php endif; ?>
                                        <th><?php echo e(__('Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $skillsInformation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($skill->student_name); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($skill->gender === 'Male' ? 'primary' : 'secondary'); ?>">
                                                    <?php echo e($skill->gender); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <?php echo e($skill->skill_category); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo e($skill->skill_level); ?>

                                                </span>
                                            </td>

                                            <?php if(auth()->user()->role === 'admin'): ?>
                                                <td><?php echo e($skill->user->center_id ?? $skill->user->email ?? $skill->user->name ?? 'Legacy record'); ?></td>
                                            <?php endif; ?>

                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('skills-information.show', $skill->id)); ?>" class="btn btn-sm btn-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    <?php if(auth()->user()->role === 'admin' || auth()->id() === (int) $skill->user_id): ?>
                                                        <a href="<?php echo e(route('skills-information.edit', $skill->id)); ?>" class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <form action="<?php echo e(route('skills-information.destroy', $skill->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                                <i class="bi bi-trash"></i>
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

                        <div class="d-flex justify-content-center">
                            <?php echo e($skillsInformation->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-tools display-1 text-muted mb-3"></i>
                            <h5 class="text-muted"><?php echo e(__('No skills information records found')); ?></h5>
                            <p class="text-muted"><?php echo e(__('Start by adding your first skills information record.')); ?></p>
                            <a href="<?php echo e(route('skills-information.create')); ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> <?php echo e(__('Add New Record')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/skills-information/index.blade.php ENDPATH**/ ?>