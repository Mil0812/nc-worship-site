<?php

namespace App\Policies;

use App\Models\Band;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BandPolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма іншими перевірками авторизації.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->isAdmin() ? true : null;
    }

    /**
     * Визначає, чи може користувач переглядати список гуртів.
     */
    public function viewAny(User $user): bool
    {
        return $user->isUser() || $user->isGroupMember();
    }

    /**
     * Визначає, чи може користувач переглядати конкретний гурт.
     */
    public function view(User $user, Band $band): bool
    {
        return $user->isUser() || $user->isGroupMember();
    }

    /**
     * Визначає, чи може користувач створювати гурти.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач оновлювати гурт.
     */
    public function update(User $user, Band $band): bool
    {
        return $user->bands()->where('band_id', $band->id)->wherePivot('is_leader', true)->exists();
    }

    /**
     * Визначає, чи може користувач видаляти гурт.
     */
    public function delete(User $user, Band $band): bool
    {
        return $user->bands()->where('band_id', $band->id)->wherePivot('is_leader', true)->exists();
    }
}
