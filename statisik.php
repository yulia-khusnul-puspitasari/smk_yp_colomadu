<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login_admin.php');
    exit;
}

$stmt = $mysqli->prepare("SELECT jurusan, COUNT(*) as total FROM pendaftar GROUP BY jurusan");
$stmt->execute();
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Statistik Pendaftar - SPMB SMK Colomadu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f8; padding: 20px; }
        .card { border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .card-header { background: #1e3c72; color: white; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Statistik Pendaftar</h5>
            </div>
            <div class="card-body">
                <div id="chart-container" style="height: 400px;"></div>
                <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
    <script>
        // Chart config (simulasi data, ganti dengan data dinamis dari PHP)
        const chartData = {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($data, 'jurusan')); ?>,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: <?php echo json_encode(array_column($data, 'total')); ?>,
                    backgroundColor: ['#1e3c72', '#4a90e2', '#63b3ed'],
                    borderColor: ['#1e3c72', '#4a90e2', '#63b3ed'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart-container').getContext('2d');
        new Chart(ctx, chartData);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>