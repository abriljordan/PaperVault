<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\File;
use App\Models\Folder;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FileManager extends Component
{
    use WithFileUploads;

    public $currentFolder = null;
    public $folders = [];
    public $files = [];
    public $uploading = false;
    public $newFiles = [];
    public $showNewMenu = false;
    public $showCreateFolderModal = false;
    public $modalFolderName = '';
    public $uploadError = '';
    public $uploadProgress = 0;
    public $editingItem = null; // 'file-{id}' or 'folder-{id}'
    public $editingName = '';
    public $contextMenu = null; // 'file-{id}' or 'folder-{id}'
    public $contextMenuX = 0;
    public $contextMenuY = 0;

    protected $rules = [
        'newFiles.*' => 'file|max:102400', // 100MB max file size for document digitization
    ];

    protected $messages = [
        'newFiles.*.file' => 'The uploaded file is invalid.',
        'newFiles.*.max' => 'The file size must not exceed 100MB.',
    ];

    public function mount($folderId = null)
    {
        // Set PHP upload limits for document digitization
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        ini_set('max_execution_time', '600');
        ini_set('max_input_time', '600');
        ini_set('memory_limit', '512M');
        ini_set('max_file_uploads', '20');
        
        $this->currentFolder = $folderId;
        $this->loadFilesAndFolders();
    }

    public function loadFilesAndFolders()
    {
        $this->folders = Folder::where('parent_id', $this->currentFolder)->get();
        $this->files = File::where('folder_id', $this->currentFolder)->get();
    }

    public function updatedNewFiles()
    {
        $this->uploadError = '';
        $this->uploading = true;
        $this->uploadProgress = 0;
        
        try {
            Log::info('Starting file upload process. Files count: ' . count($this->newFiles));
            
            $this->validate();
            $this->uploadProgress = 25;
            
            foreach ($this->newFiles as $index => $file) {
                Log::info('Processing file: ' . $file->getClientOriginalName() . ' (Size: ' . $file->getSize() . ', MIME: ' . $file->getMimeType() . ')');
                
                // Check if file is actually uploaded
                if (!$file->isValid()) {
                    throw new \Exception('File upload failed: ' . $file->getError());
                }
                
                $path = $file->store('files');
                Log::info('File stored at: ' . $path);
                $this->uploadProgress = 50 + ($index * 25);
                
                $fileRecord = File::create([
                    'name' => $file->getClientOriginalName(),
                    'folder_id' => $this->currentFolder,
                    'storage_path' => $path,
                    'uploaded_on_cloud' => true,
                    'user_id' => Auth::id(),
                    'is_folder' => false,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
                
                Log::info('File record created with ID: ' . $fileRecord->id);
            }
            
            $this->newFiles = [];
            $this->loadFilesAndFolders();
            $this->uploadProgress = 100;
            Log::info('File upload process completed successfully');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            $this->uploadError = 'Validation failed: ' . implode(', ', array_flatten($e->errors()));
            $this->newFiles = [];
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            $this->uploadError = 'Upload failed: ' . $e->getMessage();
            $this->newFiles = [];
        } finally {
            $this->uploading = false;
        }
    }

    public function testUpload()
    {
        Log::info('Testing upload functionality');
        $this->uploadError = 'Test upload method called - check logs';
    }

    public function toggleNewMenu()
    {
        $this->showNewMenu = !$this->showNewMenu;
    }

    public function openCreateFolderModal()
    {
        $this->showNewMenu = false;
        $this->showCreateFolderModal = true;
        $this->modalFolderName = '';
    }

    public function closeCreateFolderModal()
    {
        $this->showCreateFolderModal = false;
        $this->modalFolderName = '';
    }

    public function createFolderFromModal()
    {
        if (trim($this->modalFolderName) !== '') {
            Folder::create([
                'name' => $this->modalFolderName,
                'parent_id' => $this->currentFolder,
                'user_id' => Auth::id(),
            ]);
            $this->modalFolderName = '';
            $this->showCreateFolderModal = false;
            $this->loadFilesAndFolders();
        }
    }

    public function enterFolder($folderId)
    {
        $this->currentFolder = $folderId;
        $this->loadFilesAndFolders();
    }

    public function deleteFile($fileId)
    {
        $file = File::findOrFail($fileId);
        $file->delete();
        $this->loadFilesAndFolders();
    }

    public function deleteFolder($folderId)
    {
        $folder = Folder::findOrFail($folderId);
        $folder->delete();
        $this->loadFilesAndFolders();
    }

    public function startRename($type, $id)
    {
        if ($type === 'file') {
            $file = File::findOrFail($id);
            $this->editingItem = "file-{$id}";
            $this->editingName = $file->name;
        } elseif ($type === 'folder') {
            $folder = Folder::findOrFail($id);
            $this->editingItem = "folder-{$id}";
            $this->editingName = $folder->name;
        }
        
        // Hide context menu when starting rename
        $this->hideContextMenu();
    }

    public function cancelRename()
    {
        $this->editingItem = null;
        $this->editingName = '';
    }

    public function saveRename()
    {
        if (empty(trim($this->editingName))) {
            return;
        }

        $parts = explode('-', $this->editingItem);
        $type = $parts[0];
        $id = $parts[1];

        try {
            if ($type === 'file') {
                $file = File::findOrFail($id);
                $file->update(['name' => trim($this->editingName)]);
            } elseif ($type === 'folder') {
                $folder = Folder::findOrFail($id);
                $folder->update(['name' => trim($this->editingName)]);
            }

            $this->editingItem = null;
            $this->editingName = '';
            $this->loadFilesAndFolders();
        } catch (\Exception $e) {
            Log::error('Rename error: ' . $e->getMessage());
        }
    }

    public function showContextMenu($type, $id, $x, $y)
    {
        $this->contextMenu = "{$type}-{$id}";
        $this->contextMenuX = $x;
        $this->contextMenuY = $y;
    }

    public function hideContextMenu()
    {
        $this->contextMenu = null;
        $this->contextMenuX = 0;
        $this->contextMenuY = 0;
    }

    public function render()
    {
        return view('livewire.file-manager')->layout('layouts.app');
    }
}
