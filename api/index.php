<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

try {
   $storage = '/tmp/storage';
   foreach (['app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $dir) {
      if (!is_dir("$storage/$dir")) {
         mkdir("$storage/$dir", 0755, true);
      }
   }

   require __DIR__ . '/../vendor/autoload.php';

   $app = require_once __DIR__ . '/../bootstrap/app.php';
   $app->useStoragePath($storage);

   $app->handleRequest(Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
   http_response_code(500);
   echo '<pre>' . get_class($e) . "\n" . $e->getMessage() . "\n\n";
   echo $e->getFile() . ':' . $e->getLine() . "\n\n";
   echo $e->getTraceAsString() . '</pre>';
}