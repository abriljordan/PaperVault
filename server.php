<?php

// Set PHP upload limits for document digitization
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('max_execution_time', '600');
ini_set('max_input_time', '600');
ini_set('memory_limit', '512M');
ini_set('max_file_uploads', '20');

// Include Laravel's server file
require_once __DIR__.'/vendor/laravel/framework/src/Illuminate/Foundation/Console/../resources/server.php'; 