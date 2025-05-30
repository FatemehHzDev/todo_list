<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
Volt::route('register', 'register')->name('register');
Volt::route('login', 'login')->name('login');

});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
