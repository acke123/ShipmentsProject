<?php

namespace App\Policies;

use App\Models\ShipmentModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ShipmentModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShipmentModel $shipmentModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShipmentModel $shipmentModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShipmentModel $shipmentModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShipmentModel $shipmentModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShipmentModel $shipmentModel): bool
    {
        return false;
    }

    public function canViewCreationPage(User $user): bool
    {
        return $user->role == User::ROLE_ADMIN;
    }
}
