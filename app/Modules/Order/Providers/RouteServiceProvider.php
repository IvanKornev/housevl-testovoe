<?php

namespace App\Modules\Order\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleNamespace = 'App\Modules\Order\Http\Controllers';

    /**
     * Регистрирует привязки моделей и прочее
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Объявляет маршруты модуля
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
    }

    /**
     * Подключает API-эндпоинты модуля
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Order', '/Routes/api.php'));
    }
}
