<?php

declare(strict_types=1);

namespace App\Modules\User\Api;

use App\Modules\User\Api\Contracts\IUserApi;
use App\Modules\User\Entities\User;

final class UserApi implements IUserApi
{
    public function get(int $id = 1): array
    {
        return User::findOrFail($id)->toArray();
    }
}
