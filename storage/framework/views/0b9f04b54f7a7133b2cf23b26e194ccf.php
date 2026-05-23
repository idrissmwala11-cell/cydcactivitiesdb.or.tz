<?php $__env->startSection('title', 'Center Profile'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $summaryFields = $selectedModuleConfig['fields'] ?? [];

    $extractRecordData = function ($record) {
        if (isset($record->form_data) && !empty($record->form_data)) {
            return is_array($record->form_data) ? $record->form_data : (json_decode($record->form_data, true) ?: []);
        }

        return collect($record->getAttributes())
            ->except(['id', 'user_id', 'created_at', 'updated_at'])
            ->toArray();
    };

    $previewKeys = collect(array_keys($summaryFields))->take(4)->all();
?>

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #0f172a, #2563eb); color: #fff;">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-4">
                <div>
                    <span class="badge bg-light text-primary fw-semibold mb-3 px-3 py-2">Center Profile</span>
                    <h2 class="fw-bold mb-2"><?php echo e($centerId); ?></h2>
                    <p class="mb-1 text-white-50">Profile ya kituo ikitumia records za users wote wenye Center ID hii.</p>
                    <p class="mb-0 text-white-50">Imefunguliwa kupitia user: <?php echo e($selectedUser->email); ?></p>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-outline-light">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i>Open Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">Users in this center</p>
                    <h3 class="fw-bold mb-3"><?php echo e($centerUsers->count()); ?></h3>
                    <div class="d-flex flex-wrap gap-2">
                        <?php $__currentLoopData = $centerUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centerUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge rounded-pill text-bg-light border">
                                <?php echo e($centerUser->center_id ?: $centerUser->email); ?> | <?php echo e(ucfirst($centerUser->role)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">Total records</p>
                    <h3 class="fw-bold mb-2"><?php echo e(number_format($totalCenterRecords)); ?></h3>
                    <p class="mb-0 text-muted">Records zote za category zilizo chini ya center hii kwa kipindi ulichochagua.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">Selected category</p>
                    <h3 class="fw-bold mb-2"><?php echo e($selectedModuleConfig['title']); ?></h3>
                    <p class="mb-0 text-muted">
                        Count:
                        <strong><?php echo e(number_format($moduleCounts[$selectedModule] ?? 0)); ?></strong>
                        | Period:
                        <strong><?php echo e($periodLabels[$period] ?? 'All Time'); ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="<?php echo e(route('admin.users.center-profile', $selectedUser)); ?>" class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-semibold">Choose Data Category</label>
                    <select name="module" class="form-select">
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleKey => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($moduleKey); ?>" <?php echo e($selectedModule === $moduleKey ? 'selected' : ''); ?>>
                                <?php echo e($module['title']); ?> (<?php echo e($moduleCounts[$moduleKey] ?? 0); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Period</label>
                    <select name="period" class="form-select">
                        <?php $__currentLoopData = $periodLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodKey => $periodLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($periodKey); ?>" <?php echo e($period === $periodKey ? 'selected' : ''); ?>>
                                <?php echo e($periodLabel); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-lg-4 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-funnel-fill me-2"></i>Load Center Data
                    </button>
                    <a href="<?php echo e(route('reports.run', ['module' => $selectedModule, 'center_id' => $centerId, 'period' => $period])); ?>" class="btn btn-success flex-grow-1">
                        <i class="bi bi-play-fill me-2"></i>Run Report
                    </a>
                    <a href="<?php echo e(route('reports.print', ['module' => $selectedModule, 'center_id' => $centerId, 'period' => $period])); ?>" target="_blank" class="btn btn-outline-dark flex-grow-1">
                        <i class="bi bi-printer me-2"></i>Print
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleKey => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="<?php echo e(route('admin.users.center-profile', ['user' => $selectedUser->id, 'module' => $moduleKey, 'period' => $period])); ?>"
                   class="card border-0 shadow-sm rounded-4 h-100 text-decoration-none <?php echo e($selectedModule === $moduleKey ? 'border border-primary border-2' : ''); ?>">
                    <div class="card-body">
                        <p class="small text-uppercase fw-semibold text-muted mb-2">Category</p>
                        <h6 class="text-dark fw-bold mb-3"><?php echo e($module['title']); ?></h6>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Total</span>
                            <span class="badge rounded-pill <?php echo e($selectedModule === $moduleKey ? 'text-bg-primary' : 'text-bg-light'); ?>">
                                <?php echo e(number_format($moduleCounts[$moduleKey] ?? 0)); ?>

                            </span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="mb-1"><?php echo e($selectedModuleConfig['title']); ?></h4>
                <p class="mb-0 text-muted">Data za kituo hiki katika category uliyochagua.</p>
            </div>
            <span class="badge text-bg-primary px-3 py-2"><?php echo e($records->total()); ?> records</span>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Submitted By</th>
                            <?php $__currentLoopData = $previewKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $previewKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($summaryFields[$previewKey] ?? \Illuminate\Support\Str::headline(str_replace('_', ' ', $previewKey))); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $recordData = $extractRecordData($record);
                            ?>
                            <tr>
                                <td><?php echo e($records->firstItem() + $index); ?></td>
                                <td>
                                    <div class="fw-semibold"><?php echo e($record->user->center_id ?? $record->user->email ?? 'N/A'); ?></div>
                                    <small class="text-muted"><?php echo e($record->user->email ?? 'No email'); ?></small>
                                </td>
                                <?php $__currentLoopData = $previewKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $previewKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td><?php echo e($recordData[$previewKey] ?? 'N/A'); ?></td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <?php if(!empty($record->date)): ?>
                                        <?php echo e(\Carbon\Carbon::parse($record->date)->format('d M Y')); ?>

                                    <?php elseif(!empty($record->submitted_at)): ?>
                                        <?php echo e(\Carbon\Carbon::parse($record->submitted_at)->format('d M Y H:i')); ?>

                                    <?php elseif(!empty($record->created_at)): ?>
                                        <?php echo e($record->created_at->format('d M Y H:i')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(4 + count($previewKeys)); ?>" class="text-center py-5 text-muted">
                                    No <?php echo e(strtolower($selectedModuleConfig['title'])); ?> records were found for this center in the selected period.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($records->hasPages()): ?>
                <div class="pt-3">
                    <?php echo e($records->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/admin/center-profile.blade.php ENDPATH**/ ?>