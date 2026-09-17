<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar" style="background-color: #1E3A8A;" id="sidebar">
    <div class="position-sticky pt-3">
        <h4 class="text-white text-center">SMK YP COLOMADU</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'verifikasi.php' ? 'active' : ''; ?>" href="verifikasi.php">Verifikasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'status.php' ? 'active' : ''; ?>" href="status.php">Status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'download.php' ? 'active' : ''; ?>" href="download.php">Download</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'persyaratan.php' ? 'active' : ''; ?>" href="persyaratan.php">Persyaratan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'logout.php' ? 'active' : ''; ?>" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>