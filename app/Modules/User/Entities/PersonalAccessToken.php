<?php

namespace App\Modules\User\Entities;

use Laravel\Sanctum\PersonalAccessToken as Model;

final class PersonalAccessToken extends Model
{
    /**
     * Ограничение сохранения записей PersonalAccessToken.
     * Будет сохранять, только если изменилось что-то, кроме поля last_used_at.
     *
     * @param  array  $options
     * @return void
     */
    public function save(array $options = []): void
    {
        $changes = $this->getDirty();
        $withLastUsedAt = array_key_exists('last_used_at', $changes)
            || count($changes) <= 2;
        if (!$withLastUsedAt) {
            parent::save();
        }
    }
}
