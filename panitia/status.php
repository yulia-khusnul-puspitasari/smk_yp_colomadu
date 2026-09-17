<?php
session_start();
require '../config/database.php';
require '../config/logging.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'panitia') {
    header('Location: login.php');
    exit;
}

try {
    $pendaftar = $db->query("SELECT id, nama, nis, nik, jurusan, status, komentar FROM pendaftar ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Terjadi kesalahan: " . $e->getMessage();
    logError($e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['status'], $_POST['komentar'])) {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $komentar = trim($_POST['komentar']);
    if (!in_array($status, ['menunggu','diterima','diterima', 'ditolak', 'revisi'])) {
        $error = "Status tidak valid!";
    } else {
        try {
            $stmt = $db->prepare("UPDATE pendaftar SET status = ?, komentar = ? WHERE id = ?");
            $stmt->execute([$status, $komentar, $id]);
            $_SESSION['success'] = "Status dan komentar berhasil diperbarui!";
            header('Location: status.php');
            exit;
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
            logError($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftar - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_panitia.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Status Pendaftar</h2>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>NIK</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Komentar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendaftar as $p): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($p['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($p['nis']); ?></td>
                                    <td><?php echo htmlspecialchars($p['nik']); ?></td>
                                    <td><?php echo htmlspecialchars($p['jurusan']); ?></td>
                                    <td>
                                        <span class="text-<?php echo $p['status'] == 'diterima' ? 'success' : ($p['status'] == 'ditolak' ? 'danger' : 'warning'); ?>">
                                            <?php echo htmlspecialchars($p['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($p['komentar'] ?? '-'); ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                            <div class="mb-2">
                                                <select name="status" class="form-select form-select-sm">
                                                    <option value="diterima" <?php echo $p['status'] == 'diterima' ? 'selected' : ''; ?>>Diterima</option>
                                                    <option value="ditolak" <?php echo $p['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                                    <option value="revisi" <?php echo $p['status'] == 'revisi' ? 'selected' : ''; ?>>Revisi</option>
                                                    <option value="menunggu" <?php echo $p['status'] == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <textarea name="komentar" class="form-control form-control-sm" placeholder="Komentar"><?php echo htmlspecialchars($p['komentar'] ?? ''); ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>