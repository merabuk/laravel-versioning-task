<?php

declare(strict_types=1);

use App\App\Api\V1\Controllers\Company\CreateCompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('/company')->as('company.')->group(function () {
    Route::post('/', CreateCompanyController::class)->name('create');
});
