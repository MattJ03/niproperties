<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingPolicy
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
    public function view(User $user, Listing $listing): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasRole('landlord')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
         return $user->hasRole('landlord') && $listing->landlord_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->hasRole('landlord') && $listing->landlord_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        return $user->hasRole('landlord') && $listing->landlord_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->hasRole('landlord') && $listing->landlord_id === $user->id;
    }
}
