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
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SkillsAttendance $skillsAttendance): bool
    {
        // Admin can view all records, users can view their own records
        return $user->role === 'admin' || $user->id === $skillsAttendance->user_id;
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
    public function update(User $user, SkillsAttendance $skillsAttendance): bool
    {
        // Admin can update all records, users can update their own records
        return $user->role === 'admin' || $user->id === $skillsAttendance->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SkillsAttendance $skillsAttendance): bool
    {
        // Admin can delete all records, users can delete their own records
        return $user->role === 'admin' || $user->id === $skillsAttendance->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SkillsAttendance $skillsAttendance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SkillsAttendance $skillsAttendance): bool
    {
        return false;
    }
}
