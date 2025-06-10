<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FavouritePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === Role::ADMIN ? true : null;
    }

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
    public function view(User $user, Favourite $favorite): bool
    {
        return $user->id === $favorite->user_id;
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
    public function update(User $user, Favourite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Favourite $favorite): bool
    {
        return $user->id === $favorite->user_id;
    }
}
