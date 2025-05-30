<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
});
require __DIR__.'/auth.php';

Volt::route('tasks','task.list')->name('tasks');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('dashboard', 'dashboard')->name('dashboard');
});

Volt::route('task_do','task_do')->name('task_do')->middleware('auth');
