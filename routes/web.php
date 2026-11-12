<?php

use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShipmentController::class, 'index']);

Route::resource('shipments', ShipmentController::class)
->parameter('shipments', 'shipment');
