@if(($record->present_participants ?? null) || ($record->absent_participants ?? null))
    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Participants Attendance</h3>

        <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div class="rounded-2xl bg-gray-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Total</div>
                <div class="text-2xl font-black text-gray-900">{{ (int) ($record->present_count ?? 0) + (int) ($record->absent_count ?? 0) }}</div>
            </div>
            <div class="rounded-2xl bg-green-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-green-700">Present</div>
                <div class="text-2xl font-black text-green-700">{{ (int) ($record->present_count ?? 0) }}</div>
            </div>
            <div class="rounded-2xl bg-red-50 p-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-red-700">Absent</div>
                <div class="text-2xl font-black text-red-700">{{ (int) ($record->absent_count ?? 0) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-medium text-gray-700">Present Participants:</span>
                <div class="bg-green-50 p-3 rounded-md mt-1">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $record->present_participants ?: 'N/A' }}</p>
                </div>
            </div>

            <div>
                <span class="font-medium text-gray-700">Absent Participants:</span>
                <div class="bg-red-50 p-3 rounded-md mt-1">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $record->absent_participants ?: 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
@endif
