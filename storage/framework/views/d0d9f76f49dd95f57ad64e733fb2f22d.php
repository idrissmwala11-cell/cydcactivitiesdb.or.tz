<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        <?php echo e($section['title']); ?>

                    </h5>
                    <a href="<?php echo e(route($section['route'] . '.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Add New Record
                    </a>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Student / Name</th>
                                    <th>School / Institution</th>
                                    <?php if(Auth::user()->role === 'admin'): ?>
                                        <th>Submitted By</th>
                                    <?php endif; ?>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $data = is_array($record->form_data) ? $record->form_data : (json_decode($record->form_data, true) ?: []);
                                        $studentName = $data['student_name'] ?? $data['institution_name'] ?? $data['contact_person'] ?? 'N/A';
                                        $schoolName = $data['school_name'] ?? $data['university_name'] ?? $data['college_name'] ?? $data['institution_name'] ?? 'N/A';
                                    ?>
                                    <tr>
                                        <td><?php echo e($record->id); ?></td>
                                        <td><?php echo e($studentName); ?></td>
                                        <td><?php echo e($schoolName); ?></td>
                                        <?php if(Auth::user()->role === 'admin'): ?>
                                            <td><?php echo e($record->user->center_id ?? $record->user->email ?? $record->user->name ?? 'Legacy record'); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo e($record->created_at?->format('d M Y')); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route($section['route'] . '.show', $record)); ?>" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if(Auth::user()->role === 'admin' || Auth::id() === (int) $record->user_id): ?>
                                                    <a href="<?php echo e(route($section['route'] . '.edit', $record)); ?>" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="<?php echo e(route($section['route'] . '.destroy', $record)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="<?php echo e(Auth::user()->role === 'admin' ? 6 : 5); ?>" class="text-center py-4">
                                            <i class="bi bi-journal-text text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No <?php echo e(strtolower($section['title'])); ?> records available at the moment.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($records->hasPages()): ?>
                        <div class="mt-4">
                            <?php echo e($records->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/school-info/index.blade.php ENDPATH**/ ?>