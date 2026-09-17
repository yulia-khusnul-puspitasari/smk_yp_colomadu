<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$sekolah = $db->query("SELECT * FROM sekolah LIMIT 1")->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $visi = $_POST['visi'];
    $misi = $_POST['misi'];

    if ($sekolah) {
        $stmt = $db->prepare("UPDATE sekolah SET alamat = ?, kontak = ?, visi = ?, misi = ? WHERE id = ?");
        $stmt->execute([$alamat, $kontak, $visi, $misi, $sekolah['id']]);
    } else {
        $stmt = $db->prepare("INSERT INTO sekolah (alamat, kontak, visi, misi) VALUES (?, ?, ?, ?)");
        $stmt->execute([$alamat, $kontak, $visi, $misi]);
    }

    header('Location: sekolah.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Info Sekolah - SMK YP COLOMADU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
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
        <!-- Sidebar Navigasi -->
        <?php include '../includes/sidebar_admin.php'; ?>

        <!-- Konten Utama -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Informasi Sekolah</h2>

            <form method="POST" style="max-width: 700px;">
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" 
                        value="<?php echo htmlspecialchars($sekolah['alamat'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak</label>
                    <input type="text" class="form-control" id="kontak" name="kontak" 
                        value="<?php echo htmlspecialchars($sekolah['kontak'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="visi" class="form-label">Visi</label>
                    <textarea class="form-control" id="visi" name="visi" rows="3" required><?php echo htmlspecialchars($sekolah['visi'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="misi" class="form-label">Misi</label>
                    <textarea class="form-control" id="misi" name="misi" rows="4" required><?php echo htmlspecialchars($sekolah['misi'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="dashboard.php" class="btn btn-secondary ms-2">← Kembali</a>
            </form>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
