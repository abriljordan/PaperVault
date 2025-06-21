<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function download($id)
    {
        $file = File::findOrFail($id);
        // Optional: check if the user owns the file
        if ($file->user_id !== Auth::id()) {
            abort(403);
        }
        return Storage::download($file->storage_path, $file->name);
    }
}
