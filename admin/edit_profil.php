<?php
session_start();
require '../config/database.php';

// Cek login admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$admin_id = $_SESSION['admin_id'];

// Ambil data admin
$stmt = $db->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek jika username sudah digunakan admin lain
    $stmt = $db->prepare("SELECT * FROM admin WHERE username = ? AND id != ?");
    $stmt->execute([$username, $admin_id]);
    if ($stmt->fetch()) {
        $error = "Username sudah digunakan oleh admin lain!";
    } else {
        $stmt = $db->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $password, $admin_id]);
        $success = "Profil berhasil diperbarui!";
        // Refresh data
        $stmt = $db->prepare("SELECT * FROM admin WHERE id = ?");
        $stmt->execute([$admin_id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Admin - SMK YP Colomadu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid min-vh-100 d-flex flex-column">
    <div class="row flex-grow-1">
        <?php include '../includes/sidebar_admin.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2>Edit Profil Admin</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php elseif (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" class="mt-3" style="max-width: 500px;">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password"
                           value="<?php echo htmlspecialchars($admin['password']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="dashboard.php" class="btn btn-secondary ms-2">← Kembali ke Dashboard</a>
            </form>
        </main>
    </div>

    <?php include '../includes/footer.php'; ?>
</div>

</body>
</html>
