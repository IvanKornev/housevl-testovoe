<?php

namespace App\Modules\User\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\User\Services\Contracts\ICartService;
use App\Modules\User\Services\CartService;

use App\Modules\User\Repositories\Contracts\ICartRepository;
use App\Modules\User\Repositories\CartRepository;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'User';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'user';

    /**
     * Загружает события приложения
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Регистрирует поставщика услуг
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(ICartService::class, CartService::class);
        $this->app->bind(ICartRepository::class, CartRepository::class);
    }

    /**
     * Регистрирует конфиг модуля
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Регистрирует переводы для модуля
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Получает сервисы поставщика
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }
}
