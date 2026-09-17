<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1E3A8A;">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">SMK YP Colomadu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>