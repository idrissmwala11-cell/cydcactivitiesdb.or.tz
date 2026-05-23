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
            <?php echo e(__('Curriculum Studies Records')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Curriculum Studies Records</h3>
                    <a href="<?php echo e(route('submissions.masomo-ya-mtaala.create')); ?>"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Add Record
                    </a>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Instructor</th>
                                <th class="px-4 py-3 text-left">Subject</th>
                                <th class="px-4 py-3 text-left">Lesson Topic</th>
                                <th class="px-4 py-3 text-left">Category</th>
                                <th class="px-4 py-3 text-left">Age Group</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $masomoYaMtaala; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800">
                                        <?php echo e($item->date ? $item->date->format('M d, Y') : 'N/A'); ?>

                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        <?php echo e($item->teacher ?? 'N/A'); ?>

                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        <?php echo e($item->subject_type ?? 'N/A'); ?>

                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        <?php echo e($item->topic ? \Illuminate\Support\Str::limit($item->topic, 40) : 'N/A'); ?>

                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        <?php echo e($item->category_label); ?>

                                    </td>

                                    <td class="px-4 py-3 text-gray-800">
                                        <?php echo e($item->age_group ?? 'N/A'); ?>

                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs
                                            <?php if($item->status === 'draft'): ?>
                                                bg-yellow-100 text-yellow-800
                                            <?php elseif($item->status === 'submitted' || $item->status === 'approved'): ?>
                                                bg-green-100 text-green-700
                                            <?php else: ?>
                                                bg-gray-200 text-gray-700
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst($item->status ?? 'N/A')); ?>

                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <?php if(auth()->user()->role === 'admin'): ?>
                                                <a href="<?php echo e(route('admin.masomo-ya-mtaala.show', $item)); ?>"
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    View
                                                </a>

                                                <a href="<?php echo e(route('admin.masomo-ya-mtaala.edit', $item)); ?>"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>

                                                <form action="<?php echo e(route('admin.masomo-ya-mtaala.destroy', $item)); ?>"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('submissions.masomo-ya-mtaala.show', $item)); ?>"
                                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    View
                                                </a>

                                                <a href="<?php echo e(route('submissions.masomo-ya-mtaala.edit', $item)); ?>"
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </a>

                                                <form action="<?php echo e(route('submissions.masomo-ya-mtaala.destroy', $item)); ?>"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center px-4 py-6 text-gray-500">
                                        No records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <?php echo e($masomoYaMtaala->links()); ?>

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
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/masomo-ya-mtaala/index.blade.php ENDPATH**/ ?>