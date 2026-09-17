<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil pengaturan terakhir
$pengaturan = $db->query("SELECT * FROM pengaturan ORDER BY created_at DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

// Jika POST, update atau insert
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kuota = $_POST['kuota'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $nilai_minimal = $_POST['nilai_minimal'];

    if ($pengaturan) {
        // Update pengaturan terakhir
        $stmt = $db->prepare("UPDATE pengaturan SET tahun_ajaran = ?, kuota = ?, tanggal_mulai = ?, tanggal_akhir = ?, nilai_minimal = ? WHERE id = ?");
        $stmt->execute([$tahun_ajaran, $kuota, $tanggal_mulai, $tanggal_akhir, $nilai_minimal, $pengaturan['id']]);
    } else {
        // Insert jika belum ada pengaturan
        $stmt = $db->prepare("INSERT INTO pengaturan (tahun_ajaran, kuota, tanggal_mulai, tanggal_akhir, nilai_minimal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tahun_ajaran, $kuota, $tanggal_mulai, $tanggal_akhir, $nilai_minimal]);
    }

    header('Location: pengaturan.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan - SMK Colomadu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2>Pengaturan</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="<?php echo htmlspecialchars($pengaturan['tahun_ajaran'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kuota" class="form-label">Kuota</label>
                    <input type="number" class="form-control" id="kuota" name="kuota" value="<?php echo htmlspecialchars($pengaturan['kuota'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo htmlspecialchars($pengaturan['tanggal_mulai'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo htmlspecialchars($pengaturan['tanggal_akhir'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nilai_minimal" class="form-label">Nilai Minimal</label>
                    <input type="number" step="0.01" class="form-control" id="nilai_minimal" name="nilai_minimal" value="<?php echo htmlspecialchars($pengaturan['nilai_minimal'] ?? ''); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                <a href="dashboard.php" class="btn btn-secondary ms-2">← Kembali ke Dashboard</a>
            </form>
        </main>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>

</html>
