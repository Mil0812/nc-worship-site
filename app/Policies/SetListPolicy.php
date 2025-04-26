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
        // Учасники гурту можуть переглядати списки сет-листів
        return $user->isGroupMember();
    }

    /**
     * Визначає, чи може користувач переглядати конкретний сет-лист.
     */
    public function view(User $user, SetList $setList): bool
    {
        // Перевірка, чи є користувач учасником гурту, до якого належить сет-лист
        return $user->bands()->where('band_id', $setList->band_id)->exists();
    }

    /**
     * Визначає, чи може користувач створювати сет-листи.
     */
    public function create(User $user): bool
    {
        // Тільки лідери гурту можуть створювати сет-листи
        return $user->bands()->wherePivot('is_leader', true)->exists();
    }

    /**
     * Визначає, чи може користувач оновлювати сет-лист.
     */
    public function update(User $user, SetList $setList): bool
    {
        // Тільки лідери гурту можуть редагувати сет-листи
        return $user->bands()
            ->where('band_id', $setList->band_id)
            ->wherePivot('is_leader', true)
            ->exists();
    }

    /**
     * Визначає, чи може користувач видаляти сет-лист.
     */
    public function delete(User $user, SetList $setList): bool
    {
        // Тільки лідери гурту можуть видаляти сет-листи
        return $user->bands()
            ->where('band_id', $setList->band_id)
            ->wherePivot('is_leader', true)
            ->exists();
    }
}
