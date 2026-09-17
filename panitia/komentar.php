<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'panitia') {
    header('Location: login.php');
    exit;
}

$pendaftar = $db->query("SELECT * FROM pendaftar ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pendaftar_id = $_POST['pendaftar_id'];
    $komentar = $_POST['komentar'];
    $panitia_id = $_SESSION['user_id'];
    
    $stmt = $db->prepare("INSERT INTO komentar (pendaftar_id, panitia_id, komentar) VALUES (?, ?, ?)");
    $stmt->execute([$pendaftar_id, $panitia_id, $komentar]);
    header('Location: komentar.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar Pendaftar - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_panitia.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Komentar Pendaftar</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendaftar as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['nama']); ?></td>
                                <td>
                                    <?php
                                    $komentar = $db->prepare("SELECT * FROM komentar WHERE pendaftar_id = ? ORDER BY timestamp DESC");
                                    $komentar->execute([$p['id']]);
                                    foreach ($komentar->fetchAll(PDO::FETCH_ASSOC) as $k):
                                    ?>
                                        <p><?php echo htmlspecialchars($k['komentar']); ?> <small>(<?php echo $k['timestamp']; ?>)</small></p>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="pendaftar_id" value="<?php echo $p['id']; ?>">
                                        <textarea name="komentar" class="form-control mb-2" rows="3" required></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah Komentar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>