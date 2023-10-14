<?php

use App\Modules\Catalog\Http\Controllers\TreeController;

Route::get('/catalog/tree', [TreeController::class, 'get']);
