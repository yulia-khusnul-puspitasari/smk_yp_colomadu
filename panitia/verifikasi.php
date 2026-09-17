<?php
session_start();
require '../config/database.php';
require '../config/logging.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'panitia') {
    header('Location: login.php');
    exit;
}

// Set header untuk JSON response di AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=UTF-8');
}

// Ambil jumlah data per halaman dari session atau default 10
$per_page = isset($_SESSION['per_page']) ? (int)$_SESSION['per_page'] : 10;
if (isset($_GET['per_page']) && in_array($_GET['per_page'], [5, 10, 25, 50])) {
    $per_page = (int)$_GET['per_page'];
    $_SESSION['per_page'] = $per_page;
}

// Ambil halaman saat ini, minimal 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $per_page;

// Validasi per_page dan offset
$per_page = max(5, min(50, $per_page));
$offset = max(0, $offset);

// Handle pencarian
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$pendaftar = [];
$total = 0;
try {
    if ($search_query) {
        // Search di semua field pendaftar
        $query = '%' . $search_query . '%';
        $where = "WHERE nama LIKE :query OR nis LIKE :query OR nik LIKE :query OR jurusan LIKE :query OR nohp LIKE :query OR email LIKE :query OR asal_sekolah LIKE :query";
        
        // Hitung total untuk pagination
        $stmt = $db->prepare("SELECT COUNT(*) FROM pendaftar $where");
        $stmt->bindValue(':query', $query);
        $stmt->execute();
        $total = $stmt->fetchColumn();
        
        // Ambil data dengan binding LIMIT dan OFFSET
        $stmt = $db->prepare("SELECT id, nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, berkas, asal_sekolah, status, nohp, email FROM pendaftar $where ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':query', $query);
        $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $pendaftar = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Tanpa search, ambil semua data
        $stmt = $db->query("SELECT COUNT(*) FROM pendaftar");
        $total = $stmt->fetchColumn();
        
        $stmt = $db->prepare("SELECT id, nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, berkas, asal_sekolah, status, nohp, email FROM pendaftar ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $pendaftar = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $total_pages = ceil($total / $per_page);
} catch (PDOException $e) {
    $error = "Gagal mengambil data pendaftar: " . $e->getMessage();
    logError($error);
}

// Handle AJAX detail request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id = (int)$_POST['id'];
        $stmt = $db->prepare("SELECT id, nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, berkas, asal_sekolah, status, nohp, email FROM pendaftar WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($p) {
            echo json_encode([
                'status' => 'success',
                'data' => $p
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    } catch (PDOException $e) {
        logError("Gagal mengambil detail pendaftar: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat memuat detail'
        ]);
    }
    exit;
}

// Handle AJAX search request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['q'])) {
    try {
        $query = '%' . trim($_POST['q']) . '%';
        $per_page = isset($_POST['per_page']) && in_array($_POST['per_page'], [5, 10, 25, 50]) ? (int)$_POST['per_page'] : 10;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $page = max(1, $page);
        $offset = ($page - 1) * $per_page;

        $where = "WHERE nama LIKE :query OR nis LIKE :query OR nik LIKE :query OR jurusan LIKE :query OR nohp LIKE :query OR email LIKE :query OR asal_sekolah LIKE :query";
        
        // Hitung total
        $stmt = $db->prepare("SELECT COUNT(*) FROM pendaftar $where");
        $stmt->bindValue(':query', $query);
        $stmt->execute();
        $total = $stmt->fetchColumn();
        
        // Ambil data
        $stmt = $db->prepare("SELECT id, nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, berkas, asal_sekolah, status, nohp, email FROM pendaftar $where ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':query', $query);
        $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $pendaftar = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 'success',
            'data' => $pendaftar,
            'total_pages' => ceil($total / $per_page),
            'current_page' => $page
        ]);
    } catch (PDOException $e) {
        logError("Gagal mengambil data pencarian: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat mencari data'
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pendaftar - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar_panitia.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Verifikasi Pendaftar</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.</div>
                <?php endif; ?>
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama, NIS, NIK, jurusan, no HP, email, atau asal sekolah..." value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <label for="perPage" class="form-label">Tampilkan per halaman:</label>
                        <select id="perPage" class="form-select w-auto d-inline" onchange="window.location.href='verifikasi.php?per_page=' + this.value + '&page=1<?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>'">
                            <option value="5" <?php echo $per_page == 5 ? 'selected' : ''; ?>>5</option>
                            <option value="10" <?php echo $per_page == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="25" <?php echo $per_page == 25 ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?php echo $per_page == 50 ? 'selected' : ''; ?>>50</option>
                        </select>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>&per_page=<?php echo $per_page; ?><?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&per_page=<?php echo $per_page; ?><?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>&per_page=<?php echo $per_page; ?><?php echo $search_query ? '&q=' . urlencode($search_query) : ''; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div id="pendaftarList">
                    <?php if (empty($pendaftar)): ?>
                        <p>Tidak ada data pendaftar.</p>
                    <?php else: ?>
                        <?php foreach ($pendaftar as $p): ?>
                            <div class="card mb-3 pendaftar-card" data-id="<?php echo $p['id']; ?>">
                                <div class="card-body">
                                    <h5><?php echo htmlspecialchars($p['nama']); ?></h5>
                                    <p>NIS: <?php echo htmlspecialchars($p['nis']); ?></p>
                                    <p>NIK: <?php echo htmlspecialchars($p['nik']); ?></p>
                                    <button class="btn btn-primary btn-sm view-detail" data-id="<?php echo $p['id']; ?>">Lihat Detail</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pendaftar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Real-time search
            $('#searchInput').on('input', function() {
                const query = $(this).val();
                const perPage = $('#perPage').val();
                $.ajax({
                    url: 'verifikasi.php',
                    method: 'POST',
                    data: { q: query, per_page: perPage, page: 1 },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            renderPendaftar(response.data);
                            updatePagination(response.total_pages, response.current_page, query, perPage);
                        } else {
                            $('#pendaftarList').html('<p>' + response.message + '</p>');
                            updatePagination(0, 1, query, perPage);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#pendaftarList').html('<p>Gagal memuat data: ' + error + '. Silakan coba lagi.</p>');
                    }
                });
            });

            // View detail
            $(document).on('click', '.view-detail', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: 'verifikasi.php',
                    method: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const p = response.data;
                            const html = `
                                <p><strong>Nama:</strong> ${p.nama}</p>
                                <p><strong>NIS:</strong> ${p.nis}</p>
                                <p><strong>NIK:</strong> ${p.nik}</p>
                                <p><strong>Nama Orang Tua:</strong> ${p.nama_ortu}</p>
                                <p><strong>Pekerjaan Orang Tua:</strong> ${p.pekerjaan_ortu}</p>
                                <p><strong>Jurusan:</strong> ${p.jurusan}</p>
                                <p><strong>Asal Sekolah:</strong> ${p.asal_sekolah}</p>
                                <p><strong>Status:</strong> ${p.status}</p>
                                <p><strong>No HP:</strong> ${p.nohp}</p>
                                <p><strong>Email:</strong> ${p.email}</p>
                                <p><strong>Berkas:</strong> ${p.berkas ? p.berkas.split(',').map(b => `<a href="../${b}" download>${b.split('/').pop()}</a>`).join('<br>') : 'Tidak ada berkas.'}</p>
                            `;
                            $('#detailContent').html(html);
                            $('#detailModal').modal('show');
                        } else {
                            $('#detailContent').html('<p>' + response.message + '</p>');
                            $('#detailModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#detailContent').html('<p>Gagal memuat detail: ' + error + '. Silakan coba lagi.</p>');
                        $('#detailModal').modal('show');
                    }
                });
            });

            // Render pendaftar list
            function renderPendaftar(data) {
                if (!data || data.length === 0) {
                    $('#pendaftarList').html('<p>Tidak ada data pendaftar.</p>');
                    return;
                }
                let html = '';
                data.forEach(p => {
                    html += `
                        <div class="card mb-3 pendaftar-card" data-id="${p.id}">
                            <div class="card-body">
                                <h5>${p.nama}</h5>
                                <p>NIS: ${p.nis}</p>
                                <p>NIK: ${p.nik}</p>
                                <button class="btn btn-primary btn-sm view-detail" data-id="${p.id}">Lihat Detail</button>
                            </div>
                        </div>
                    `;
                });
                $('#pendaftarList').html(html);
            }

            // Update pagination
            function updatePagination(totalPages, currentPage, query, perPage) {
                let html = `
                    <ul class="pagination">
                        <li class="page-item ${currentPage <= 1 ? 'disabled' : ''}">
                            <a class="page-link" href="?page=${currentPage - 1}&per_page=${perPage}${query ? '&q=' + encodeURIComponent(query) : ''}">Previous</a>
                        </li>
                `;
                for (let i = 1; i <= totalPages; i++) {
                    html += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="?page=${i}&per_page=${perPage}${query ? '&q=' + encodeURIComponent(query) : ''}">${i}</a>
                        </li>
                    `;
                }
                html += `
                    <li class="page-item ${currentPage >= totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="?page=${currentPage + 1}&per_page=${perPage}${query ? '&q=' + encodeURIComponent(query) : ''}">Next</a>
                    </li>
                </ul>
                `;
                $('nav.pagination').html(html);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>