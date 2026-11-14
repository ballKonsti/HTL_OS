<?php

use App\Http\Controllers\Api\NodeController;
use App\Livewire\Admin\Manager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
Route::get('admin', Manager::class)->name('admin');

Route::get('/api/nodes', [NodeController::class, 'index'])->name('api.nodes.index');

Route::get('api/nodes/{node}', [NodeController::class, 'show'])->name('api.nodes.show');
