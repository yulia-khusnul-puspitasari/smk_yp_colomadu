<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$panitia = $db->query("SELECT * FROM users WHERE role = 'panitia'")->fetchAll(PDO::FETCH_ASSOC);

// Tambahkan pengecekan untuk notifikasi error dari URL
$error = isset($_GET['error']) ? $_GET['error'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $error = "Username sudah digunakan!";
    } else {
        $stmt = $db->prepare("INSERT INTO users (username, password, role, nama) VALUES (?, ?, 'panitia', ?)");
        $stmt->execute([$username, $password, $nama]);
        header('Location: akun_panitia.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Coba hapus user panitia
        $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role = 'panitia'");
        $stmt->execute([$id]);
        header('Location: akun_panitia.php');
        exit;
    } catch (PDOException $e) {
        // Tangkap error foreign key dan redirect dengan pesan error
        if ($e->getCode() == '23000') {
            header('Location: akun_panitia.php?error=Gagal menghapus! Pastikan semua komentar oleh panitia ini sudah dihapus terlebih dahulu.');
            exit;
        } else {
            throw $e; // lempar error lain
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Akun Panitia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2>Kelola Akun Panitia</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" class="mb-3">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Panitia</button>
            </form>

            <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($panitia as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['nama']); ?></td>
                            <td><?php echo htmlspecialchars($p['username']); ?></td>
                            <td>
                                <a href="akun_panitia.php?action=delete&id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

</body>
</html>
