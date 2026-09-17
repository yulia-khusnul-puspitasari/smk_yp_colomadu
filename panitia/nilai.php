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
    $nilai_tes = $_POST['nilai_tes'];
    
    $stmt = $db->prepare("SELECT * FROM nilai WHERE pendaftar_id = ?");
    $stmt->execute([$pendaftar_id]);
    if ($stmt->fetch()) {
        $stmt = $db->prepare("UPDATE nilai SET nilai_tes = ? WHERE pendaftar_id = ?");
        $stmt->execute([$nilai_tes, $pendaftar_id]);
    } else {
        $stmt = $db->prepare("INSERT INTO nilai (pendaftar_id, nilai_tes) VALUES (?, ?)");
        $stmt->execute([$pendaftar_id, $nilai_tes]);
    }
    
    $stmt = $db->prepare("UPDATE pendaftar SET nilai = ? WHERE id = ?");
    $stmt->execute([$nilai_tes, $pendaftar_id]);
    header('Location: nilai.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include '../includes/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_panitia.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Input Nilai</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendaftar as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['nama']); ?></td>
                                <td><?php echo htmlspecialchars($p['jurusan']); ?></td>
                                <td><?php echo $p['nilai'] ?? '-'; ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="pendaftar_id" value="<?php echo $p['id']; ?>">
                                        <input type="number" name="nilai_tes" class="form-control d-inline w-auto" min="0" max="100" required>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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