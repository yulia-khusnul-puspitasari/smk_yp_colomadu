<?php
session_start();
require '../config/database.php';
require '../config/logging.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'panitia') {
    header('Location: login.php');
    exit;
}

try {
    $persyaratan = $db->query("SELECT * FROM persyaratan ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Terjadi kesalahan: " . $e->getMessage();
    logError($e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_persyaratan'])) {
    $nama = trim($_POST['nama_persyaratan']);
    $deskripsi = trim($_POST['deskripsi']);
    $wajib = isset($_POST['wajib']) ? 1 : 0;
    try {
        $stmt = $db->prepare("INSERT INTO persyaratan (nama_persyaratan, deskripsi, wajib) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $deskripsi, $wajib]);
        $_SESSION['success'] = "Persyaratan berhasil ditambahkan!";
        header('Location: persyaratan.php');
        exit;
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan: " . $e->getMessage();
        logError($e->getMessage());
    }
}

if (isset($_POST['delete'])) {
    $id = (int)$_POST['id'];
    try {
        $stmt = $db->prepare("DELETE FROM persyaratan WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Persyaratan berhasil dihapus!";
        header('Location: persyaratan.php');
        exit;
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan saat menghapus: " . $e->getMessage();
        logError($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persyaratan - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_panitia.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Persyaratan Pendaftaran</h2>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="POST" class="mb-4">
                    <div class="mb-3">
                        <label for="nama_persyaratan" class="form-label">Nama Persyaratan</label>
                        <input type="text" class="form-control" id="nama_persyaratan" name="nama_persyaratan" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="wajib" name="wajib">
                            <label class="form-check-label" for="wajib">Wajib</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Persyaratan</th>
                                <th>Deskripsi</th>
                                <th>Wajib</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($persyaratan as $p): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($p['nama_persyaratan']); ?></td>
                                    <td><?php echo htmlspecialchars($p['deskripsi'] ?? '-'); ?></td>
                                    <td><?php echo $p['wajib'] ? 'Ya' : 'Tidak'; ?></td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Hapus</button>
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