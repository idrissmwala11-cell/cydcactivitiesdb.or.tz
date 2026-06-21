<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function scopeRecordsVisibleToUser(Builder $query, ?User $user = null): Builder
    {
        $user ??= Auth::user();

        if (! $user || $user->role === 'admin') {
            return $query;
        }

        $centerId = $this->normalizedCenterId($user->center_id);

        if ($centerId === '') {
            return $query->where('user_id', $user->id);
        }

        return $query->whereHas('user', function (Builder $userQuery) use ($centerId) {
            $userQuery->whereRaw('UPPER(TRIM(center_id)) = ?', [$centerId]);
        });
    }

    protected function authorizeCenterRecord(Model $record, string $message = 'Huruhusiwi kuona taarifa za center nyingine.'): void
    {
        abort_unless($this->userCanAccessCenterRecord($record), 403, $message);
    }

    protected function userCanAccessCenterRecord(Model $record, ?User $user = null): bool
    {
        $user ??= Auth::user();

        if (! $user) {
            return false;
        }

        if ($user->role === 'admin' || (int) ($record->user_id ?? 0) === (int) $user->id) {
            return true;
        }

        $record->loadMissing('user');

        $viewerCenter = $this->normalizedCenterId($user->center_id);
        $recordCenter = $this->normalizedCenterId($record->user?->center_id);

        return $viewerCenter !== '' && $viewerCenter === $recordCenter;
    }

    protected function normalizedCenterId(?string $centerId): string
    {
        return strtoupper(trim((string) $centerId));
    }
}
