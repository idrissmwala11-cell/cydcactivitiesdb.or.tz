@php
    $presentValue = old('present_participants', $record->present_participants ?? '');
    $absentValue = old('absent_participants', $record->absent_participants ?? '');
@endphp

<div class="overflow-hidden rounded-[2rem] border border-indigo-100 bg-white shadow-[0_24px_60px_-32px_rgba(79,70,229,0.28)]">
    <div class="border-b border-indigo-100 bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-6 text-white">
        <h2 class="text-xl font-semibold">Participants Attendance</h2>
        <p class="mt-1 text-sm text-indigo-100">Jaza jina na namba ya participant. Kila mstari uwe participant mmoja.</p>
    </div>

    <div class="p-6 md:p-8">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="present_participants" class="mb-2 block text-sm font-semibold text-gray-700">
                    Participants Present
                </label>
                <textarea
                    name="present_participants"
                    id="present_participants"
                    rows="6"
                    placeholder="Mfano: TZ001 - Asha Juma&#10;TZ002 - Baraka Musa"
                    class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                >{{ $presentValue }}</textarea>
                <p class="mt-2 text-xs text-gray-500">Andika waliohudhuria: namba ya participant na jina lake.</p>
            </div>

            <div>
                <label for="absent_participants" class="mb-2 block text-sm font-semibold text-gray-700">
                    Participants Absent
                </label>
                <textarea
                    name="absent_participants"
                    id="absent_participants"
                    rows="6"
                    placeholder="Mfano: TZ003 - Neema Paulo&#10;TZ004 - John Peter"
                    class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                >{{ $absentValue }}</textarea>
                <p class="mt-2 text-xs text-gray-500">Andika wasiokuwepo: namba ya participant na jina lake.</p>
            </div>
        </div>
    </div>
</div>
