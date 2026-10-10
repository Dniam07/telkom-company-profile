<?php
$envPath = dirname(__DIR__) . '/.env';

if (!is_file($envPath)) {
    exit('File konfigurasi .env tidak ditemukan.');
}

$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

$requiredKeys = ['DB_HOST', 'DB_PORT', 'DB_USER', 'DB_PASSWORD', 'DB_NAME'];
foreach ($requiredKeys as $key) {
    if (!array_key_exists($key, $env)) {
        exit("Konfigurasi {$key} tidak ditemukan pada file .env.");
    }
}

$host = $env['DB_HOST'];
$port = (int) $env['DB_PORT'];
$user = $env['DB_USER'];
$password = $env['DB_PASSWORD'];
$database = $env['DB_NAME'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $password, $database, $port);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    exit('Koneksi database gagal. Periksa Apache/MySQL dan konfigurasi database.');
}
