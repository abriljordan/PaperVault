<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r flex flex-col p-4">
        <div class="mb-8">
            <span class="text-2xl font-extrabold text-indigo-700 tracking-tight">PaperVault</span>
        </div>
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <button wire:click="enterFolder(null)" class="flex items-center w-full px-3 py-2 rounded-lg text-indigo-700 bg-indigo-100 font-semibold">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7a2 2 0 012-2h3.172a2 2 0 011.414.586l1.828 1.828A2 2 0 0012.828 8H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                        My Drive
                    </button>
                </li>
                <li>
                    <button class="flex items-center w-full px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 17.75l-6.172 3.245 1.179-6.873L2 9.755l6.908-1.004L12 2.5l3.092 6.251L22 9.755l-5.007 4.367 1.179 6.873z"/></svg>
                        Starred
                    </button>
                </li>
                <li>
                    <button class="flex items-center w-full px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                        Trash
                    </button>
                </li>
                <li class="mt-6">
                    <span class="text-xs text-gray-400 uppercase tracking-widest">Folders</span>
                    <ul class="mt-2 space-y-1">
                        @foreach($folders as $folder)
                            <li>
                                <button wire:click="enterFolder({{ $folder->id }})" class="flex items-center w-full px-2 py-1 rounded text-gray-700 hover:bg-indigo-50">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7a2 2 0 012-2h3.172a2 2 0 011.414.586l1.828 1.828A2 2 0 0012.828 8H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                                    {{ $folder->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Folder Creation Modal -->
        @if($showCreateFolderModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                    <h2 class="text-lg font-bold mb-4">Create New Folder</h2>
                    <input type="text" wire:model.defer="modalFolderName" placeholder="Folder name" class="border rounded px-3 py-2 w-full mb-4" autofocus>
                    <div class="flex justify-end gap-2">
                        <button wire:click="closeCreateFolderModal" type="button" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                        <button wire:click="createFolderFromModal" type="button" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Create</button>
                    </div>
                </div>
            </div>
        @endif
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        <!-- Toolbar -->
        <div class="flex items-center justify-between px-8 py-4 border-b bg-white">
            <div class="flex items-center gap-2">
                <div class="relative">
                    <button
                        type="button"
                        wire:click="toggleNewMenu"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-indigo-700 transition"
                        id="new-menu-btn"
                    >
                        New
                    </button>
                    @if($showNewMenu)
                        <div class="absolute left-0 mt-2 w-40 bg-white border rounded shadow z-10">
                            <button
                                type="button"
                                wire:click="openCreateFolderModal"
                                class="block w-full text-left px-4 py-2 hover:bg-indigo-50"
                            >
                                New Folder
                            </button>
                            <label class="block w-full text-left px-4 py-2 hover:bg-indigo-50 cursor-pointer">
                                Upload Files
                                <input type="file" multiple wire:model="newFiles" class="hidden">
                            </label>
                            <div class="px-4 py-2 text-xs text-gray-500 border-t">
                                Max file size: 100MB
                            </div>
                            <button wire:click="testUpload" class="block w-full text-left px-4 py-2 hover:bg-indigo-50 text-xs text-gray-500">
                                Test Upload
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-4">
                <input type="text" placeholder="Search in PaperVault..." class="border rounded px-3 py-2 w-64" disabled>
                <button class="p-2 rounded hover:bg-gray-100" title="Grid view (stub)">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </button>
                <button class="p-2 rounded hover:bg-gray-100" title="List view (stub)">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="4" rx="2"/><rect x="3" y="15" width="18" height="4" rx="2"/></svg>
                </button>
            </div>
        </div>

        <!-- Upload Error Display -->
        @if($uploadError)
            <div class="px-8 py-2 bg-red-50 border-b border-red-200">
                <div class="text-red-600 text-sm">{{ $uploadError }}</div>
            </div>
        @endif

        <!-- Upload Progress -->
        @if($uploading)
            <div class="px-8 py-2 bg-blue-50 border-b border-blue-200">
                <div class="flex items-center">
                    <div class="text-blue-600 text-sm mr-2">Uploading...</div>
                    <div class="flex-1 bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $uploadProgress }}%"></div>
                    </div>
                    <div class="text-blue-600 text-sm ml-2">{{ $uploadProgress }}%</div>
                </div>
            </div>
        @endif

        <!-- Breadcrumbs -->
        <div class="px-8 py-2 bg-gray-50 border-b">
            <nav class="flex items-center text-sm text-gray-500 space-x-2">
                <button wire:click="enterFolder(null)" class="hover:underline text-indigo-600">My Drive</button>
                @if($currentFolder)
                    <span>/</span>
                    <span class="text-gray-700 font-semibold">{{ optional($folders->firstWhere('id', $currentFolder))->name ?? 'Folder' }}</span>
                @endif
            </nav>
        </div>

        <!-- Main Area: Grid of Files/Folders -->
        <div class="flex-1 overflow-y-auto p-8">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <!-- Folders (subfolders in current folder) -->
                @foreach($folders as $folder)
                    <div class="flex flex-col items-center bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                        <button wire:click="enterFolder({{ $folder->id }})" class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-yellow-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7a2 2 0 012-2h3.172a2 2 0 011.414.586l1.828 1.828A2 2 0 0012.828 8H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                            <span class="mt-1 text-sm font-medium text-gray-700">{{ $folder->name }}</span>
                        </button>
                    </div>
                @endforeach
                <!-- Files -->
                @foreach($files as $file)
                    <div class="flex flex-col items-center bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                        @php
                            $fileExtension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
                            $isPdf = $fileExtension === 'pdf';
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                            $isDocument = in_array($fileExtension, ['doc', 'docx', 'txt', 'rtf']);
                            $isSpreadsheet = in_array($fileExtension, ['xls', 'xlsx', 'csv']);
                            $isPresentation = in_array($fileExtension, ['ppt', 'pptx']);
                        @endphp
                        
                        @if($isPdf)
                            <svg class="w-10 h-10 text-red-500 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M16 13H8"/>
                                <path d="M16 17H8"/>
                                <path d="M10 9H8"/>
                            </svg>
                        @elseif($isImage)
                            <svg class="w-10 h-10 text-green-500 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21,15 16,10 5,21"/>
                            </svg>
                        @elseif($isDocument)
                            <svg class="w-10 h-10 text-blue-500 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M16 13H8"/>
                                <path d="M16 17H8"/>
                                <path d="M10 9H8"/>
                            </svg>
                        @elseif($isSpreadsheet)
                            <svg class="w-10 h-10 text-green-600 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M16 13H8"/>
                                <path d="M16 17H8"/>
                                <path d="M10 9H8"/>
                            </svg>
                        @elseif($isPresentation)
                            <svg class="w-10 h-10 text-orange-500 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M16 13H8"/>
                                <path d="M16 17H8"/>
                                <path d="M10 9H8"/>
                            </svg>
                        @else
                            <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path d="M8 2v4M16 2v4M4 10h16"/>
                            </svg>
                        @endif
                        
                        <span class="mt-1 text-sm font-medium text-gray-700 text-center">{{ $file->name }}</span>
                        <div class="flex gap-2 mt-2">
                            <a href="{{ route('files.download', $file->id) }}" class="text-indigo-600 hover:underline text-xs">Download</a>
                            <button wire:click="deleteFile({{ $file->id }})" class="text-red-500 hover:underline text-xs">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
