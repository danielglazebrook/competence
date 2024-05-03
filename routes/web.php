<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/sales');

// Here I would include checks to check whether the user is logged in or not

Route::get('/sales', [SaleController::class, 'index']);
Route::post('sales/create',[SaleController::class, 'create']);