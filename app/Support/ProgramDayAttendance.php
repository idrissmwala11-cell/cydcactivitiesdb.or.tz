<?php

namespace App\Support;

use App\Models\ProgramDayParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProgramDayAttendance
{
    public static function rosterForUser(int $userId): Collection
    {
        return ProgramDayParticipant::query()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('participant_number')
            ->get();
    }

    public static function rosterTextForUser(int $userId): string
    {
        return self::rosterForUser($userId)
            ->map(fn (ProgramDayParticipant $participant): string => self::formatParticipant($participant))
            ->implode("\n");
    }

    public static function fromRequest(Request $request, int $userId): array
    {
        $rosterText = trim((string) $request->input('participant_roster_text', ''));
        $roster = $rosterText !== ''
            ? self::syncRoster($userId, $rosterText)
            : self::rosterForUser($userId);

        if ($roster->isEmpty()) {
            $present = trim((string) $request->input('present_participants', ''));
            $absent = trim((string) $request->input('absent_participants', ''));

            return [
                'present_participants' => $present !== '' ? $present : null,
                'absent_participants' => $absent !== '' ? $absent : null,
                'present_count' => self::countTextRows($present),
                'absent_count' => self::countTextRows($absent),
            ];
        }

        $presentNumbers = collect($request->input('present_participant_numbers', []))
            ->map(fn ($number): string => trim((string) $number))
            ->filter()
            ->unique()
            ->values();

        if (! $request->has('attendance_marker')) {
            $presentNumbers = $roster->pluck('participant_number')->values();
        }

        $present = $roster->filter(fn (ProgramDayParticipant $participant): bool => $presentNumbers->contains($participant->participant_number));
        $absent = $roster->reject(fn (ProgramDayParticipant $participant): bool => $presentNumbers->contains($participant->participant_number));

        return [
            'present_participants' => self::formatCollection($present),
            'absent_participants' => self::formatCollection($absent),
            'present_count' => $present->count(),
            'absent_count' => $absent->count(),
        ];
    }

    public static function syncRoster(int $userId, string $text): Collection
    {
        $rows = self::parseRosterText($text);
        $numbers = [];

        foreach ($rows as $row) {
            $numbers[] = $row['participant_number'];

            ProgramDayParticipant::query()->updateOrCreate(
                [
                    'user_id' => $userId,
                    'participant_number' => $row['participant_number'],
                ],
                [
                    'participant_name' => $row['participant_name'],
                    'is_active' => true,
                ]
            );
        }

        ProgramDayParticipant::query()
            ->where('user_id', $userId)
            ->when($numbers !== [], fn ($query) => $query->whereNotIn('participant_number', $numbers))
            ->update(['is_active' => false]);

        return self::rosterForUser($userId);
    }

    public static function parseRosterText(string $text): array
    {
        $rows = [];
        $fallbackNumber = 1;

        foreach (preg_split('/\r\n|\r|\n/', $text) ?: [] as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (preg_match('/^\s*([^\t,\-]+)\s*[\t,\-]\s*(.+)$/u', $line, $matches)) {
                $number = trim($matches[1]);
                $name = trim($matches[2]);
            } else {
                $number = 'P'.str_pad((string) $fallbackNumber, 3, '0', STR_PAD_LEFT);
                $name = $line;
            }

            if ($number === '' || $name === '') {
                continue;
            }

            $rows[$number] = [
                'participant_number' => $number,
                'participant_name' => $name,
            ];

            $fallbackNumber++;
        }

        return array_values($rows);
    }

    private static function formatCollection(Collection $participants): ?string
    {
        $text = $participants
            ->map(fn (ProgramDayParticipant $participant): string => self::formatParticipant($participant))
            ->implode("\n");

        return $text !== '' ? $text : null;
    }

    private static function formatParticipant(ProgramDayParticipant $participant): string
    {
        return "{$participant->participant_number} - {$participant->participant_name}";
    }

    private static function countTextRows(string $text): int
    {
        return collect(preg_split('/\r\n|\r|\n/', $text) ?: [])
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->count();
    }
}
