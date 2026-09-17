<?php
function logError($message) {
    $log_dir = __DIR__ . '/../logs';
    $log_file = $log_dir . '/error.log';
    
    // Cek dan bikin folder logs kalau belum ada
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0777, true);
    }
    
    // Tulis log dengan timestamp
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "$timestamp: $message" . PHP_EOL;
    
    // Coba tulis ke file, skip kalau gagal (biar ga error lagi)
    @file_put_contents($log_file, $log_message, FILE_APPEND);
}
?>