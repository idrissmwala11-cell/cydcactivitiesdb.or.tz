<?php

namespace App\Policies;

use App\Models\TalentAttendance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TalentAttendancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TalentAttendance $talentAttendance): bool
    {
        return $this->canAccessCenterRecord($user, $talentAttendance);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TalentAttendance $talentAttendance): bool
    {
        return $this->canAccessCenterRecord($user, $talentAttendance);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TalentAttendance $talentAttendance): bool
    {
        return $this->canAccessCenterRecord($user, $talentAttendance);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TalentAttendance $talentAttendance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TalentAttendance $talentAttendance): bool
    {
        return false;
    }

    private function canAccessCenterRecord(User $user, TalentAttendance $talentAttendance): bool
    {
        if ($user->role === 'admin' || (int) $user->id === (int) $talentAttendance->user_id) {
            return true;
        }

        $talentAttendance->loadMissing('user');

        $viewerCenter = strtoupper(trim((string) $user->center_id));
        $recordCenter = strtoupper(trim((string) $talentAttendance->user?->center_id));

        return $viewerCenter !== '' && $viewerCenter === $recordCenter;
    }
}
