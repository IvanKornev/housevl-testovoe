<?php

declare(strict_types=1);

namespace App\Shared\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Регистрирует команды приложения
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
