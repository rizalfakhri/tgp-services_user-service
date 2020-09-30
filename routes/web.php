<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthorizeController;

Route::get('/', function () {
    return [
        'name'     => 'User Service',
        'version'  => '1.0',
        'codename' => 'sapiens'
    ];
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/authorize', AuthorizeController::class);
