<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['siswa_id'])) {
    header('Location: login_siswa.php');
    exit;
}

$stmt = $mysqli->prepare("SELECT nama, status FROM pendaftar WHERE id = ?");
$stmt->bind_param("i", $_SESSION['siswa_id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$nama = $row['nama'] ?? '';
$status = $row['status'] ?? 'menunggu';
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pengumuman - SPMB SMK Colomadu</title>
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
        .announcement-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
        }
        .announcement-card {
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
        .announcement-card:hover {
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
            text-align: center;
        }
        .status-text {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 1rem;
        }
        .btn-back {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 0.9rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-top: 1.5rem;
        }
        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .dark-mode {
            background: radial-gradient(circle at center, #1c2526, #2c3e50);
            color: #f8f9fa;
        }
        .dark-mode .announcement-container {
            background: rgba(44, 62, 80, 0.9);
        }
        .dark-mode .announcement-card {
            background: rgba(44, 62, 80, 0.95);
        }
        .dark-mode .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
        }
        .dark-mode .btn-back {
            background: #7f8c8d;
            color: #f8f9fa;
        }
        .dark-mode .btn-back:hover {
            background: #95a5a6;
        }
        @media (max-width: 768px) {
            .announcement-card {
                padding: 1rem;
            }
            .card-body {
                padding: 1.5rem;
            }
            .card-header h5 {
                font-size: 1.4rem;
            }
            .status-text {
                font-size: 1.2rem;
            }
            .btn-back {
                padding: 0.7rem 1.2rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="announcement-container">
        <div class="announcement-card">
            <div class="card-header">
                <h5><i class="fas fa-bullhorn me-2"></i>Pengumuman</h5>
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
                <p>Selamat, <?php echo htmlspecialchars($nama); ?>!</p>
                <p class="status-text text-<?php echo $status == 'lulus' ? 'success' : ($status == 'tolak' ? 'danger' : 'warning'); ?>">
                    Status Anda: <?php echo ucfirst($status); ?>
                </p>
                <?php if ($status == 'menunggu') { ?>
                    <p>Harap tunggu verifikasi dari panitia.</p>
                <?php } elseif ($status == 'lulus') { ?>
                    <p>Selamat! Anda diterima di SMK Colomadu.</p>
                <?php } else { ?>
                    <p>Maaf, Anda tidak diterima. Silakan coba lagi tahun depan.</p>
                <?php } ?>
                <a href="dashboard.php" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard</a>
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