<?php

namespace App\Shared\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

abstract class TestCase extends BaseTestCase
{
    public function createApplication(): Application
    {
        $app = require __DIR__. ' /../../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}
