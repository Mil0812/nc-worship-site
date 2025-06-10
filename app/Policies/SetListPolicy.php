<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\SetList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SetListPolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма іншими перевірками авторизації.
     */
    public function before(User $user, string $ability): ?bool
    {
        // Адміни мають повний доступ до всіх дій
        return $user->role === Role::ADMIN ? true : null;
    }

    /**
     * Визначає, чи може користувач переглядати список сет-листів.
     */
    public function viewAny(User $user): bool
    {
        return $user->isGroupMember();
    }

    /**
     * Визначає, чи може користувач переглядати конкретний сет-лист.
     */
    public function view(User $user, SetList $setList): bool
    {
        return $user->bands()->where('band_id', $setList->band_id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати сет-листи.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач оновлювати сет-лист.
     */
    public function update(User $user, SetList $setList): bool
    {
        return false;
    }

    /**
     * Визначає, чи може користувач видаляти сет-лист.
     */
    public function delete(User $user, SetList $setList): bool
    {

        return false;
    }
}
