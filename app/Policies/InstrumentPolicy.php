<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstrumentPolicy
{
    use HandlesAuthorization;

    /**
     * Виконується перед усіма іншими перевірками авторизації.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === Role::ADMIN ? true : null;
    }

    /**
     * Визначає, чи може користувач переглядати список інструментів.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Визначає, чи може користувач переглядати конкретний інструмент.
     */
    public function view(User $user, Instrument $instrument): bool
    {
        return true;
    }

    /**
     * Визначає, чи може користувач створювати інструменти.
     */
    public function create(User $user): bool
    {
        return $user->isGroupMember();
    }

    /**
     * Визначає, чи може користувач оновлювати інструмент.
     */
    public function update(User $user, Instrument $instrument): bool
    {
        return $user->isGroupMember();
    }

    /**
     * Визначає, чи може користувач видаляти інструмент.
     */
    public function delete(User $user, Instrument $instrument): bool
    {
        return $user->isGroupMember();
    }
}
