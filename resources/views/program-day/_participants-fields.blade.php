@php
    $rosterUserId = (int) ($rosterUserId ?? ($record->user_id ?? auth()->id()));
    $participants = \App\Support\ProgramDayAttendance::rosterForUser($rosterUserId);
    $rosterText = old('participant_roster_text', \App\Support\ProgramDayAttendance::rosterTextForUser($rosterUserId));
    $oldPresentNumbers = old('present_participant_numbers');
    $absentText = (string) ($record->absent_participants ?? '');
    $absentNumbers = collect(preg_split('/\r\n|\r|\n/', $absentText) ?: [])
        ->map(function (string $line): ?string {
            if (preg_match('/^\s*([^\t,\-]+)\s*[\t,\-]/u', $line, $matches)) {
                return trim($matches[1]);
            }

            return null;
        })
        ->filter()
        ->values()
        ->all();
    $attendanceId = 'program-day-attendance-'.uniqid();
@endphp

<div id="{{ $attendanceId }}" class="overflow-hidden rounded-[2rem] border border-indigo-100 bg-white shadow-[0_24px_60px_-32px_rgba(79,70,229,0.28)]">
    <div class="border-b border-indigo-100 bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-6 text-white">
        <h2 class="text-xl font-semibold">Participants Attendance</h2>
        <p class="mt-1 text-sm text-indigo-100">Hifadhi list ya wanafunzi wote, kisha tick waliopo na untick wasiokuwepo.</p>
    </div>

    <div class="p-6 md:p-8 space-y-6">
        <div>
            <label for="{{ $attendanceId }}-roster" class="mb-2 block text-sm font-semibold text-gray-700">
                List ya Wanafunzi Wote
            </label>
            <textarea
                name="participant_roster_text"
                id="{{ $attendanceId }}-roster"
                rows="6"
                placeholder="Mfano: TZ001 - Asha Juma&#10;TZ002 - Baraka Musa&#10;TZ003 - Neema Paulo"
                class="program-day-roster w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
            >{{ $rosterText }}</textarea>
            <p class="mt-2 text-xs text-gray-500">
                Kila mstari uwe na namba na jina la participant. Ukibadilisha list hii, itasave kwa matumizi ya siku nyingine.
            </p>
        </div>

        <input type="hidden" name="attendance_marker" value="1">

        <div class="rounded-3xl border border-indigo-100 bg-indigo-50/50 p-4">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Chagua Waliopo</h3>
                    <p class="text-sm text-gray-600">Waliowekwa tick watahesabika kama present. Ondoa tick kwa absent.</p>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center text-sm">
                    <div class="rounded-2xl bg-white px-4 py-2 shadow-sm">
                        <div class="text-xs font-semibold text-gray-500">Total</div>
                        <div class="program-day-total text-lg font-black text-gray-900">0</div>
                    </div>
                    <div class="rounded-2xl bg-green-50 px-4 py-2 shadow-sm">
                        <div class="text-xs font-semibold text-green-700">Present</div>
                        <div class="program-day-present text-lg font-black text-green-700">0</div>
                    </div>
                    <div class="rounded-2xl bg-red-50 px-4 py-2 shadow-sm">
                        <div class="text-xs font-semibold text-red-700">Absent</div>
                        <div class="program-day-absent text-lg font-black text-red-700">0</div>
                    </div>
                </div>
            </div>

            <div class="program-day-checklist mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                @forelse($participants as $participant)
                    @php
                        $number = (string) $participant->participant_number;
                        $isChecked = is_array($oldPresentNumbers)
                            ? in_array($number, array_map('strval', $oldPresentNumbers), true)
                            : ! in_array($number, $absentNumbers, true);
                    @endphp
                    <label class="program-day-row flex items-start gap-3 rounded-2xl border border-white bg-white px-4 py-3 text-sm shadow-sm">
                        <input type="hidden" name="all_participant_numbers[]" value="{{ $number }}">
                        <input
                            type="checkbox"
                            name="present_participant_numbers[]"
                            value="{{ $number }}"
                            @checked($isChecked)
                            class="program-day-present-checkbox mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span>
                            <span class="block font-bold text-gray-900">{{ $participant->participant_name }}</span>
                            <span class="text-xs font-semibold text-gray-500">{{ $number }}</span>
                        </span>
                    </label>
                @empty
                    <div class="program-day-empty rounded-2xl border border-dashed border-indigo-200 bg-white px-4 py-6 text-center text-sm text-gray-500 md:col-span-2">
                        Bandika list ya wanafunzi hapo juu ili checklist ionekane.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.getElementById(@json($attendanceId));
        if (!root) return;

        const roster = root.querySelector('.program-day-roster');
        const checklist = root.querySelector('.program-day-checklist');
        const totalEl = root.querySelector('.program-day-total');
        const presentEl = root.querySelector('.program-day-present');
        const absentEl = root.querySelector('.program-day-absent');

        function parseRoster(text) {
            return text.split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean)
                .map((line, index) => {
                    const match = line.match(/^\s*([^\t,\-]+)\s*[\t,\-]\s*(.+)$/);
                    return match
                        ? { number: match[1].trim(), name: match[2].trim() }
                        : { number: `P${String(index + 1).padStart(3, '0')}`, name: line };
                })
                .filter((row) => row.number && row.name);
        }

        function updateCounts() {
            const boxes = Array.from(root.querySelectorAll('.program-day-present-checkbox'));
            const present = boxes.filter((box) => box.checked).length;
            totalEl.textContent = boxes.length;
            presentEl.textContent = present;
            absentEl.textContent = boxes.length - present;
        }

        function renderFromRoster() {
            const existing = new Map(
                Array.from(root.querySelectorAll('.program-day-present-checkbox')).map((box) => [box.value, box.checked])
            );
            const rows = parseRoster(roster.value);

            if (rows.length === 0) {
                checklist.innerHTML = '<div class="program-day-empty rounded-2xl border border-dashed border-indigo-200 bg-white px-4 py-6 text-center text-sm text-gray-500 md:col-span-2">Bandika list ya wanafunzi hapo juu ili checklist ionekane.</div>';
                updateCounts();
                return;
            }

            checklist.innerHTML = rows.map((row) => {
                const checked = existing.has(row.number) ? existing.get(row.number) : true;
                return `
                    <label class="program-day-row flex items-start gap-3 rounded-2xl border border-white bg-white px-4 py-3 text-sm shadow-sm">
                        <input type="hidden" name="all_participant_numbers[]" value="${escapeHtml(row.number)}">
                        <input type="checkbox" name="present_participant_numbers[]" value="${escapeHtml(row.number)}" ${checked ? 'checked' : ''} class="program-day-present-checkbox mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span>
                            <span class="block font-bold text-gray-900">${escapeHtml(row.name)}</span>
                            <span class="text-xs font-semibold text-gray-500">${escapeHtml(row.number)}</span>
                        </span>
                    </label>
                `;
            }).join('');
            bindChecks();
            updateCounts();
        }

        function escapeHtml(value) {
            return String(value).replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
            }[char]));
        }

        function bindChecks() {
            root.querySelectorAll('.program-day-present-checkbox').forEach((box) => {
                box.removeEventListener('change', updateCounts);
                box.addEventListener('change', updateCounts);
            });
        }

        roster.addEventListener('input', renderFromRoster);
        bindChecks();
        updateCounts();
    });
</script>
