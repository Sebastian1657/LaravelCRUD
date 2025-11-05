<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', [TodoController::class, 'index']);

// TRASY DO DODAWANIA NOWEGO ZADANIA
Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');

// NOWA TRASA DO PRZEŁĄCZANIA STANU ZADANIA
Route::patch('/todo/{id}/toggle', [TodoController::class, 'toggleComplete'])->name('todo.toggle');

// Trasa dla guzika "View"
Route::get('/todo/{id}', [TodoController::class, 'show'])->name('todo.show');

// Trasa dla guzika "Edit"
Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])->name('todo.edit');
Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');

// Trasa dla guzika "Soft Delete"
Route::delete('/todo/{id}/soft', [TodoController::class, 'softDelete'])->name('todo.softDelete');

// Trasa dla guzika "Delete"
Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');

// TRASA DO WYŚWIETLANIA KOSZA
Route::get('/trash', [TodoController::class, 'trash'])->name('todo.trash');

// TRASA DO PRZYWRACANIA Z KOSZA
Route::patch('/todo/{id}/restore', [TodoController::class, 'restore'])->name('todo.restore');
