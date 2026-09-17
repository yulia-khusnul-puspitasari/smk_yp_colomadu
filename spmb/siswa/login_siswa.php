<?php
session_start();
include '../../config/koneksi.php';

if (isset($_SESSION['siswa_id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $nis = trim($_POST['nis']);
    $stmt = $mysqli->prepare("SELECT id FROM pendaftar WHERE nis = ?");
    $stmt->bind_param("s", $nis);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['siswa_id'] = $result->fetch_assoc()['id'];
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Login berhasil!'];
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'NIS tidak ditemukan!'];
    }
    $stmt->close();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login - SPMB SMK Colomadu</title>
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
        .login-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 90%;
            max-width: 600px; /* Batas maksimum opsional, bisa dihapus kalau mau full */
            padding: 2rem 3rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            background: linear-gradient(135deg, #1e3c72, #4a90e2);
            color: white;
            padding: 2.5rem;
            text-align: center;
            border-radius: 20px 20px 0 0;
        }
        .card-header h5 {
            margin: 0;
            font-weight: 800;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .card-body {
            padding: 3rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72, #4a90e2);
            border: none;
            border-radius: 10px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298, #63b3ed);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 1.1rem 1.5rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 10px rgba(74, 144, 226, 0.4);
            outline: none;
        }
        .input-group-text {
            background: #f8f9fa;
            border: none;
            border-radius: 10px 0 0 10px;
            padding: 1.1rem 1.5rem;
            transition: background 0.3s ease;
        }
        .input-group-text i {
            color: #1e3c72;
            transition: color 0.3s ease;
            font-size: 1.2rem;
        }
        .input-group:hover .input-group-text i {
            color: #4a90e2;
        }
        .floating-label {
            position: relative;
            margin-bottom: 2rem;
        }
        .floating-label label {
            position: absolute;
            top: 50%;
            left: 50px;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            color: #6c757d;
            pointer-events: none;
            font-size: 1.1rem;
        }
        .floating-label input:not(:placeholder-shown) + label {
            top: -15px;
            font-size: 0.85rem;
            color: #4a90e2;
            background: white;
            padding: 0 8px;
        }
        .dark-mode {
            background: radial-gradient(circle at center, #1c2526, #2c3e50);
            color: #f8f9fa;
        }
        .dark-mode .login-container {
            background: rgba(44, 62, 80, 0.9);
        }
        .dark-mode .login-card {
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
        .dark-mode .input-group-text {
            background: #4a6278;
            color: #f8f9fa;
        }
        .dark-mode .input-group-text i {
            color: #3498db;
        }
        .dark-mode .floating-label label {
            color: #bdc3c7;
        }
        .dark-mode .floating-label input:not(:placeholder-shown) + label {
            color: #3498db;
            background: #2c3e50;
        }
        .dark-mode .btn-primary {
            background: linear-gradient(135deg, #2c3e50, #3498db);
        }
        .dark-mode .btn-primary:hover {
            background: linear-gradient(135deg, #34495e, #5dade2);
        }
        .dark-mode .btn-secondary {
            background: #7f8c8d;
        }
        .dark-mode .btn-secondary:hover {
            background: #95a5a6;
        }
        @media (max-width: 768px) {
            .login-card {
                padding: 1.5rem;
            }
            .card-body {
                padding: 2rem;
            }
            .card-header h5 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card-header">
                <h5><i class="fas fa-user-shield me-2"></i>Login Siswa</h5>
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
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="floating-label mb-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" name="nis" placeholder="Masukkan NIS" required>
                            <label for="nis"></label>
                        </div>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                    <a href="daftar.php" class="btn btn-secondary w-100">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
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