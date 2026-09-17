<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
try {
    $pendaftaran = $db->prepare("SELECT * FROM pendaftaran WHERE user_id = ?");
    $pendaftaran->execute([$user_id]);
    $existing = $pendaftaran->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Terjadi kesalahan saat mengambil data pendaftaran: " . $e->getMessage();
    file_put_contents('../logs/error.log', date('Y-m-d H:i:s') . ': ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
}

// Cek kolom kritis di pendaftaran dan pendaftar
$check_columns = $db->query("SHOW COLUMNS FROM pendaftaran LIKE 'nohp'")->fetch();
if (!$check_columns) {
    $error = "Kolom 'nohp' tidak ditemukan di tabel pendaftaran. Hubungi admin!";
}
$check_columns = $db->query("SHOW COLUMNS FROM pendaftaran LIKE 'email'")->fetch();
if (!$check_columns) {
    $error = "Kolom 'email' tidak ditemukan di tabel pendaftaran. Hubungi admin!";
}
$check_columns = $db->query("SHOW COLUMNS FROM pendaftaran LIKE 'alamat'")->fetch();
if (!$check_columns) {
    $error = "Kolom 'alamat' tidak ditemukan di tabel pendaftaran. Hubungi admin!";
}
$check_columns = $db->query("SHOW COLUMNS FROM pendaftar LIKE 'nohp'")->fetch();
if (!$check_columns) {
    $error = "Kolom 'nohp' tidak ditemukan di tabel pendaftar. Hubungi admin!";
}
$check_columns = $db->query("SHOW COLUMNS FROM pendaftar LIKE 'email'")->fetch();
if (!$check_columns) {
    $error = "Kolom 'email' tidak ditemukan di tabel pendaftar. Hubungi admin!";
}

$persyaratan = $db->query("SELECT * FROM persyaratan")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($error)) {
    $nik = trim($_POST['nik']);
    $alamat = trim($_POST['alamat']);
    $nama_ortu = trim($_POST['nama_ortu']);
    $pekerjaan_ortu = trim($_POST['pekerjaan_ortu']);
    $jurusan = $_POST['jurusan'];
    $nama = trim($_POST['nama']);
    $nis = trim($_POST['nis']);
    $asal_sekolah = trim($_POST['asal_sekolah']);
    $nohp = trim($_POST['nohp']);
    $email = trim($_POST['email']);
    
    if (empty($nik) || empty($alamat) || empty($nama_ortu) || empty($pekerjaan_ortu) || empty($jurusan) || empty($nama) || empty($nis) || empty($asal_sekolah) || empty($nohp) || empty($email)) {
        $error = "Semua kolom wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif (!preg_match('/^\d{16}$/', $nik)) {
        $error = "NIK harus 16 digit angka!";
    } elseif (!preg_match('/^\d{10,15}$/', $nohp)) {
        $error = "Nomor HP harus 10-15 digit angka!";
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM pendaftar WHERE nik = ? AND user_id != ?");
            $stmt->execute([$nik, $user_id]);
            if ($stmt->fetch()) {
                $error = "NIK '$nik' sudah terdaftar oleh pendaftar lain!";
            } else {
                $stmt = $db->prepare("SELECT * FROM pendaftar WHERE email = ? AND user_id != ?");
                $stmt->execute([$email, $user_id]);
                if ($stmt->fetch()) {
                    $error = "Email '$email' sudah terdaftar oleh pendaftar lain!";
                } else {
                    $berkas_paths = $existing ? explode(',', $existing['berkas_path']) : [];
                    foreach ($persyaratan as $p) {
                        if ($p['wajib'] && isset($_FILES['berkas_' . $p['id']]) && $_FILES['berkas_' . $p['id']]['error'] == 0) {
                            if ($_FILES['berkas_' . $p['id']]['type'] == 'application/pdf') {
                                $berkas_path = 'uploads/berkas/' . time() . '_' . $_FILES['berkas_' . $p['id']]['name'];
                                move_uploaded_file($_FILES['berkas_' . $p['id']]['tmp_name'], '../' . $berkas_path);
                                $berkas_paths[] = $berkas_path;
                            } else {
                                $error = "Berkas untuk '{$p['nama_persyaratan']}' harus berformat PDF!";
                                break;
                            }
                        }
                    }
                    
                    if (!isset($error)) {
                        $berkas_path = implode(',', $berkas_paths);
                        if ($existing) {
                            $stmt = $db->prepare("UPDATE pendaftaran SET nik = ?, alamat = ?, nama_ortu = ?, pekerjaan_ortu = ?, jurusan = ?, berkas_path = ?, nohp = ?, email = ? WHERE user_id = ?");
                            $stmt->execute([$nik, $alamat, $nama_ortu, $pekerjaan_ortu, $jurusan, $berkas_path, $nohp, $email, $user_id]);
                            
                            $stmt = $db->prepare("UPDATE pendaftar SET nama = ?, nis = ?, nik = ?, nama_ortu = ?, pekerjaan_ortu = ?, jurusan = ?, berkas = ?, asal_sekolah = ?, nohp = ?, email = ? WHERE user_id = ?");
                            $stmt->execute([$nama, $nis, $nik, $nama_ortu, $pekerjaan_ortu, $jurusan, $berkas_path, $asal_sekolah, $nohp, $email, $user_id]);
                        } else {
                            $stmt = $db->prepare("INSERT INTO pendaftaran (user_id, nik, alamat, nama_ortu, pekerjaan_ortu, jurusan, berkas_path, nohp, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->execute([$user_id, $nik, $alamat, $nama_ortu, $pekerjaan_ortu, $jurusan, $berkas_path, $nohp, $email]);
                            
                            $stmt = $db->prepare("INSERT INTO pendaftar (user_id, nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, berkas, asal_sekolah, status, nohp, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu', ?, ?)");
                            $stmt->execute([$user_id, $nama, $nis, $nik, $nama_ortu, $pekerjaan_ortu, $jurusan, $berkas_path, $asal_sekolah, $nohp, $email]);
                        }
                        $_SESSION['success'] = "Pendaftaran berhasil disimpan!";
                        header('Location: dashboard.php');
                        exit;
                    }
                }
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan sistem: " . $e->getMessage();
            file_put_contents('../logs/error.log', date('Y-m-d H:i:s') . ': ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }
}

if (isset($_POST['delete'])) {
    try {
        $stmt = $db->prepare("DELETE FROM pendaftaran WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $stmt = $db->prepare("DELETE FROM pendaftar WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['success'] = "Pendaftaran berhasil dihapus!";
        header('Location: formulir.php');
        exit;
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan saat menghapus: " . $e->getMessage();
        file_put_contents('../logs/error.log', date('Y-m-d H:i:s') . ': ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_siswa.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Formulir Pendaftaran</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama) : ($existing['nama'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" value="<?php echo isset($nis) ? htmlspecialchars($nis) : ($existing['nis'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo isset($nik) ? htmlspecialchars($nik) : ($existing['nik'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nohp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="nohp" name="nohp" value="<?php echo isset($nohp) ? htmlspecialchars($nohp) : ($existing['nohp'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ($existing['email'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                        <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="<?php echo isset($asal_sekolah) ? htmlspecialchars($asal_sekolah) : ($existing['asal_sekolah'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required><?php echo isset($alamat) ? htmlspecialchars($alamat) : ($existing['alamat'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="nama_ortu" class="form-label">Nama Orang Tua</label>
                        <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" value="<?php echo isset($nama_ortu) ? htmlspecialchars($nama_ortu) : ($existing['nama_ortu'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan_ortu" class="form-label">Pekerjaan Orang Tua</label>
                        <input type="text" class="form-control" id="pekerjaan_ortu" name="pekerjaan_ortu" value="<?php echo isset($pekerjaan_ortu) ? htmlspecialchars($pekerjaan_ortu) : ($existing['pekerjaan_ortu'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <select class="form-select" id="jurusan" name="jurusan" required>
                            <option value="TKJ" <?php echo (isset($jurusan) ? $jurusan : ($existing['jurusan'] ?? '')) == 'TKJ' ? 'selected' : ''; ?>>Teknik Komputer dan Jaringan</option>
                            <option value="TKR" <?php echo (isset($jurusan) ? $jurusan : ($existing['jurusan'] ?? '')) == 'TKR' ? 'selected' : ''; ?>>Teknik Kendaraan Ringan</option>
                            <option value="TP" <?php echo (isset($jurusan) ? $jurusan : ($existing['jurusan'] ?? '')) == 'TP' ? 'selected' : ''; ?>>Teknik Permesinan</option>
                        </select>
                    </div>
                    <?php foreach ($persyaratan as $p): ?>
                        <div class="mb-3">
                            <label for="berkas_<?php echo $p['id']; ?>" class="form-label"><?php echo htmlspecialchars($p['nama_persyaratan']); ?> <?php echo $p['wajib'] ? '(Wajib)' : ''; ?></label>
                            <input type="file" class="form-control" id="berkas_<?php echo $p['id']; ?>" name="berkas_<?php echo $p['id']; ?>" accept="application/pdf" <?php echo $p['wajib'] ? 'required' : ''; ?>>
                            <small><?php echo htmlspecialchars($p['deskripsi'] ?? ''); ?></small>
                            <?php if ($existing && in_array($p['nama_persyaratan'], explode(',', $existing['berkas_path']))): ?>
                                <small class="text-success">Berkas sudah diupload: <?php echo htmlspecialchars($p['nama_persyaratan']); ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary"><?php echo $existing ? 'Update' : 'Daftar'; ?></button>
                    <?php if ($existing): ?>
                        <form method="POST" class="d-inline">
                            <button type="submit" name="delete" class="btn btn-danger">Hapus Pendaftaran</button>
                        </form>
                    <?php endif; ?>
                </form>
            </main>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>