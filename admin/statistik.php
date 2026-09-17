<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Statistik global dan jurusan
$stats = $db->query("SELECT COUNT(*) as total, 
                    SUM(CASE WHEN status = 'lulus' THEN 1 ELSE 0 END) as lulus,
                    SUM(CASE WHEN status = 'tolak' THEN 1 ELSE 0 END) as tolak,
                    SUM(CASE WHEN status = 'menunggu' THEN 1 ELSE 0 END) as menunggu,
                    SUM(CASE WHEN jurusan = 'TKJ' THEN 1 ELSE 0 END) as tkj,
                    SUM(CASE WHEN jurusan = 'TKR' THEN 1 ELSE 0 END) as tkr,
                    SUM(CASE WHEN jurusan = 'TP' THEN 1 ELSE 0 END) as tp
                    FROM pendaftar")->fetch(PDO::FETCH_ASSOC);

// Ambil semua pendaftar
$pendaftar = $db->query("SELECT * FROM pendaftar ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Statistik Pendaftar - SMK Colomadu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2>Statistik Pendaftar</h2>
            <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h5>Total Pendaftar</h5>
                            <p><?php echo $stats['total']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5>Lulus</h5>
                            <p><?php echo $stats['lulus']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">
                            <h5>Ditolak</h5>
                            <p><?php echo $stats['tolak']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark mb-3">
                        <div class="card-body">
                            <h5>Menunggu</h5>
                            <p><?php echo $stats['menunggu']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="mt-4">Pendaftar per Jurusan</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5>TKJ</h5>
                            <p><?php echo $stats['tkj']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5>TKR</h5>
                            <p><?php echo $stats['tkr']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5>TP</h5>
                            <p><?php echo $stats['tp']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="mt-4">Daftar Pendaftar</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendaftar as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['nama']); ?></td>
                                <td><?php echo htmlspecialchars($p['jurusan']); ?></td>
                                <td><?php echo htmlspecialchars($p['status']); ?></td>
                                <td><?php echo isset($p['nilai']) ? $p['nilai'] : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>
</html>
