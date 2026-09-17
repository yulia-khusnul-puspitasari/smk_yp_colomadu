<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? 'list';

// Ambil semua berita
$berita = $db->query("SELECT * FROM berita ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);

// Tambah berita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $deskripsi_gambar = $_POST['deskripsi_gambar'];
    $tanggal = date('Y-m-d H:i:s');

    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $gambar = 'assets/img/berita/' . time() . '.' . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], '../' . $gambar);
        } else {
            $error = "File harus JPG atau PNG!";
        }
    }

    if (!isset($error)) {
        $stmt = $db->prepare("INSERT INTO berita (judul, isi, gambar, deskripsi_gambar, tanggal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$judul, $isi, $gambar, $deskripsi_gambar, $tanggal]);
        header('Location: berita.php');
        exit;
    }
}

// Edit berita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $deskripsi_gambar = $_POST['deskripsi_gambar'];

    $gambar = $_POST['gambar_lama'];
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $gambar = 'assets/img/berita/' . time() . '.' . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], '../' . $gambar);
        } else {
            $error = "File harus JPG atau PNG!";
        }
    }

    if (!isset($error)) {
        $stmt = $db->prepare("UPDATE berita SET judul = ?, isi = ?, gambar = ?, deskripsi_gambar = ? WHERE id = ?");
        $stmt->execute([$judul, $isi, $gambar, $deskripsi_gambar, $id]);
        header('Location: berita.php');
        exit;
    }
}

// Hapus berita
if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT gambar FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $berita_item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($berita_item && $berita_item['gambar']) {
        $gambar_path = '../' . $berita_item['gambar'];
        if (file_exists($gambar_path)) {
            unlink($gambar_path);
        }
    }
    $db->prepare("DELETE FROM berita WHERE id = ?")->execute([$id]);
    header('Location: berita.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Berita - SMK YP COLOMADU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
        }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid content-wrapper">
    <div class="row flex-grow-1">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 main-content">
            <h2>Kelola Berita</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($action == 'add'): ?>
                <a href="berita.php" class="btn btn-secondary mb-3">← Kembali ke Daftar Berita</a>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea class="form-control" name="isi" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Gambar</label>
                        <input type="text" class="form-control" name="deskripsi_gambar">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Berita</button>
                </form>
            <?php else: ?>
                <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
                <a href="berita.php?action=add" class="btn btn-primary mb-3 ms-2">+ Tambah Berita</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($berita as $b): ?>
                            <tr>
                                <td><?= htmlspecialchars($b['judul']) ?></td>
                                <td>
                                    <?php if ($b['gambar']): ?>
                                        <img src="../<?= htmlspecialchars($b['gambar']) ?>" alt="" width="100">
                                    <?php else: ?>-
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($b['deskripsi_gambar']) ?></td>
                                <td><?= $b['tanggal'] ?></td>
                                <td>
                                    <a href="berita.php?action=delete&id=<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus berita ini?')">Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal<?= $b['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" enctype="multipart/form-data" class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                            <input type="hidden" name="gambar_lama" value="<?= $b['gambar'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Judul</label>
                                                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($b['judul']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Isi Berita</label>
                                                <textarea name="isi" class="form-control" rows="5" required><?= htmlspecialchars($b['isi']) ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ganti Gambar</label>
                                                <input type="file" name="gambar" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi Gambar</label>
                                                <input type="text" name="deskripsi_gambar" class="form-control" value="<?= htmlspecialchars($b['deskripsi_gambar']) ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
    <?php include '../includes/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
