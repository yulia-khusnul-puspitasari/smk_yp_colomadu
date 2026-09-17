<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
try {
    $pendaftar = $db->prepare("SELECT * FROM pendaftar WHERE user_id = ?");
    $pendaftar->execute([$user_id]);
    $pendaftar_data = $pendaftar->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Terjadi kesalahan saat mengambil data pendaftaran: " . $e->getMessage();
    file_put_contents('../logs/error.log', date('Y-m-d H:i:s') . ': ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
}

$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_siswa.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Dashboard Siswa</h2>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <h5>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h5>
                        <?php if ($pendaftar_data): ?>
                            <p>Status Pendaftaran: 
                                <strong class="text-<?php echo $pendaftar_data['status'] == 'diterima' ? 'success' : ($pendaftar_data['status'] == 'ditolak' ? 'danger' : 'warning'); ?>">
                                    <?php echo htmlspecialchars($pendaftar_data['status']); ?>
                                </strong>
                            </p>
                            <p>Jurusan: <?php echo htmlspecialchars($pendaftar_data['jurusan']); ?></p>
                            <p>NIK: <?php echo htmlspecialchars($pendaftar_data['nik']); ?></p>
                            <p>Email: <?php echo htmlspecialchars($pendaftar_data['email']); ?></p>
                            <p>No HP: <?php echo htmlspecialchars($pendaftar_data['nohp']); ?></p>
                            <a href="pengumuman.php" class="btn btn-primary">Lihat Pengumuman</a>
                            <a href="formulir.php" class="btn btn-secondary">Edit Pendaftaran</a>
                        <?php else: ?>
                            <div class="alert alert-info">Belum mendaftar. Silakan isi formulir pendaftaran untuk memulai.</div>
                            <a href="formulir.php" class="btn btn-primary">Isi Formulir</a>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>