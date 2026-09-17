<?php
session_start();
require '../config/database.php';
require '../config/logging.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'panitia') {
    header('Location: login.php');
    exit;
}

try {
    $total = $db->query("SELECT COUNT(*) FROM pendaftar")->fetchColumn();
    $diterima = $db->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'diterima'")->fetchColumn();
    $ditolak = $db->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'ditolak'")->fetchColumn();
    $revisi = $db->query("SELECT COUNT(*) FROM pendaftar WHERE status = 'revisi'")->fetchColumn();
    $pendaftar = $db->query("SELECT id, nama, nis, jurusan, status FROM pendaftar ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Terjadi kesalahan: " . $e->getMessage();
    logError($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Panitia - SMK YP COLOMADU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard_panitia.php">SMK YP COLOMADU</a>
  </div>
</nav> -->

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Panitia -->
        <?php include '../includes/sidebar_panitia.php'; ?>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Dashboard Panitia</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5>Total Pendaftar</h5>
                            <p><?php echo $total; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5>Diterima</h5>
                            <p><?php echo $diterima; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5>Ditolak</h5>
                            <p><?php echo $ditolak; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5>Revisi</h5>
                            <p><?php echo $revisi; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5>Ringkasan Pendaftar</h5>
                    <canvas id="statusChart" height="100"></canvas>
                </div>
            </div>

            <div class="table-responsive">
                <h5>Pendaftar Terbaru</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendaftar as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['nama']); ?></td>
                                <td><?php echo htmlspecialchars($p['nis']); ?></td>
                                <td><?php echo htmlspecialchars($p['jurusan']); ?></td>
                                <td>
                                    <span class="text-<?php echo $p['status'] == 'diterima' ? 'success' : ($p['status'] == 'ditolak' ? 'danger' : 'warning'); ?>">
                                        <?php echo htmlspecialchars($p['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include '../includes/footer.php'; ?>

<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Diterima', 'Ditolak', 'Revisi'],
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: [<?php echo $diterima; ?>, <?php echo $ditolak; ?>, <?php echo $revisi; ?>],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107']
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
