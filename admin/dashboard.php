<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $stmt = $db->query("SELECT COUNT(*) as total, 
        SUM(CASE WHEN status = 'lulus' THEN 1 ELSE 0 END) as lulus,
        SUM(CASE WHEN status = 'tolak' THEN 1 ELSE 0 END) as tolak,
        SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) as menunggu
        FROM pendaftar");
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $stats = ['total' => 0, 'lulus' => 0, 'tolak' => 0, 'menunggu' => 0];
}

try {
    $berita = $db->query("SELECT * FROM berita ORDER BY tanggal DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $berita = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
        }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../includes/sidebar_admin.php'; ?>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2>Dashboard Admin</h2>
            <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>!</p>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5>Total Pendaftar</h5>
                            <p><?php echo $stats['total']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5>Lulus</h5>
                            <p><?php echo $stats['lulus']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5>Ditolak</h5>
                            <p><?php echo $stats['tolak']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5>Menunggu</h5>
                            <p><?php echo $stats['menunggu']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h3>Berita Terbaru</h3>
            <a href="akun_panitia.php" class="btn btn-outline-primary mb-3">Kelola Akun Panitia</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Deskripsi Gambar</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($berita as $b): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($b['judul']); ?></td>
                            <td>
                                <?php if ($b['gambar']): ?>
                                    <img src="../<?php echo htmlspecialchars($b['gambar']); ?>" width="100">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($b['deskripsi_gambar'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($b['tanggal']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
