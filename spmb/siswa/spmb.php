<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPMB - SMK Yayasan Pendidikan Colomadu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="SPMB SMK Yayasan Pendidikan Colomadu" name="keywords">
    <meta content="Sistem Penerimaan Murid Baru SMK Yayasan Pendidikan Colomadu" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom CSS untuk Navbar dan Form -->
    <style>
        .navbar-nav {
            flex-wrap: nowrap; /* Pastikan menu tetap berjejer horizontal */
            max-width: 100%; /* Batasi lebar navbar-nav */
            overflow-x: auto; /* Tambah scroll horizontal kalau kepanjangan di mobile */
            white-space: nowrap; /* Pastikan teks gak wrap */
        }
        .navbar-nav .nav-link {
            padding: 0.5rem 0.6rem; /* Kompakkan padding */
            font-size: 0.9rem; /* Kecilkan font biar muat */
        }
        .navbar-nav .dropdown-menu {
            font-size: 0.85rem; /* Kecilkan font dropdown */
        }
        .navbar-brand {
            font-size: 1.5rem; /* Sesuaikan ukuran brand */
        }
        @media (max-width: 991px) {
            .navbar-nav {
                padding: 0.5rem; /* Padding kecil di mobile */
                overflow-x: auto; /* Scroll horizontal di mobile */
            }
            .navbar-nav .nav-link {
                font-size: 0.95rem; /* Font sedikit lebih besar di mobile */
                padding: 0.5rem; /* Padding lebih kecil */
            }
            .navbar-collapse {
                max-height: 70vh; /* Batasi tinggi menu collapse di mobile */
                overflow-y: auto; /* Scroll vertikal kalau terlalu panjang */
            }
        }
        @media (min-width: 992px) {
            .navbar-nav {
                margin-right: 1rem; /* Tambah margin kanan biar gak nempel tepi */
            }
        }
        .form-group { margin-bottom: 1rem; }
        .form-group label { font-weight: 600; }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border-radius: 4px; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <div class="container">
            <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>SMK Yayasan Pendidikan Colomadu</h2>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="index.php" class="nav-item nav-link">Beranda</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="sejarah.php" class="dropdown-item">Sejarah</a>
                            <a href="identitas.php" class="dropdown-item">Identitas Sekolah</a>
                            <a href="visimisi.php" class="dropdown-item">Visi dan Misi</a>
                            <a href="struktur.php" class="dropdown-item">Struktur Organisasi</a>
                            <a href="fasilitas.php" class="dropdown-item">Fasilitas</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Program Keahlian</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="teknik-permesinan.php" class="dropdown-item">Teknik Permesinan</a>
                            <a href="teknik-kendaraan-ringan.php" class="dropdown-item">Teknik Kendaraan Ringan</a>
                            <a href="teknik-komputer-jaringan.php" class="dropdown-item">Teknik Komputer Jaringan</a>
                        </div>
                    </div>
                    <a href="berita.php" class="nav-item nav-link">Berita</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Galeri</a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="foto.php" class="dropdown-item">Foto</a>
                            <a href="video.php" class="dropdown-item">Video</a>
                        </div>
                    </div>
                    <a href="ekstrakurikuler.php" class="nav-item nav-link">Ekstrakurikuler</a>
                    <a href="spmb.php" class="nav-item nav-link active">SPMB</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- SPMB Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">SPMB</h6>
                <h1 class="mb-5">Seleksi Penerimaan Murid Baru</h1>
            </div>
            <div class="row g-4">
                <!-- Siswa -->
                <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <h5 class="mb-3">Siswa</h5>
                            <button onclick="showForm('register')" class="btn btn-primary py-2 px-4 mb-2">Daftar</button>
                            <button onclick="showForm('login')" class="btn btn-primary py-2 px-4 mb-2">Login</button>
                            <button onclick="showForm('upload')" class="btn btn-primary py-2 px-4 mb-2">Upload Berkas</button>
                            <button onclick="showForm('status')" class="btn btn-primary py-2 px-4">Cek Status</button>

                            <!-- Form Pendaftaran -->
                            <div id="register-form" class="hidden mt-4">
                                <h4 class="mb-3">Form Pendaftaran</h4>
                                <form action="spmb.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" name="alamat" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" name="nik" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Orang Tua</label>
                                        <input type="text" name="nama_ortu" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Pekerjaan Orang Tua</label>
                                        <input type="text" name="pekerjaan_ortu" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Jurusan</label>
                                        <select name="jurusan" class="form-control" required>
                                            <option value="">Pilih Jurusan</option>
                                            <option value="tp">Teknik Permesinan</option>
                                            <option value="tkr">Teknik Kendaraan Ringan</option>
                                            <option value="tkj">Teknik Komputer Jaringan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="register" class="btn btn-primary">Daftar</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Form Login -->
                            <div id="login-form" class="hidden mt-4">
                                <h4 class="mb-3">Form Login</h4>
                                <form action="spmb.php" method="POST">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Form Upload -->
                            <div id="upload-form" class="hidden mt-4">
                                <h4 class="mb-3">Upload Berkas</h4>
                                <form action="spmb.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Upload Dokumen (Ijazah, KK, Akta Lahir)</label>
                                        <input type="file" name="dokumen[]" class="form-control" multiple accept=".pdf,.jpg,.png" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Form Status -->
                            <div id="status-form" class="hidden mt-4">
                                <h4 class="mb-3">Cek Status Berkas</h4>
                                <p>Status: <span id="status-text">Belum diunggah</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin -->
                <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <h5 class="mb-3">Admin/Panitia</h5>
                            <button onclick="showForm('admin-login')" class="btn btn-primary py-2 px-4 mb-2">Login</button>
                            <button onclick="showForm('admin-register')" class="btn btn-primary py-2 px-4 mb-2">Register Admin Baru</button>
                            <button onclick="showForm('admin-documents')" class="btn btn-primary py-2 px-4 mb-2">Lihat Berkas</button>
                            <button onclick="showForm('admin-update')" class="btn btn-primary py-2 px-4 mb-2">Update Status</button>
                            <button onclick="showForm('admin-download')" class="btn btn-primary py-2 px-4">Download Berkas</button>

                            <!-- Admin Login -->
                            <div id="admin-login-form" class="hidden mt-4">
                                <h4 class="mb-3">Login Admin</h4>
                                <form action="spmb.php" method="POST">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="admin_email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="admin_password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="admin_login" class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Admin Register -->
                            <div id="admin-register-form" class="hidden mt-4">
                                <h4 class="mb-3">Register Admin Baru</h4>
                                <form action="spmb.php" method="POST">
                                    <div class="form-group">
                                        <label>Nama Admin</label>
                                        <input type="text" name="admin_nama" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="admin_email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="admin_password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="admin_register" class="btn btn-primary">Register</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Admin Documents -->
                            <div id="admin-documents-form" class="hidden mt-4">
                                <h4 class="mb-3">Daftar Berkas</h4>
                                <p>Daftar berkas akan ditampilkan di sini (perlu database).</p>
                            </div>

                            <!-- Admin Update Status -->
                            <div id="admin-update-form" class="hidden mt-4">
                                <h4 class="mb-3">Update Status Berkas</h4>
                                <form action="spmb.php" method="POST">
                                    <div class="form-group">
                                        <label>ID Pendaftar</label>
                                        <input type="text" name="pendaftar_id" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="valid">Valid</option>
                                            <option value="invalid">Tidak Valid</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Admin Download -->
                            <div id="admin-download-form" class="hidden mt-4">
                                <h4 class="mb-3">Download Berkas</h4>
                                <p>Fitur download berkas (perlu database dan storage).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SPMB Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Tautan Cepat</h4>
                    <a class="btn btn-link" href="sejarah.php">Sejarah</a>
                    <a class="btn btn-link" href="visimisi.php">Visi dan Misi</a>
                    <a class="btn btn-link" href="fasilitas.php">Fasilitas</a>
                    <a class="btn btn-link" href="spmb.php">SPMB</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Kontak</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. Colomadu, Karanganyar, Jawa Tengah</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+62 123 456 7890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@smkyayasan.ac.id</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Galeri</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dapatkan informasi terbaru dari kami.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Email Anda">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Daftar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        © <a class="border-bottom" href="#">SMK Yayasan Pendidikan Colomadu</a>, All Right Reserved.
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="index.php">Beranda</a>
                            <a href="spmb.php">SPMB</a>
                            <a href="ekstrakurikuler.php">Ekstrakurikuler</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        function showForm(formId) {
            document.querySelectorAll('.mt-4').forEach(form => form.classList.add('hidden'));
            document.getElementById(`${formId}-form`).classList.remove('hidden');
        }
    </script>
</body>
</html>