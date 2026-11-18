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

   // Jalankan booting secara manual supaya error pertama tidak tertelan
   $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
   $kernel->bootstrap();

   $app->handleRequest(Illuminate\Http\Request::capture());
} catch (\Throwable $e) {
   http_response_code(500);
   echo '<pre>';
   $x = $e;
   while ($x) {
      echo get_class($x) . "\n" . $x->getMessage() . "\n";
      echo $x->getFile() . ':' . $x->getLine() . "\n\n";
      $x = $x->getPrevious();
   }
   echo substr($e->getTraceAsString(), 0, 3000);
   echo '</pre>';
}