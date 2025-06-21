<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\FileManager;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;
use App\Livewire\TestComponent;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('drive');
    }
    return view('welcome');
});

Route::get('dashboard', function () {
    return redirect()->route('drive');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/drive', FileManager::class)->name('drive');
    Route::get('/files/{id}/download', [FileController::class, 'download'])->name('files.download');
});

Route::get('/test', TestComponent::class)->name('test');

Route::get('/test-upload-settings', function () {
    // Try to set the limits
    ini_set('upload_max_filesize', '100M');
    ini_set('post_max_size', '100M');
    ini_set('max_execution_time', '600');
    ini_set('max_input_time', '600');
    ini_set('memory_limit', '512M');
    ini_set('max_file_uploads', '20');
    
    return response()->json([
        'current_settings' => [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_execution_time' => ini_get('max_execution_time'),
            'max_input_time' => ini_get('max_input_time'),
            'memory_limit' => ini_get('memory_limit'),
            'max_file_uploads' => ini_get('max_file_uploads'),
        ],
        'server_info' => [
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
        ],
        'message' => 'Check if upload_max_filesize and post_max_size are now 100M'
    ]);
});

Route::post('/test-upload', function (Request $request) {
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        return response()->json([
            'success' => true,
            'file_info' => [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError(),
            ],
            'upload_settings' => [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ]
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'No file uploaded',
        'files' => $request->allFiles(),
    ]);
});

require __DIR__.'/auth.php';
