<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['siswa_id'])) {
    header('Location: login_siswa.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
    $allowed_type = 'application/pdf';
    $max_size = 10 * 1024 * 1024; // 10MB
    $errors = [];
    $uploads = [];

    for ($i = 1; $i <= 3; $i++) {
        if (isset($_FILES['berkas' . $i]) && $_FILES['berkas' . $i]['error'] == 0) {
            $file = $_FILES['berkas' . $i];
            if ($file['type'] !== $allowed_type) {
                $errors[] = "File berkas $i harus berupa PDF!";
            } elseif ($file['size'] > $max_size) {
                $errors[] = "File berkas $i melebihi 10MB!";
            } else {
                $nis = $_SESSION['siswa_id'];
                $filename = $nis . '_berkas' . $i . '_' . time() . '.pdf';
                $target = 'uploads/' . $filename;
                if (move_uploaded_file($file['tmp_name'], $target)) {
                    $uploads[] = $filename;
                } else {
                    $errors[] = "Gagal mengunggah berkas $i!";
                }
            }
        }
    }

    if (empty($errors) && !empty($uploads)) {
        $stmt = $mysqli->prepare("UPDATE pendaftar SET berkas = ? WHERE id = ?");
        $berkas_list = implode(',', $uploads);
        $stmt->bind_param("si", $berkas_list, $_SESSION['siswa_id']);
        if ($stmt->execute()) {
            $_SESSION['notification'] = ['type' => 'success', 'message' => 'Berkas berhasil diunggah!'];
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menyimpan data berkas!'];
        }
        $stmt->close();
    } elseif (!empty($errors)) {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => implode('<br>', $errors)];
    }
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Upload Berkas - SPMB SMK Colomadu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            min-height: 100vh;
            background: radial-gradient(circle at center, #f0f4f8, #e0e7f0);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .upload-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
        }
        .upload-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 90%;
            max-width: 600px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease;
        }
        .upload-card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: linear-gradient(135deg, #1e3c72, #4a90e2);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }
        .card-header h5 {
            margin: 0;
            font-weight: 800;
            font-size: 1.8rem;
            text-transform: uppercase;
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 10px rgba(74, 144, 226, 0.4);
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72, #4a90e2);
            border: none;
            border-radius: 10px;
            padding: 0.9rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298, #63b3ed);
            transform: translateY(-2px);
        }
        .dark-mode {
            background: radial-gradient(circle at center, #1c2526, #2c3e50);
            color: #f8f9fa;
        }
        .dark-mode .upload-container {
            background: rgba(44, 62, 80, 0.9);
        }
        .dark-mode .upload-card {
            background: rgba(44, 62, 80, 0.95);
        }
        .dark-mode .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
        }
        .dark-mode .form-control {
            background: #34495e;
            color: #f8f9fa;
            border-color: #4a6278;
        }
        .dark-mode .btn-primary {
            background: linear-gradient(135deg, #2c3e50, #3498db);
        }
        .dark-mode .btn-primary:hover {
            background: linear-gradient(135deg, #34495e, #5dade2);
        }
        @media (max-width: 768px) {
            .upload-card {
                padding: 1rem;
            }
            .card-body {
                padding: 1.5rem;
            }
            .card-header h5 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <div class="upload-card">
            <div class="card-header">
                <h5><i class="fas fa-upload me-2"></i>Upload Berkas</h5>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['notification'])) { ?>
                    <div class="toast align-items-center text-white bg-<?php echo $_SESSION['notification']['type']; ?> border-0 position-fixed top-0 end-0 m-3" role="alert" data-bs-autohide="true" data-bs-delay="3000" style="z-index: 1050;">
                        <div class="d-flex">
                            <div class="toast-body"><?php echo htmlspecialchars($_SESSION['notification']['message']); ?></div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <?php unset($_SESSION['notification']); ?>
                <?php } ?>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Ijazah</label>
                        <input type="file" class="form-control" name="berkas1" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kartu Keluarga (KK)</label>
                        <input type="file" class="form-control" name="berkas2" accept="application/pdf" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Akta Lahir</label>
                        <input type="file" class="form-control" name="berkas3" accept="application/pdf" required>
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary w-100">Unggah Berkas</button>
                </form>
            </div>
        </div>
    </div>
    <button class="btn btn-secondary position-fixed bottom-0 end-0 m-3" id="toggleDarkMode">
        <i class="fas fa-moon me-2"></i>Ganti Mode
    </button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toastElList.forEach(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });

        document.getElementById('toggleDarkMode').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        });

        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>