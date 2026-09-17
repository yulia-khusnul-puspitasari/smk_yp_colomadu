<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? 'list';
$video = $db->query("SELECT * FROM video ORDER BY tanggal_upload DESC")->fetchAll(PDO::FETCH_ASSOC);

// Tambah video
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $judul = $_POST['judul'];
    $url = $_POST['url'];
    $tanggal = date('Y-m-d H:i:s');

    $stmt = $db->prepare("INSERT INTO video (judul, url, tanggal_upload) VALUES (?, ?, ?)");
    $stmt->execute([$judul, $url, $tanggal]);

    header("Location: video.php");
    exit;
}

// Edit video
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $url = $_POST['url'];

    $stmt = $db->prepare("UPDATE video SET judul = ?, url = ? WHERE id = ?");
    $stmt->execute([$judul, $url, $id]);

    header("Location: video.php");
    exit;
}

// Hapus video
if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->prepare("DELETE FROM video WHERE id = ?")->execute([$id]);
    header("Location: video.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Video - SMK YP COLOMADU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .modal-backdrop.show {
            opacity: 0.5;
        }
        .modal-content {
            background-color: #fff;
        }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Kelola Galeri Video</h2>

            <?php if ($action === 'add'): ?>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL Video (YouTube Embed)</label>
                        <input type="text" class="form-control" name="url" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Video</button>
                    <a href="video.php" class="btn btn-secondary ms-2">← Kembali</a>
                </form>
            <?php else: ?>
                <a href="video.php?action=add" class="btn btn-primary mb-3">Tambah Video</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>URL</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($video as $v): ?>
                            <tr>
                                <td><?= htmlspecialchars($v['judul']) ?></td>
                                <td><a href="<?= htmlspecialchars($v['url']) ?>" target="_blank">Lihat</a></td>
                                <td><?= $v['tanggal_upload'] ?></td>
                                <td>
                                    <!-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $v['id'] ?>">Edit</button> -->
                                    <a href="video.php?action=delete&id=<?= $v['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit (diletakkan di luar tr) -->
                            <div class="modal fade" id="editModal<?= $v['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $v['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $v['id'] ?>">Edit Video</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Judul</label>
                                                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($v['judul']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">URL Video</label>
                                                <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($v['url']) ?>" required>
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
