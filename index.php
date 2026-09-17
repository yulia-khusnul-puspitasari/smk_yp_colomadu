<?php
include 'config/database.php';
$result_sekolah = $mysqli->query("SELECT * FROM sekolah LIMIT 1");
$sekolah = $result_sekolah->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SMK Yayasan Pendidikan Colomadu - Beranda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="SMK Yayasan Pendidikan Colomadu, Sekolah Kejuruan, Pendidikan Teknik">
    <meta name="description" content="Website resmi SMK Yayasan Pendidikan Colomadu, menyediakan informasi profil, kegiatan, dan penerimaan murid baru.">

    <!-- Favicon -->
    <link href="img/logo.jpeg" rel="icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            background: url('img/gedung.jpg') no-repeat center/cover;
            margin-bottom: 30px;
            width: 100%;
            max-width: 100vw;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(42, 82, 152, 0.7);
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        .hero-content {
            color: #fff;
            text-align: center;
            width: 100%;
        }
        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .hero-content p {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }
        .btn-primary {
            background-color: #2a5298;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1e3c72;
        }
        .btn-outline-light {
            color: #fff;
            border-color: #fff;
        }
        .btn-outline-light:hover {
            color: #2a5298;
            background-color: #fff;
        }
        .main-content {
            flex: 1 0 auto;
            padding: 0 20px;
            width: 100%;
            max-width: 100vw;
        }
        .section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            overflow-x: hidden;
        }
        .section h2 {
            color: #2a5298;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .video-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            background: #f8f9fa;
            border: none;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            background: #e9ecef;
        }
        .card i {
            font-size: 2rem;
            color: #2a5298;
            margin-bottom: 15px;
        }
        .card h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 0.9rem;
            color: #666;
        }
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .map-container {
            position: relative;
            padding-bottom: 30%; /* Ukuran maps tetap kecil */
            height: 0;
            overflow: hidden;
        }
        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .footer {
            background: #2a5298;
            color: #fff;
            padding: 10px 0; /* Kurangin padding biar nggak terlalu gede */
            width: 100%;
            flex-shrink: 0;
            max-width: 100vw;
            text-align: center;
        }
        .footer h2 {
            color: #fff;
            font-size: 1.2rem; /* Kurangin font size */
            margin-bottom: 5px;
        }
        @media (max-width: 992px) {
            .navbar-collapse {
                background: #ffffff;
                padding: 10px;
                border-radius: 5px;
            }
            .nav-link {
                margin-left: 0;
                padding: 8px 15px;
            }
            .hero {
                height: 300px;
            }
            .hero-content h1 {
                font-size: 1.8rem;
            }
            .hero-content p {
                font-size: 1rem;
            }
            .section {
                padding: 15px;
            }
            .content-grid, .video-grid {
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
            <a class="navbar-brand" href="index.php">
            <img src="img/logo.jpeg" style="height: 30px; margin-right: 10px;">
            SMK Yayasan Pendidikan Colomadu
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profil/sejarah.php">Sejarah</a></li>
                            <li><a class="dropdown-item" href="profil/profil.php">Identitas Sekolah</a></li>
                            <li><a class="dropdown-item" href="profil/visimisi.php">Visi dan Misi</a></li>
                            <li><a class="dropdown-item" href="profil/struktur.php">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="profil/fasilitas.php">Fasilitas</a></li>
                            <li><a class="dropdown-item" href="profil/alumni.php">Alumni</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="programDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Program Keahlian</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="jurusan/teknik-permesinan.php">Teknik Permesinan</a></li>
                            <li><a class="dropdown-item" href="jurusan/teknik-kendaraan-ringan.php">Teknik Kendaraan Ringan</a></li>
                            <li><a class="dropdown-item" href="jurusan/teknik-komputer-jaringan.php">Teknik Komputer Jaringan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="berita.php">Berita</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="galeriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Galeri</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="galeri/foto.php">Foto</a></li>
                            <li><a class="dropdown-item" href="galeri/video.php">Video</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ekstrakurikuler.php">Ekstrakurikuler</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="spmbDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">SPMB</a>
                        <ul class="dropdown-menu" data-bs-popper="true">
                            <li><a class="dropdown-item" href="daftar.php">Daftar Siswa</a></li>
                            <li><a class="dropdown-item" href="login_siswa.php">Login Siswa</a></li>
                          
                        
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
                <h1>Selamat Datang di SMK Yayasan Pendidikan Colomadu</h1>
                <p>Tempat mengejar cita-cita dengan pendidikan kejuruan berkualitas tinggi.</p>
                <a href="daftar.php" class="btn btn-primary">Daftar Sekarang</a>
                <a href="profil.php" class="btn btn-outline-light">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Main Content -->
    <div class="main-content">
        <!-- Brosur Section -->
        <div class="section">
            <h2>Brosur SMK Yayasan Pendidikan Colomadu</h2>
            <div class="content-grid">
                <div class="card">
                    <i class="fas fa-file-pdf"></i>
                    <h4>Unduh Brosur</h4>
                    <p>Informasi lengkap tentang sekolah dan program keahlian.</p>
                    <a href="brosur.pdf" class="btn btn-link" target="_blank">Unduh Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Informasi Section -->
        <div class="section">
            <h2>Informasi tentang SMK Yayasan Pendidikan Colomadu</h2>
            <div class="content-grid">
                <div class="card">
                    <i class="fas fa-info-circle"></i>
                    <h4>Profil Sekolah</h4>
                    <p>Tentang sejarah, visi, dan misi kami.</p>
                    <a href="profil.php" class="btn btn-link">Lihat Detail</a>
                </div>
                <div class="card">
                    <i class="fas fa-address-card"></i>
                    <h4>Kontak Kami</h4>
                    <p>Hubungi kami untuk informasi lebih lanjut.</p>
                    <a href="kontak.php" class="btn btn-link">Lihat Kontak</a>
                </div>
            </div>
        </div>

        <!-- Kegiatan Section -->
        <div class="section">
            <h2>Kegiatan tentang SMK Yayasan Pendidikan Colomadu</h2>
            <div class="content-grid">
                <div class="card">
                    <i class="fas fa-calendar-alt"></i>
                    <h4>Ekstrakurikuler</h4>
                    <p>Bergabung dengan kegiatan siswa kami.</p>
                    <a href="ekstrakurikuler.php" class="btn btn-link">Lihat Kegiatan</a>
                </div>
                <div class="card">
                    <i class="fas fa-trophy"></i>
                    <h4>Prestasi Siswa</h4>
                    <p>Capai prestasi bersama kami.</p>
                    <a href="berita.php" class="btn btn-link">Lihat Prestasi</a>
                </div>
            </div>
        </div>

        <!-- Video YouTube Section -->
        <div class="section">
            <h2>Video YouTube tentang SMK Yayasan Pendidikan Colomadu</h2>
            <div class="video-grid">
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <!-- Maps Section -->
        <div class="section">
            <h2>Maps SMK Yayasan Pendidikan Colomadu</h2>
            <div class="content-grid">
                <div class="map-container">
                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9999999999995!2d110.723!3d-7.567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8a8a8a8a8a8a%3A0x9b9b9b9b9b9b9b9b!2sSMK+Yayasan+Pendidikan+Colomadu!5e0!3m2!1sid!2sid!4v1627180800000" frameborder="0" allowfullscreen></iframe> -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.351615451719!2d110.7351044735759!3d-7.536576174388194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a1498caea8c1f%3A0x73cd3552a9f131b9!2sSMK%20YP%20COLOMADU!5e0!3m2!1sen!2sid!4v1753736914879!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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