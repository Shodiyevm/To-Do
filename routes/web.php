<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 Route::get('/', [TodoController::class, 'index'])->name("home");
Route::post('/todos', [TodoController::class, 'store']); 
Route::patch('/todos/{id}', [TodoController::class, 'update']); 
Route::delete('/todos/{id}', [TodoController::class, 'destroy']); 
Route::patch('/todos/{id}/toggle', [TodoController::class, 'toggle']); 
});
require __DIR__.'/auth.php';
