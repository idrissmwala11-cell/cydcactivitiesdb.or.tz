@props([
    'fieldName' => 'participants',
    'participants' => [],
    'countInputId' => null,
    'countInputMode' => 'present',
    'title' => 'Select Participants',
    'helpText' => 'Tick waliopo na untick wasiokuwepo. Total itajihesabu yenyewe.',
    'addButtonText' => 'Add Participant',
])

@php
    $rows = collect($participants ?? [])->map(function ($participant) {
        if (is_array($participant)) {
            return [
                'participant_name' => $participant['participant_name'] ?? '',
                'participant_number' => $participant['participant_number'] ?? '',
                'status' => $participant['status'] ?? 'present',
            ];
        }

        return [
            'participant_name' => $participant->participant_name ?? '',
            'participant_number' => $participant->participant_number ?? '',
            'status' => $participant->status ?? 'present',
        ];
    })->values();

    if ($rows->isEmpty()) {
        $rows = collect([
            ['participant_name' => '', 'participant_number' => '', 'status' => 'present'],
        ]);
    }

    $componentId = 'attendance-checklist-'.uniqid();
@endphp

@once
    <style>
        .attendance-checklist-card {
            border: 1px solid #d7e3df;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 14px 35px -28px rgba(15, 23, 42, 0.45);
            overflow: hidden;
        }

        .attendance-checklist-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #0f5132, #198754);
            color: #ffffff;
        }

        .attendance-checklist-title {
            margin: 0;
            font-weight: 800;
            font-size: 1.05rem;
        }

        .attendance-checklist-help {
            margin: 0.25rem 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.85rem;
        }

        .attendance-checklist-add {
            border: 1px solid rgba(255, 255, 255, 0.65);
            border-radius: 999px;
            background: #ffffff;
            color: #0f5132;
            cursor: pointer;
            font-weight: 800;
            padding: 0.6rem 0.95rem;
            white-space: nowrap;
        }

        .attendance-checklist-body {
            padding: 1rem;
        }

        .attendance-participant-list {
            display: grid;
            gap: 0.75rem;
        }

        .attendance-participant-row {
            display: grid;
            grid-template-columns: minmax(180px, 1.4fr) minmax(140px, 0.8fr) auto auto;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #f8fafc;
            padding: 0.75rem;
        }

        .attendance-name-wrap {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            min-width: 0;
        }

        .attendance-name-wrap input[type="checkbox"] {
            width: 1.15rem;
            height: 1.15rem;
            accent-color: #198754;
            flex: 0 0 auto;
        }

        .attendance-field {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 0.65rem 0.75rem;
            background: #ffffff;
            color: #0f172a;
            min-height: 42px;
        }

        .attendance-remove {
            border: 1px solid #fecaca;
            border-radius: 10px;
            background: #ffffff;
            color: #dc2626;
            cursor: pointer;
            font-weight: 700;
            min-height: 42px;
            padding: 0 0.8rem;
        }

        .attendance-counts {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .attendance-count-box {
            border-radius: 14px;
            padding: 0.8rem 1rem;
            background: #f1f5f9;
            text-align: center;
        }

        .attendance-count-label {
            display: block;
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .attendance-count-value {
            display: block;
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 900;
            line-height: 1.1;
        }

        .attendance-count-present {
            background: #dcfce7;
        }

        .attendance-count-present .attendance-count-value {
            color: #15803d;
        }

        .attendance-count-absent {
            background: #fee2e2;
        }

        .attendance-count-absent .attendance-count-value {
            color: #b91c1c;
        }

        @media (max-width: 768px) {
            .attendance-checklist-head {
                align-items: stretch;
                flex-direction: column;
            }

            .attendance-checklist-add {
                width: 100%;
            }

            .attendance-participant-row {
                grid-template-columns: 1fr;
            }

            .attendance-remove {
                width: 100%;
            }

            .attendance-counts {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endonce

<div
    id="{{ $componentId }}"
    class="attendance-checklist-card"
    data-field-name="{{ $fieldName }}"
    data-count-input-id="{{ $countInputId }}"
    data-count-input-mode="{{ $countInputMode }}"
>
    <div class="attendance-checklist-head">
        <div>
            <h3 class="attendance-checklist-title">{{ $title }}</h3>
            <p class="attendance-checklist-help">{{ $helpText }}</p>
        </div>
        <button type="button" class="attendance-checklist-add">+ {{ $addButtonText }}</button>
    </div>

    <div class="attendance-checklist-body">
        <div class="attendance-participant-list">
            @foreach($rows as $index => $participant)
                @php
                    $isPresent = ($participant['status'] ?? 'present') !== 'absent';
                @endphp
                <div class="attendance-participant-row">
                    <div class="attendance-name-wrap">
                        <input type="checkbox" class="attendance-present-toggle" @checked($isPresent)>
                        <input
                            type="text"
                            class="attendance-field attendance-participant-name"
                            name="{{ $fieldName }}[{{ $index }}][participant_name]"
                            value="{{ $participant['participant_name'] ?? '' }}"
                            placeholder="Participant Name"
                        >
                    </div>
                    <input
                        type="text"
                        class="attendance-field"
                        name="{{ $fieldName }}[{{ $index }}][participant_number]"
                        value="{{ $participant['participant_number'] ?? '' }}"
                        placeholder="Participant Number"
                    >
                    <input
                        type="hidden"
                        class="attendance-status"
                        name="{{ $fieldName }}[{{ $index }}][status]"
                        value="{{ $isPresent ? 'present' : 'absent' }}"
                    >
                    <button type="button" class="attendance-remove">Remove</button>
                </div>
            @endforeach
        </div>

        <div class="attendance-counts">
            <div class="attendance-count-box">
                <span class="attendance-count-label">Total</span>
                <span class="attendance-count-value attendance-total">0</span>
            </div>
            <div class="attendance-count-box attendance-count-present">
                <span class="attendance-count-label">Present</span>
                <span class="attendance-count-value attendance-present">0</span>
            </div>
            <div class="attendance-count-box attendance-count-absent">
                <span class="attendance-count-label">Absent</span>
                <span class="attendance-count-value attendance-absent">0</span>
            </div>
        </div>
    </div>
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.attendance-checklist-card').forEach(function (root) {
                const list = root.querySelector('.attendance-participant-list');
                const addButton = root.querySelector('.attendance-checklist-add');
                const fieldName = root.dataset.fieldName || 'participants';
                const countInputId = root.dataset.countInputId || '';
                const countInputMode = root.dataset.countInputMode || 'present';
                const countInput = countInputId ? document.getElementById(countInputId) : null;
                let nextIndex = list.querySelectorAll('.attendance-participant-row').length;

                function escapeHtml(value) {
                    return String(value).replace(/[&<>"']/g, function (char) {
                        return {
                            '&': '&amp;',
                            '<': '&lt;',
                            '>': '&gt;',
                            '"': '&quot;',
                            "'": '&#039;',
                        }[char];
                    });
                }

                function hasName(row) {
                    const input = row.querySelector('.attendance-participant-name');
                    return input && input.value.trim() !== '';
                }

                function syncRow(row) {
                    const checkbox = row.querySelector('.attendance-present-toggle');
                    const status = row.querySelector('.attendance-status');
                    if (checkbox && status) {
                        status.value = checkbox.checked ? 'present' : 'absent';
                    }
                }

                function updateCounts() {
                    const rows = Array.from(list.querySelectorAll('.attendance-participant-row')).filter(hasName);
                    const present = rows.filter(function (row) {
                        const checkbox = row.querySelector('.attendance-present-toggle');
                        return checkbox && checkbox.checked;
                    }).length;
                    const total = rows.length;

                    root.querySelector('.attendance-total').textContent = total;
                    root.querySelector('.attendance-present').textContent = present;
                    root.querySelector('.attendance-absent').textContent = total - present;

                    if (countInput) {
                        countInput.value = countInputMode === 'total' ? total : present;
                    }
                }

                function rowTemplate(index) {
                    return `
                        <div class="attendance-participant-row">
                            <div class="attendance-name-wrap">
                                <input type="checkbox" class="attendance-present-toggle" checked>
                                <input type="text" class="attendance-field attendance-participant-name" name="${escapeHtml(fieldName)}[${index}][participant_name]" placeholder="Participant Name">
                            </div>
                            <input type="text" class="attendance-field" name="${escapeHtml(fieldName)}[${index}][participant_number]" placeholder="Participant Number">
                            <input type="hidden" class="attendance-status" name="${escapeHtml(fieldName)}[${index}][status]" value="present">
                            <button type="button" class="attendance-remove">Remove</button>
                        </div>
                    `;
                }

                addButton.addEventListener('click', function () {
                    list.insertAdjacentHTML('beforeend', rowTemplate(nextIndex));
                    nextIndex++;
                    updateCounts();
                });

                list.addEventListener('click', function (event) {
                    const button = event.target.closest('.attendance-remove');
                    if (!button) return;

                    const row = button.closest('.attendance-participant-row');
                    if (row) {
                        row.remove();
                        updateCounts();
                    }
                });

                list.addEventListener('change', function (event) {
                    const row = event.target.closest('.attendance-participant-row');
                    if (row) {
                        syncRow(row);
                        updateCounts();
                    }
                });

                list.addEventListener('input', updateCounts);

                list.querySelectorAll('.attendance-participant-row').forEach(syncRow);
                updateCounts();
            });
        });
    </script>
@endonce
