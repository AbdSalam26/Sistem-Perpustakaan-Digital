<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

echo "PHP jalan. Versi: " . PHP_VERSION . "<br>";
echo "pdo_pgsql: " . (extension_loaded('pdo_pgsql') ? 'ADA' : 'TIDAK ADA') . "<br>";
echo "mbstring: " . (extension_loaded('mbstring') ? 'ADA' : 'TIDAK ADA') . "<br>";
echo "vendor: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'ADA' : 'TIDAK ADA') . "<br>";
echo "bootstrap: " . (file_exists(__DIR__ . '/../bootstrap/app.php') ? 'ADA' : 'TIDAK ADA') . "<br>";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'TERISI' : 'KOSONG') . "<br>";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'KOSONG') . "<br>";