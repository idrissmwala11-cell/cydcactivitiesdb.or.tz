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
        return $this->canAccessCenterRecord($user, $talent);
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
        return $this->canAccessCenterRecord($user, $talent);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TalentsInformation $talent): bool
    {
        return $this->canAccessCenterRecord($user, $talent);
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

    private function canAccessCenterRecord(User $user, TalentsInformation $talent): bool
    {
        if ($user->role === 'admin' || (int) $user->id === (int) $talent->user_id) {
            return true;
        }

        $talent->loadMissing('user');

        $viewerCenter = strtoupper(trim((string) $user->center_id));
        $recordCenter = strtoupper(trim((string) $talent->user?->center_id));

        return $viewerCenter !== '' && $viewerCenter === $recordCenter;
    }
}
