<?php $__env->startSection('title', 'Add New Curriculum Record'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-blue-700">
                    Curriculum Studies
                </span>
                <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">Curriculum Studies Form</h1>
                <p class="mt-2 max-w-2xl text-sm text-gray-600">
                    Fill in the teacher, lesson, category, and feedback details below to save a complete curriculum record.
                </p>
            </div>

            <a href="<?php echo e(route('submissions.masomo-ya-mtaala.index')); ?>"
               class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:bg-gray-50">
                Back to Records
            </a>
        </div>

        <?php if($errors->any()): ?>
            <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
                <p class="mb-2 font-semibold">Please fix the following issues:</p>
                <ul class="list-disc space-y-1 pl-5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('submissions.masomo-ya-mtaala.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="overflow-hidden rounded-[2rem] border border-blue-100 bg-white shadow-[0_24px_60px_-32px_rgba(37,99,235,0.35)]">
                <div class="border-b border-blue-100 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-6 py-6 text-white">
                    <h2 class="text-xl font-semibold">Lesson Information</h2>
                    <p class="mt-1 text-sm text-blue-100">Enter the core classroom details for this curriculum session.</p>
                </div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="md:col-span-1">
                            <label for="date" class="mb-2 block text-sm font-semibold text-gray-700">1. Date</label>
                            <input
                                type="date"
                                name="date"
                                id="date"
                                value="<?php echo e(old('date', date('Y-m-d'))); ?>"
                                required
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                            >
                        </div>

                        <div class="md:col-span-1">
                            <label for="jina_la_mwalimu" class="mb-2 block text-sm font-semibold text-gray-700">2. Teacher Name</label>
                            <input
                                type="text"
                                name="jina_la_mwalimu"
                                id="jina_la_mwalimu"
                                value="<?php echo e(old('jina_la_mwalimu')); ?>"
                                required
                                placeholder="Enter teacher name"
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                            >
                        </div>

                        <div>
                            <label for="somo_analofundisha" class="mb-2 block text-sm font-semibold text-gray-700">3. Subject Taught</label>
                            <input
                                type="text"
                                name="somo_analofundisha"
                                id="somo_analofundisha"
                                value="<?php echo e(old('somo_analofundisha')); ?>"
                                required
                                placeholder="Example: Mathematics"
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                            >
                        </div>

                        <div>
                            <label for="darasa_la_mjaka_mingapi" class="mb-2 block text-sm font-semibold text-gray-700">5. Age Group Taught</label>
                            <select
                                name="darasa_la_mjaka_mingapi"
                                id="darasa_la_mjaka_mingapi"
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                            >
                                <option value="">Select age group...</option>
                                <?php $__currentLoopData = ['3-5 years', '6-8 years', '9-11 years', '12-14 years', '15-17 years', '18+ years']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ageGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ageGroup); ?>" <?php echo e(old('darasa_la_mjaka_mingapi') === $ageGroup ? 'selected' : ''); ?>>
                                        <?php echo e($ageGroup); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="mada_aliyo_fundisha" class="mb-2 block text-sm font-semibold text-gray-700">6. Lesson Topic</label>
                            <input
                                type="text"
                                name="mada_aliyo_fundisha"
                                id="mada_aliyo_fundisha"
                                value="<?php echo e(old('mada_aliyo_fundisha')); ?>"
                                placeholder="Enter the topic covered in class"
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-emerald-100 bg-white shadow-[0_24px_60px_-32px_rgba(16,185,129,0.28)]">
                <div class="border-b border-emerald-100 bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-6 text-white">
                    <h2 class="text-xl font-semibold">4. Choose Lesson Category</h2>
                    <p class="mt-1 text-sm text-emerald-100">Select the main area this lesson belongs to.</p>
                </div>

                <div class="p-6 md:p-8">
                    <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-5">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <?php $__currentLoopData = [
                                'kiroho' => 'Spiritual',
                                'kimwili' => 'Physical',
                                'kiakili' => 'Mental',
                                'kijamii' => 'Social',
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label for="category_<?php echo e($value); ?>" class="flex cursor-pointer items-center gap-3 rounded-2xl border border-white bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50">
                                    <input
                                        type="radio"
                                        name="category"
                                        value="<?php echo e($value); ?>"
                                        id="category_<?php echo e($value); ?>"
                                        <?php echo e(old('category') === $value ? 'checked' : ''); ?>

                                        class="h-4 w-4 border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                        required
                                    >
                                    <span><?php echo e($label); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-amber-100 bg-white shadow-[0_24px_60px_-32px_rgba(245,158,11,0.28)]">
                <div class="border-b border-amber-100 bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-6 text-white">
                    <h2 class="text-xl font-semibold">Feedback and Notes</h2>
                    <p class="mt-1 text-sm text-amber-100">Capture observations from both the learner and the teacher.</p>
                </div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="maoni_ya_mwanafunzi" class="mb-2 block text-sm font-semibold text-gray-700">7. Student Comments</label>
                            <textarea
                                name="maoni_ya_mwanafunzi"
                                id="maoni_ya_mwanafunzi"
                                rows="5"
                                placeholder="Write student comments here"
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100"
                            ><?php echo e(old('maoni_ya_mwanafunzi')); ?></textarea>
                        </div>

                        <div>
                            <label for="maoni_ya_mwalimu" class="mb-2 block text-sm font-semibold text-gray-700">8. Teacher Comments</label>
                            <textarea
                                name="maoni_ya_mwalimu"
                                id="maoni_ya_mwalimu"
                                rows="5"
                                placeholder="Write teacher comments here"
                                class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100"
                            ><?php echo e(old('maoni_ya_mwalimu')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow-sm">
                <div class="p-6 md:flex md:items-end md:justify-between md:gap-6">
                    <div class="md:w-72">
                        <label for="action" class="mb-2 block text-sm font-semibold text-gray-700">Save Option</label>
                        <select
                            name="action"
                            id="action"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="draft" <?php echo e(old('action') === 'draft' ? 'selected' : ''); ?>>Save as Draft</option>
                            <option value="submit" <?php echo e(old('action') === 'submit' ? 'selected' : ''); ?>>Submit Record</option>
                        </select>
                    </div>

                    <div class="mt-5 flex flex-col gap-3 sm:flex-row md:mt-0">
                        <a href="<?php echo e(route('submissions.masomo-ya-mtaala.index')); ?>"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:-translate-y-0.5 hover:bg-blue-700"
                        >
                            Save Record
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/masomo-ya-mtaala/create.blade.php ENDPATH**/ ?>