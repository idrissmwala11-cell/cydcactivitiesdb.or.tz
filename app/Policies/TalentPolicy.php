<?php

namespace App\Policies;

use App\Models\TalentsInformation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TalentPolicy
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
    public function view(User $user, TalentsInformation $talent): bool
    {
        // Admin can view all records, users can view their own records
        return $user->role === 'admin' || $user->id === $talent->user_id;
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
    public function update(User $user, TalentsInformation $talent): bool
    {
        // Admin can update all records, users can update their own records
        return $user->role === 'admin' || $user->id === $talent->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TalentsInformation $talent): bool
    {
        // Admin can delete all records, users can delete their own records
        return $user->role === 'admin' || $user->id === $talent->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TalentsInformation $talent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TalentsInformation $talent): bool
    {
        return false;
    }
}
