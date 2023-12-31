<?php

namespace App\Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\Order\Services\Contracts\IOrderService;
use App\Modules\Order\Services\OrderService;

use App\Modules\Order\Integrations\Contracts\IOrderPaymentRequest;
use App\Modules\Order\Integrations\MockedOrderPaymentRequest;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Order';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'order';

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
        $this->app->bind(IOrderService::class, OrderService::class);
        $this->app->bind(IOrderPaymentRequest::class, MockedOrderPaymentRequest::class);
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
