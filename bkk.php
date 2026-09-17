<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SMK Yayasan Pendidikan Colomadu - Galeri Foto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="SMK Yayasan Pendidikan Colomadu, Galeri Foto, Kegiatan Sekolah">
    <meta name="description" content="Lihat koleksi foto kegiatan di SMK Yayasan Pendidikan Colomadu.">

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
            background: url('img/foto-bg.jpg') no-repeat center/cover;
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
        .gallery-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .gallery-card {
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .gallery-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .gallery-card p {
            padding: 10px;
            font-size: 0.95rem;
            color: #555;
            text-align: center;
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
        .gallery-panel {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .gallery-card {
            width: 250px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .gallery-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .gallery-card p {
            padding: 10px;
            font-size: 14px;
            color: #333;
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
            .gallery-panel {
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
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="sejarah.php">Sejarah</a></li>
                            <li><a class="dropdown-item" href="profil.php">Identitas Sekolah</a></li>
                            <li><a class="dropdown-item" href="visimisi.php">Visi dan Misi</a></li>
                            <li><a class="dropdown-item" href="struktur.php">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="fasilitas.php">Fasilitas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="programDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Program Keahlian</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="teknik-permesinan.php">Teknik Permesinan</a></li>
                            <li><a class="dropdown-item" href="teknik-kendaraan-ringan.php">Teknik Kendaraan Ringan</a></li>
                            <li><a class="dropdown-item" href="teknik-komputer-jaringan.php">Teknik Komputer Jaringan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="berita.php">Berita</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="galeriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Galeri</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="foto.php">Foto</a></li>
                            <li><a class="dropdown-item" href="video.php">Video</a></li>
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
                <h1>Bursa Kerja Khusus</h1>
                <p>Lihat Info Bursa Kerja Khusus di SMK YP Colomadu</p>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-section">
            <h2>Bursa Kerja Khusus</h2>
            <div class="gallery-panel">
                <div class="gallery-card">
                    <img src="img/logo.jpeg" alt="Kegiatan Siswa">
                    <p>Info Bursa Kerja Khusus - 15 Juli 2025</p>
                </div>
                <div class="gallery-card">
                    <img src="img/logo.jpeg" alt="Lomba Kompetensi">
                    <p>Info Bursa Kerja Khusus - 10 Juli 2025</p>
                </div>
                <div class="gallery-card">
                    <img src="img/logo.jpeg" alt="Pelatihan Kerja">
                    <p>Info Bursa Kerja Khusus - 20 Juli 2025</p>
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