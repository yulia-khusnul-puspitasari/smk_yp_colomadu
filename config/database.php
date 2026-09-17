<?php
$host = '127.0.0.1';
$dbname = 'smk_yp_colomadu';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $dbname);

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>