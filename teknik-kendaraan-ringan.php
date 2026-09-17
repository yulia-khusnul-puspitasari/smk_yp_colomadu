<?php
include 'config/database.php'; // naik ke root
if (!$mysqli) {
    die("Koneksi database gagal.");
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SMK Yayasan Pendidikan Colomadu - Teknik Kendaraan Ringan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="SMK Yayasan Pendidikan Colomadu, Teknik Kendaraan Ringan, Pendidikan Kejuruan">
    <meta name="description" content="Pelajari program keahlian Teknik Kendaraan Ringan di SMK Yayasan Pendidikan Colomadu.">

    <!-- Favicon -->
    <link href="img/logo.jpeg" rel="icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fa;
            color: #333;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .navbar {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }
        .navbar-brand {
            color: #2a5298;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .navbar-brand i {
            color: #2a5298;
        }
        .nav-link {
            color: #2a5298 !important;
            font-weight: 500;
            margin-left: 15px;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #2a5298 !important;
        }
        .dropdown-menu {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-width: 250px;
            padding: 5px 0;
        }
        .dropdown-item {
            color: #2a5298 !important;
            transition: background 0.3s;
        }
        .dropdown-item:hover {
            background: #f8f9fa !important;
            color: #2a5298 !important;
        }
        .dropdown-menu[data-bs-popper] {
            left: auto !important;
            right: 0;
            transform: translateX(-20px) !important;
        }
        .hero {
            position: relative;
            height: 500px;
            overflow: hidden;
            background: url('img/teknik-kendaraan-ringan-bg.jpg') no-repeat center/cover;
            margin-bottom: 40px;
            width: 100%;
            max-width: 100vw;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(42, 82, 152, 0.85), rgba(30, 60, 114, 0.7));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
        }
        .hero-content {
            color: #fff;
            text-align: center;
            max-width: 900px;
        }
        .hero-content h1 {
            font-size: 3.2rem;
            font-weight: 700;
            font-family: 'Roboto Slab', serif;
            margin-bottom: 15px;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            animation: fadeInUp 1s ease;
        }
        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.9;
            animation: fadeInUp 1.2s ease;
        }
        .main-content {
            flex: 1 0 auto;
            padding: 0 30px;
            width: 100%;
            max-width: 100vw;
        }
        .dashboard-section {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
            overflow-x: hidden;
        }
        .dashboard-section h2 {
            color: #2a5298;
            font-size: 2.2rem;
            font-weight: 600;
            font-family: 'Roboto Slab', serif;
            margin-bottom: 20px;
            position: relative;
        }
        .dashboard-section h2::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #2a5298;
            transition: width 0.3s ease;
        }
        .dashboard-section:hover h2::after {
            width: 70px;
        }
        .program-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .program-card {
            background: #f8f9fa;
            border-left: 4px solid #2a5298;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .program-card:hover {
            background: #e9ecef;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .program-card i {
            font-size: 2rem;
            color: #2a5298;
            margin-bottom: 10px;
        }
        .program-card h4 {
            color: #2a5298;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .program-card p {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.6;
        }
        .footer {
            background: #2a5298;
            color: #fff;
            padding: 15px 0;
            width: 100%;
            flex-shrink: 0;
            max-width: 100vw;
            text-align: center;
        }
        .footer h2 {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .footer p {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 992px) {
            .navbar {
                padding: 10px 20px;
            }
            .nav-link {
                margin-left: 0;
                padding: 8px 15px;
            }
            .hero {
                height: 300px;
            }
            .hero-content h1 {
                font-size: 2rem;
            }
            .hero-content p {
                font-size: 1rem;
            }
            .dashboard-section {
                padding: 20px;
            }
            .program-panel {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar/nav.php' ?>
  <!-- Navbar Start -->
<!-- <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="../img/logo.jpeg" style="height: 30px; margin-right: 10px;">
            SMK Yayasan Pendidikan Colomadu
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="../sejarah.php">Sejarah</a></li>
                        <li><a class="nav-link" href="../profil.php">Identitas Sekolah</a></li>
                        <li><a class="nav-link" href="../visimisi.php">Visi dan Misi</a></li>
                        <li><a class="nav-link" href="../struktur.php">Struktur Organisasi</a></li>
                        <li><a class="nav-link" href="../fasilitas.php">Fasilitas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="programDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Program Keahlian</a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link active" href="teknik-permesinan.php">Teknik Permesinan</a></li>
                        <li><a class="nav-link" href="teknik-kendaraan-ringan.php">Teknik Kendaraan Ringan</a></li>
                        <li><a class="nav-link" href="teknik-komputer-jaringan.php">Teknik Komputer Jaringan</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../berita.php">Berita</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="galeriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Galeri</a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="../foto.php">Foto</a></li>
                        <li><a class="nav-link" href="../video.php">Video</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../ekstrakurikuler.php">Ekstrakurikuler</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="spmbDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">SPMB</a>
                    <ul class="dropdown-menu" data-bs-popper="true">
                        <li><a class="nav-link" href="../daftar.php">Daftar Siswa</a></li>
                        <li><a class="nav-link" href="../login_siswa.php">Login Siswa</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> -->
<!-- Navbar End -->

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Teknik Kendaraan Ringan</h1>
                <p>Keunggulan keahlian dalam perawatan dan perbaikan kendaraan ringan.</p>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-section">
            <h2>Program Keahlian Teknik Kendaraan Ringan</h2>
            <div class="program-panel">
                <div class="program-card">
                    <i class="fas fa-car"></i>
                    <h4>Dasar Perawatan Kendaraan</h4>
                    <p>Pelajari perawatan rutin dan diagnosa masalah kendaraan ringan.</p>
                </div>
                <div class="program-card">
                    <i class="fas fa-wrench"></i>
                    <h4>Perbaikan Mesin</h4>
                    <p>Training perbaikan mesin kendaraan dengan alat modern.</p>
                </div>
                <div class="program-card">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Sistem Keamanan Kendaraan</h4>
                    <p>Belajar sistem keamanan dan teknologi kendaraan terkini.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content End -->

    <!-- Footer Start -->
    <footer class="footer">
        <h2>© SMK Yayasan Pendidikan Colomadu</h2>
        <p>© 2025 | Seluruh hak cipta dilindungi. Terima kasih atas kunjungan Anda, mari wujudkan masa depan cerah bersama kami.</p>
    </footer>
    <!-- Footer End -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>