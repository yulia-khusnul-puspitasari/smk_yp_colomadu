<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['siswa_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $mysqli->prepare("SELECT status, berkas FROM pendaftar WHERE id = ?");
$stmt->bind_param("i", $_SESSION['siswa_id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$status = $row['status'] ?? 'menunggu';
$berkas = $row['berkas'] ?? null;
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Status Pendaftaran - SPMB SMK Colomadu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #f8f9fa;
            margin: 0;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }
        .card-header h5 {
            margin: 0;
            font-weight: 700;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            transition: background 0.3s;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .dark-mode {
            background: #1c2526;
            color: #f8f9fa;
        }
        .dark-mode .card {
            background: #2c3e50;
            color: #f8f9fa;
        }
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Status Pendaftaran</h5>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['notification'])) { ?>
                    <div class="toast align-items-center text-white bg-<?php echo $_SESSION['notification']['type']; ?> border-0 position-fixed top-0 end-0 m-3" role="alert" data-bs-autohide="true" data-bs-delay="3000">
                        <div class="d-flex">
                            <div class="toast-body"><?php echo htmlspecialchars($_SESSION['notification']['message']); ?></div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <?php unset($_SESSION['notification']); ?>
                <?php } ?>
                <p><strong>Status:</strong> <span class="text-<?php echo $status == 'lulus' ? 'success' : ($status == 'tolak' ? 'danger' : 'warning'); ?>"><?php echo ucfirst($status); ?></span></p>
                <?php if ($berkas) { ?>
                    <p><strong>Berkas:</strong> <a href="uploads/<?php echo htmlspecialchars($berkas); ?>" class="text-primary" download>Download</a></p>
                <?php } else { ?>
                    <p><strong>Berkas:</strong> Belum diunggah. <a href="upload.php" class="text-primary">Unggah sekarang</a></p>
                <?php } ?>
                <a href="logout.php" class="btn btn-secondary mt-3">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
        <button class="btn btn-secondary" id="toggleDarkMode"><i class="fas fa-moon me-2"></i>Dark Mode</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
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