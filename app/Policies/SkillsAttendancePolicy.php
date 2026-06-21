<?php

namespace App\Policies;

use App\Models\SkillsAttendance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SkillsAttendancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool|Response
    {
        // Everyone can view list of records
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SkillsAttendance $skillsAttendance): bool|Response
    {
        return $this->canAccessCenterRecord($user, $skillsAttendance)
            ? Response::allow()
            : Response::deny('You do not have permission to view this record.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool|Response
    {
        return Response::allow(); // Everyone can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SkillsAttendance $skillsAttendance): bool|Response
    {
        return $this->canAccessCenterRecord($user, $skillsAttendance)
            ? Response::allow()
            : Response::deny('You do not have permission to update this record.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SkillsAttendance $skillsAttendance): bool|Response
    {
        return $this->canAccessCenterRecord($user, $skillsAttendance)
            ? Response::allow()
            : Response::deny('You do not have permission to delete this record.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SkillsAttendance $skillsAttendance): bool|Response
    {
        return Response::deny('Restore is not allowed.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SkillsAttendance $skillsAttendance): bool|Response
    {
        return Response::deny('Force delete is not allowed.');
    }

    private function canAccessCenterRecord(User $user, SkillsAttendance $skillsAttendance): bool
    {
        if ($user->role === 'admin' || (int) $user->id === (int) $skillsAttendance->user_id) {
            return true;
        }

        $skillsAttendance->loadMissing('user');

        $viewerCenter = strtoupper(trim((string) $user->center_id));
        $recordCenter = strtoupper(trim((string) $skillsAttendance->user?->center_id));

        return $viewerCenter !== '' && $viewerCenter === $recordCenter;
    }
}
