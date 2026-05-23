<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($moduleTitle ?? 'Report'); ?> Print</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #1f2937;
            margin: 0;
            background: #f3f4f6;
            padding: 28px;
        }

        .page-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #ffffff;
            border-radius: 18px;
            padding: 28px 30px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.18);
            margin-bottom: 22px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .page-header p {
            margin: 8px 0 0;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.92);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
            border: 1px solid #e5e7eb;
        }

        .summary-label {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .summary-value {
            font-size: 22px;
            font-weight: 800;
            color: #111827;
        }

        .record-card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #dbe2ea;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
            margin-bottom: 28px;
            page-break-inside: avoid;
        }

        .record-header {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            color: #ffffff;
            padding: 18px 22px;
            font-size: 24px;
            font-weight: 800;
        }

        .record-subheader {
            background: #eff6ff;
            border-bottom: 1px solid #dbeafe;
            padding: 14px 22px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px 24px;
            color: #1f2937;
            font-size: 14px;
        }

        .record-subheader-item strong {
            color: #0f172a;
        }

        .section {
            margin: 22px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .section-title {
            padding: 14px 18px;
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.01em;
        }

        .section-blue {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .section-green {
            background: linear-gradient(135deg, #059669, #047857);
        }

        .section-purple {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
        }

        .section-orange {
            background: linear-gradient(135deg, #ea580c, #c2410c);
        }

        .section-gray {
            background: linear-gradient(135deg, #475569, #334155);
        }

        .fields-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            background: #ffffff;
        }

        .field-item {
            padding: 18px 18px 16px;
            border-bottom: 1px solid #edf2f7;
            min-height: 92px;
        }

        .field-item:nth-child(odd) {
            border-right: 1px solid #edf2f7;
        }

        .field-label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 8px;
        }

        .field-value {
            font-size: 15px;
            line-height: 1.7;
            color: #374151;
            word-break: break-word;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .badge-success {
            background: #16a34a;
        }

        .badge-danger {
            background: #dc2626;
        }

        .badge-warning {
            background: #d97706;
        }

        .badge-secondary {
            background: #6b7280;
        }

        .empty-state {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 40px 24px;
            text-align: center;
            color: #6b7280;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 12px;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
                margin: 10mm;
            }

            .page-header {
                box-shadow: none;
            }

            .summary-card,
            .record-card {
                box-shadow: none;
            }

            .record-card,
            .section {
                page-break-inside: avoid;
            }

            .page-header,
            .summary-card,
            .record-card {
                break-inside: avoid;
            }
        }

        @media (max-width: 900px) {
            .summary-grid,
            .fields-grid {
                grid-template-columns: 1fr;
            }

            .field-item:nth-child(odd) {
                border-right: none;
            }

            .page-header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <?php
        use Illuminate\Support\Str;
        use Carbon\Carbon;

        $periodLabels = [
            'all' => 'All Time',
            'week' => 'Last 1 Week',
            'month' => 'Last 1 Month',
            '3months' => 'Last 3 Months',
            '6months' => 'Last 6 Months',
        ];

        $labelMap = [
            'student_name' => 'Child / Student Name',
            'school_name' => 'School / Institution Name',
            'class_level' => 'Darasa / Ngazi',
            'graduation_year' => 'Mwaka wa Kuhitimu',
            'performance' => 'Ufaulu wa Jumla',
            'best_subjects' => 'Masomo Anayofanya Vizuri',
            'failed_subjects' => 'Subjects with Challenges',
            'child_dream' => 'Ndoto ya Mtoto',
            'general_comments' => 'Comments',
            'exam_type' => 'Aina ya Mtihani',
            'exam_year' => 'Mwaka wa Mtihani',
            'gpa' => 'GPA',
            'comments' => 'Additional Comments',
            'participant_name' => 'Participant Name',
            'registration_number' => 'Registration Number',
            'participant_presence' => 'Participant Presence',
            'academic_progress' => 'Maendeleo ya Kitaaluma',
            'academic_challenges' => 'Academic Challenges',
            'discipline_status' => 'Nidhamu',
            'bad_behaviors' => 'Tabia Mbaya',
            'cleanliness_status' => 'Hali ya Usafi',
            'teacher_comments' => 'Teacher Comments',
            'visitor_comments' => 'Visitor Comments',
            'jina' => 'Participant Name',
            'namba' => 'Participant Number',
            'shule' => 'School Name',
            'darasa' => 'Darasa Analosoma',
            'last_program' => 'Mara ya Mwisho Kuhudhuria Program',
            'likes_program' => 'Je bado anaipenda program?',
            'participant_comments' => 'Participant Comments',
            'mtaa' => 'Mahali Anakoishi / Mtaa',
            'mazingira' => 'Mazingira Anayoishi',
            'nyumba' => 'Nyumba ni Yao',
            'paa' => 'Aina ya Paa',
            'choo' => 'Wanachoo au Hawana Choo',
            'meals_per_day' => 'Idadi ya Milo kwa Siku',
            'malezi' => 'Participant Care',
            'wazazi_hai' => 'Wazazi Wote Wapo Hai?',
            'anaishi_na' => 'Anaishi na Nani',
            'msaada' => 'Msaada Anaoupata',
            'changamoto' => 'Challenges',
            'mapendekezo' => 'Mapendekezo',
            'date' => 'Date',
            'status' => 'Status',
            'submitted_at' => 'Submitted At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];

        $excludedFields = [
            'id',
            'user_id',
            'center_id',
        ];

        function formatFieldLabel($key, $labelMap) {
            return $labelMap[$key] ?? Str::headline(str_replace('_', ' ', $key));
        }

        function formatFieldValue($key, $value) {
            if ($value === null || $value === '') {
                return 'N/A';
            }

            if (is_bool($value)) {
                return $value ? 'Yes' : 'No';
            }

            $lower = strtolower((string) $value);

            if (in_array($lower, ['1', 'yes', 'ndio', 'true'])) {
                return '<span class="badge badge-success">Yes</span>';
            }

            if (in_array($lower, ['0', 'no', 'hapana', 'false'])) {
                return '<span class="badge badge-danger">No</span>';
            }

            if ($key === 'status') {
                if ($lower === 'approved') {
                    return '<span class="badge badge-success">Approved</span>';
                }
                if ($lower === 'pending') {
                    return '<span class="badge badge-warning">Pending</span>';
                }
                if ($lower === 'rejected') {
                    return '<span class="badge badge-danger">Rejected</span>';
                }

                return '<span class="badge badge-secondary">' . e($value) . '</span>';
            }

            if (in_array($key, ['date', 'submitted_at', 'created_at', 'updated_at'])) {
                try {
                    return Carbon::parse($value)->format('d M Y H:i');
                } catch (\Throwable $e) {
                    return e($value);
                }
            }

            return nl2br(e($value));
        }

        function getSectionClass($title) {
            return match ($title) {
                'Participant Information' => 'section-blue',
                'Housing Information' => 'section-green',
                'Malezi / Familia' => 'section-purple',
                'Challenges / Recommendations' => 'section-orange',
                default => 'section-gray',
            };
        }

        function groupFields($attributes) {
            $groups = [
                'Participant Information' => [],
                'Housing Information' => [],
                'Malezi / Familia' => [],
                'Challenges / Recommendations' => [],
                'Other Details' => [],
            ];

            foreach ($attributes as $key => $value) {
                if (in_array($key, ['jina', 'namba', 'shule', 'darasa', 'last_program', 'likes_program', 'participant_comments'])) {
                    $groups['Participant Information'][$key] = $value;
                } elseif (in_array($key, ['mtaa', 'mazingira', 'nyumba', 'paa', 'choo', 'meals_per_day'])) {
                    $groups['Housing Information'][$key] = $value;
                } elseif (in_array($key, ['malezi', 'wazazi_hai', 'anaishi_na', 'msaada'])) {
                    $groups['Malezi / Familia'][$key] = $value;
                } elseif (in_array($key, ['changamoto', 'mapendekezo'])) {
                    $groups['Challenges / Recommendations'][$key] = $value;
                } else {
                    $groups['Other Details'][$key] = $value;
                }
            }

            return array_filter($groups, fn($items) => !empty($items));
        }
    ?>

    <div class="page-wrapper">
        <div class="page-header">
            <h1><?php echo e($moduleTitle ?? 'Report'); ?></h1>
            <p>Detailed center report with full participant record information.</p>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <span class="summary-label">Center ID</span>
                <div class="summary-value"><?php echo e($centerId ?? 'N/A'); ?></div>
            </div>

            <div class="summary-card">
                <span class="summary-label">Period</span>
                <div class="summary-value"><?php echo e($periodLabels[$period ?? 'all'] ?? 'All Time'); ?></div>
            </div>

            <div class="summary-card">
                <span class="summary-label">Total Records</span>
                <div class="summary-value"><?php echo e(isset($records) ? $records->count() : 0); ?></div>
            </div>
        </div>

        <?php if(isset($records) && $records->count()): ?>
            <?php if($isCentersWithoutDataReport ?? false): ?>
                <div class="record-card">
                    <div class="record-header">Centers Without Data</div>
                    <div class="fields-grid">
                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="field-item">
                                <span class="field-label">Record <?php echo e($index + 1); ?></span>
                                <div class="field-value">
                                    <strong>Center ID:</strong> <?php echo e(strtoupper($record->center_id)); ?><br>
                                    <strong>Total Users:</strong> <?php echo e($record->total_users); ?><br>
                                    <strong>First Registered:</strong> <?php echo e(\Carbon\Carbon::parse($record->first_registered_at)->format('d M Y')); ?><br>
                                    <strong>Status:</strong> No data submitted
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php else: ?>
            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $attributes = method_exists($record, 'getAttribute') && !empty($record->form_data)
                        ? array_merge(
                            is_array($record->form_data) ? $record->form_data : (json_decode($record->form_data, true) ?: []),
                            [
                                'status' => $record->status,
                                'submitted_at' => $record->submitted_at,
                                'created_at' => $record->created_at,
                                'updated_at' => $record->updated_at,
                            ]
                        )
                        : collect($record->getAttributes())->except($excludedFields)->toArray();
                    $groupedFields = groupFields($attributes);
                ?>

                <div class="record-card">
                    <div class="record-header">
                        Record <?php echo e($index + 1); ?>

                    </div>

                    <div class="record-subheader">
                        <div class="record-subheader-item">
                            <strong>Submitted By:</strong> <?php echo e($record->user->center_id ?? $record->user->email ?? $record->user->name ?? 'Legacy record'); ?>

                        </div>
                        <div class="record-subheader-item">
                            <strong>Email:</strong> <?php echo e($record->user->email ?? 'N/A'); ?>

                        </div>
                        <div class="record-subheader-item">
                            <strong>Center ID:</strong> <?php echo e(strtoupper($record->user->center_id ?? $centerId ?? 'N/A')); ?>

                        </div>
                    </div>

                    <?php $__currentLoopData = $groupedFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionTitle => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="section">
                            <div class="section-title <?php echo e(getSectionClass($sectionTitle)); ?>">
                                <?php echo e($sectionTitle); ?>

                            </div>

                            <div class="fields-grid">
                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="field-item">
                                        <span class="field-label"><?php echo e(formatFieldLabel($key, $labelMap)); ?></span>
                                        <div class="field-value"><?php echo formatFieldValue($key, $value); ?></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                No records found for this center and selected period.
            </div>
        <?php endif; ?>

        <div class="footer-note">
            Generated from CYDC Center Reports
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/cydcacti/cydcactivitiesdb.or.tz/resources/views/reports/print.blade.php ENDPATH**/ ?>