<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/clientes');

Route::resource('clientes', ClienteController::class);
