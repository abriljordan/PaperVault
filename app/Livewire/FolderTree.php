<?php

namespace App\Livewire;

use Livewire\Component;

class FolderTree extends Component
{
    public function render()
    {
        return view('livewire.folder-tree')->layout('layouts.app');;
    }
}
