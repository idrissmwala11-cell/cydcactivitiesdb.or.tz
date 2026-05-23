

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <?php
        $periodLabels = [
            'all' => 'All Time',
            'week' => 'Last 1 Week',
            'month' => 'Last 1 Month',
            '3months' => 'Last 3 Months',
            '6months' => 'Last 6 Months',
        ];

        $selectedPeriod = request('period', $period ?? 'all');
        $selectedClassLevel = request('class_level', $selectedClassLevel ?? '');
    ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white">
            <h4 class="mb-0">Center Reports</h4>
        </div>

        <div class="card-body">
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <form method="GET" action="<?php echo e(route('reports.run')); ?>" class="row g-3 align-items-end mb-4">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Select Module</label>
                    <select name="module" id="reportModuleSelect" class="form-select" required>
                        <option value="">-- Select Module --</option>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(request('module') == $key ? 'selected' : ''); ?>>
                                <?php echo e($type['title']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6" id="centerIdFieldWrapper">
                    <label class="form-label">Center ID</label>

                    <?php if($user->role === 'admin'): ?>
                        <input
                            type="text"
                            name="center_id"
                            id="reportCenterIdInput"
                            class="form-control"
                            placeholder="Example: TZ0350"
                            value="<?php echo e(request('center_id')); ?>"
                            <?php echo e(request('module') === 'centers_without_data' ? '' : 'required'); ?>

                        >
                    <?php else: ?>
                        <input
                            type="text"
                            class="form-control bg-light"
                            value="<?php echo e(strtoupper($user->center_id)); ?>"
                            disabled
                        >
                        <input type="hidden" name="center_id" value="<?php echo e(strtoupper($user->center_id)); ?>">
                    <?php endif; ?>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Report Period</label>
                    <select name="period" class="form-select">
                        <option value="all" <?php echo e($selectedPeriod == 'all' ? 'selected' : ''); ?>>All Time</option>
                        <option value="week" <?php echo e($selectedPeriod == 'week' ? 'selected' : ''); ?>>Last 1 Week</option>
                        <option value="month" <?php echo e($selectedPeriod == 'month' ? 'selected' : ''); ?>>Last 1 Month</option>
                        <option value="3months" <?php echo e($selectedPeriod == '3months' ? 'selected' : ''); ?>>Last 3 Months</option>
                        <option value="6months" <?php echo e($selectedPeriod == '6months' ? 'selected' : ''); ?>>Last 6 Months</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6" id="classLevelFieldWrapper" style="display: none;">
                    <label class="form-label">Class Level</label>
                    <select name="class_level" id="reportClassLevelSelect" class="form-select">
                        <option value="">-- Select Class Level --</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Run Report
                    </button>

                    <?php if(isset($records)): ?>
                        <a
                            href="<?php echo e(route('reports.print', [
                                'module' => request('module'),
                                'center_id' => ($isCentersWithoutDataReport ?? false) ? null : ($centerId ?? request('center_id')),
                                'period' => $selectedPeriod,
                                'class_level' => $selectedClassLevel
                            ])); ?>"
                            target="_blank"
                            class="btn btn-success w-100"
                        >
                            Print Report
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if(isset($records)): ?>
                <div class="mb-3">
                    <h5><?php echo e($moduleTitle); ?></h5>
                    <p class="mb-0 text-muted">
                        <?php if(!($isCentersWithoutDataReport ?? false)): ?>
                        Center ID: <strong><?php echo e($centerId); ?></strong> |
                        <?php endif; ?>
                        <?php if($selectedClassLevel): ?>
                        Class Level: <strong><?php echo e($selectedClassLevel); ?></strong> |
                        <?php endif; ?>
                        Period: <strong><?php echo e($periodLabels[$selectedPeriod] ?? 'All Time'); ?></strong> |
                        Total Records: <strong><?php echo e($records->count()); ?></strong>
                    </p>
                </div>

                <div class="table-responsive">
                    <?php if($isCentersWithoutDataReport ?? false): ?>
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Center ID</th>
                                    <th>Total Users</th>
                                    <th>First Registered</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e(strtoupper($record->center_id)); ?></td>
                                        <td><?php echo e($record->total_users); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($record->first_registered_at)->format('d M Y')); ?></td>
                                        <td>No data submitted</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No center IDs found without data.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Submitted By</th>
                                <th>Email</th>
                                <th>Center ID</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($record->user->center_id ?? $record->user->email ?? $record->user->name ?? 'Legacy record'); ?></td>
                                    <td><?php echo e($record->user->email ?? 'N/A'); ?></td>
                                    <td><?php echo e(strtoupper($record->user->center_id ?? 'N/A')); ?></td>
                                    <td><?php echo e($record->status ?? 'N/A'); ?></td>
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
                                    <td colspan="6" class="text-center text-muted">
                                        No records found for this center and selected period.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const moduleSelect = document.getElementById('reportModuleSelect');
    const centerWrapper = document.getElementById('centerIdFieldWrapper');
    const centerInput = document.getElementById('reportCenterIdInput');
    const classLevelWrapper = document.getElementById('classLevelFieldWrapper');
    const classLevelSelect = document.getElementById('reportClassLevelSelect');
    const examClassLevelOptions = <?php echo json_encode($examClassLevelOptions ?? [], 15, 512) ?>;
    const selectedClassLevel = <?php echo json_encode($selectedClassLevel, 15, 512) ?>;

    if (!moduleSelect || !centerWrapper) {
        return;
    }

    function toggleCenterField() {
        const isCentersWithoutData = moduleSelect.value === 'centers_without_data';

        if (isCentersWithoutData) {
            centerWrapper.style.display = 'none';
            if (centerInput) {
                centerInput.removeAttribute('required');
            }
        } else {
            centerWrapper.style.display = '';
            if (centerInput) {
                centerInput.setAttribute('required', 'required');
            }
        }

        const selectedModule = moduleSelect.value;
        const options = examClassLevelOptions[selectedModule] || null;

        if (classLevelWrapper && classLevelSelect) {
            if (options) {
                classLevelWrapper.style.display = '';
                classLevelSelect.innerHTML = '<option value="">-- Select Class Level --</option>';

                options.forEach(function (option) {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;

                    if (option === selectedClassLevel) {
                        optionElement.selected = true;
                    }

                    classLevelSelect.appendChild(optionElement);
                });
            } else {
                classLevelWrapper.style.display = 'none';
                classLevelSelect.innerHTML = '<option value="">-- Select Class Level --</option>';
            }
        }
    }

    moduleSelect.addEventListener('change', toggleCenterField);
    toggleCenterField();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/reports/index.blade.php ENDPATH**/ ?>