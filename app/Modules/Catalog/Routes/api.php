<?php

use App\Modules\Catalog\Http\Controllers\CatalogController;

Route::get('/catalog/tree', [CatalogController::class, 'getTree']);
