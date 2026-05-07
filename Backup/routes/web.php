<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');


Route::get('/animal/{tag_number}', [App\Http\Controllers\AnimalController::class, 'show'])->name('animal.show');
