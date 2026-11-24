<?php

use App\Http\Controllers\Api\NodeController;
use App\Livewire\Admin\Manager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('admin', Manager::class)->name('admin');
    Route::view('admin/graph', 'admin-graph')->name('admin.graph');
});

require __DIR__.'/settings.php';
Route::get('/api/nodes', [NodeController::class, 'index'])
    ->middleware('throttle:120,1')
    ->name('api.nodes.index');

Route::get('api/nodes/{node}', [NodeController::class, 'show'])
    ->middleware('throttle:120,1')
    ->name('api.nodes.show');

Route::view('Rundgang', 'pics')->name('Rundgang');
