<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\FileManager;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
use App\Livewire\TestComponent;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('drive');
    }
    return view('welcome');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/drive', FileManager::class)->name('drive');
    Route::get('/files/{id}/download', [FileController::class, 'download'])->name('files.download');
});

Route::get('/test', TestComponent::class)->name('test');

require __DIR__.'/auth.php';
