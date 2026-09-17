<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$pendaftar = $db->prepare("SELECT * FROM pendaftar WHERE user_id = ?");
$pendaftar->execute([$user_id]);
$pendaftar_data = $pendaftar->fetch(PDO::FETCH_ASSOC);

$komentar = $db->prepare("SELECT k.*, u.nama AS panitia_nama FROM komentar k JOIN users u ON k.panitia_id = u.id WHERE k.pendaftar_id = ?");
$komentar->execute([$pendaftar_data['id'] ?? 0]);
$komentar_data = $komentar->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_siswa.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Pengumuman</h2>
                <?php if ($pendaftar_data): ?>
                    <div class="card">
                        <div class="card-body">
                            <h5>Status: <?php echo htmlspecialchars($pendaftar_data['status']); ?></h5>
                            <?php if ($komentar_data): ?>
                                <h6>Komentar dari Panitia:</h6>
                                <ul>
                                    <?php foreach ($komentar_data as $k): ?>
                                        <li><?php echo htmlspecialchars($k['komentar']); ?> (oleh <?php echo htmlspecialchars($k['panitia_nama']); ?>)</li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>Belum ada komentar dari panitia.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Belum mendaftar. Silakan isi formulir pendaftaran.</div>
                <?php endif; ?>
            </main>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>