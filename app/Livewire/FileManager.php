<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\File;
use App\Models\Folder;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class FileManager extends Component
{
    use WithFileUploads;

#    public string $layout = 'layouts.app';
    public $currentFolder = null;
    public $folders = [];
    public $files = [];
    public $uploading = false;
    public $newFiles = [];
    public $showNewMenu = false;
    public $showCreateFolderModal = false;
    public $modalFolderName = '';

    public function mount($folderId = null)
    {
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
        foreach ($this->newFiles as $file) {
            $path = $file->store('files');
            File::create([
                'name' => $file->getClientOriginalName(),
                'folder_id' => $this->currentFolder,
                'storage_path' => $path,
                'uploaded_on_cloud' => true,
                'user_id' => Auth::id(),
                'is_folder' => false,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
        $this->newFiles = [];
        $this->loadFilesAndFolders();
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

    public function render()
    {
        return view('livewire.file-manager')->layout('layouts.app');;
    }
}
