<?php

define('LARAVEL_START', microtime(true));

// Filesystem Vercel read-only, semua yang ditulis Laravel diarahkan ke /tmp
$tmp = '/tmp';
foreach ([
   'storage/app/public',
   'storage/framework/cache/data',
   'storage/framework/sessions',
   'storage/framework/views',
   'storage/logs',
   'bootstrap/cache',
] as $dir) {
   if (!is_dir("$tmp/$dir")) {
      mkdir("$tmp/$dir", 0755, true);
   }
}

$cachePaths = [
   'APP_SERVICES_CACHE' => "$tmp/bootstrap/cache/services.php",
   'APP_PACKAGES_CACHE' => "$tmp/bootstrap/cache/packages.php",
   'APP_CONFIG_CACHE' => "$tmp/bootstrap/cache/config.php",
   'APP_ROUTES_CACHE' => "$tmp/bootstrap/cache/routes-v7.php",
   'APP_EVENTS_CACHE' => "$tmp/bootstrap/cache/events.php",
   'VIEW_COMPILED_PATH' => "$tmp/storage/framework/views",
];
foreach ($cachePaths as $key => $value) {
   putenv("$key=$value");
   $_ENV[$key] = $value;
   $_SERVER[$key] = $value;
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath("$tmp/storage");

$app->handleRequest(
   Illuminate\Http\Request::capture()
);