<?php

namespace App\Modules\User\Events;

use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use App\Modules\User\Entities\User;

class UserChanges
{
    use SerializesModels;

    /**
     * Новый инстанс события сущности
     *
     * @return void
     */
    public function __construct(User $model)
    {
        $this->hashPassword($model);
    }

     /**
     * Хеширует пароль создаваемого или обновляемого
     * пользователя
     *
     * @return void
    */
    private function hashPassword(User $model): void
    {
        $passwordHash = Hash::make($model->password);
        $model->password = $passwordHash;
    }
}
