<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? 'list';
$foto = $db->query("SELECT * FROM foto ORDER BY tanggal_upload DESC")->fetchAll(PDO::FETCH_ASSOC);

// Tambah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'add') {
    $keterangan = $_POST['keterangan'];
    $tanggal = date('Y-m-d H:i:s');

    $nama_file = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
            $nama_file = 'assets/img/galeri/' . time() . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../' . $nama_file);
        } else {
            $error = "File harus JPG atau PNG!";
        }
    }

    if (!isset($error)) {
        $stmt = $db->prepare("INSERT INTO foto (nama_file, keterangan, tanggal_upload) VALUES (?, ?, ?)");
        $stmt->execute([$nama_file, $keterangan, $tanggal]);
        header('Location: foto.php');
        exit;
    }
}

// Hapus
if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT nama_file FROM foto WHERE id = ?");
    $stmt->execute([$id]);
    $foto_item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($foto_item && $foto_item['nama_file']) {
        @unlink('../' . $foto_item['nama_file']);
    }
    $db->prepare("DELETE FROM foto WHERE id = ?")->execute([$id]);
    header('Location: foto.php');
    exit;
}

// Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'edit' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $keterangan = $_POST['keterangan'];

    $db->prepare("UPDATE foto SET keterangan = ? WHERE id = ?")->execute([$keterangan, $id]);
    header('Location: foto.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Galeri Foto - SMK YP COLOMADU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Kelola Galeri Foto</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($action == 'add'): ?>
                <a href="foto.php" class="btn btn-secondary mb-3">← Kembali</a>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Foto</button>
                </form>

            <?php else: ?>
                <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
                <a href="foto.php?action=add" class="btn btn-primary mb-3 ms-2">+ Tambah Foto</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($foto as $f): ?>
                            <tr>
                                <td><img src="../<?php echo htmlspecialchars($f['nama_file']); ?>" width="100"></td>
                                <td><?php echo htmlspecialchars($f['keterangan']); ?></td>
                                <td><?php echo $f['tanggal_upload']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal" 
                                            data-id="<?php echo $f['id']; ?>" 
                                            data-keterangan="<?php echo htmlspecialchars($f['keterangan']); ?>">
                                        Edit
                                    </button>
                                    <a href="foto.php?action=delete&id=<?php echo $f['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="foto.php?action=edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Keterangan Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="edit-keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const keterangan = button.getAttribute('data-keterangan');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-keterangan').value = keterangan;
    });
});
</script>

</body>
</html>
