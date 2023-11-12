<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductTable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('livewire.product-table'); // Change 'welcome' to 'livewire.product-table'
});

Route::get('/', ProductTable::class);

//Route::get('/', ProductTable::class);