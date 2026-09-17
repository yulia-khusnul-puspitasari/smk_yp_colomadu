<?php
require '../config/database.php';
require '../config/logging.php';

header('Content-Type: text/html; charset=UTF-8');

try {
    if (isset($_GET['id'])) {
        // Detail pendaftar
        $id = (int)$_GET['id'];
        $stmt = $db->prepare("SELECT p.*, u.nama AS nama_user FROM pendaftar p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($p) {
            echo '<p><strong>Nama:</strong> ' . htmlspecialchars($p['nama']) . '</p>';
            echo '<p><strong>NIS:</strong> ' . htmlspecialchars($p['nis']) . '</p>';
            echo '<p><strong>NIK:</strong> ' . htmlspecialchars($p['nik']) . '</p>';
            echo '<p><strong>No HP:</strong> ' . htmlspecialchars($p['nohp']) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($p['email']) . '</p>';
            echo '<p><strong>Asal Sekolah:</strong> ' . htmlspecialchars($p['asal_sekolah']) . '</p>';
            echo '<p><strong>Nama Orang Tua:</strong> ' . htmlspecialchars($p['nama_ortu']) . '</p>';
            echo '<p><strong>Pekerjaan Orang Tua:</strong> ' . htmlspecialchars($p['pekerjaan_ortu']) . '</p>';
            echo '<p><strong>Jurusan:</strong> ' . htmlspecialchars($p['jurusan']) . '</p>';
            echo '<p><strong>Berkas:</strong> ';
            if ($p['berkas']) {
                foreach (explode(',', $p['berkas']) as $berkas) {
                    echo '<a href="../' . htmlspecialchars($berkas) . '" download>' . basename($berkas) . '</a><br>';
                }
            } else {
                echo 'Tidak ada berkas.';
            }
            echo '</p>';
            $stmt = $db->prepare("SELECT alamat FROM pendaftaran WHERE user_id = ?");
            $stmt->execute([$p['user_id']]);
            $alamat = $stmt->fetchColumn();
            echo '<p><strong>Alamat:</strong> ' . htmlspecialchars($alamat) . '</p>';
        } else {
            echo '<p>Data tidak ditemukan.</p>';
        }
    } elseif (isset($_GET['q'], $_GET['filter'])) {
        // Search real-time
        $query = '%' . trim($_GET['q']) . '%';
        $filter = in_array($_GET['filter'], ['nama', 'nis', 'nik']) ? $_GET['filter'] : 'nama';
        $per_page = isset($_GET['per_page']) && in_array($_GET['per_page'], [5, 10, 25, 50]) ? (int)$_GET['per_page'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        $offset = ($page - 1) * $per_page;

        // Validasi per_page dan offset
        $per_page = max(5, min(50, $per_page));
        $offset = max(0, $offset);

        $where = '';
        $params = [];
        if ($filter == 'nama') {
            $where = "WHERE nama LIKE ?";
            $params[] = $query;
        } elseif ($filter == 'nis') {
            $where = "WHERE nis LIKE ?";
            $params[] = $query;
        } elseif ($filter == 'nik') {
            $where = "WHERE nik LIKE ?";
            $params[] = $query;
        }

        // Hitung total untuk pagination
        $stmt = $db->prepare("SELECT COUNT(*) FROM pendaftar $where");
        $stmt->execute($params);
        $total = $stmt->fetchColumn();
        $total_pages = ceil($total / $per_page);

        // Ambil data dengan binding LIMIT dan OFFSET
        $stmt = $db->prepare("SELECT id, nama, nis, nik, jurusan, nohp, email FROM pendaftar $where ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $index => $param) {
            $stmt->bindValue($index + 1, $param);
        }
        $stmt->execute();
        $pendaftar = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($pendaftar)) {
            echo '<p>Tidak ada data pendaftar.</p>';
        } else {
            foreach ($pendaftar as $p) {
                echo '<div class="card mb-3 pendaftar-card" data-id="' . $p['id'] . '">';
                echo '<div class="card-body">';
                echo '<h5>' . htmlspecialchars($p['nama']) . '</h5>';
                echo '<p>NIS: ' . htmlspecialchars($p['nis']) . '</p>';
                echo '<p>NIK: ' . htmlspecialchars($p['nik']) . '</p>';
                echo '<button class="btn btn-primary btn-sm view-detail" data-id="' . $p['id'] . '">Lihat Detail</button>';
                echo '</div></div>';
            }
        }

        // Tambah pagination di hasil search
        echo '<nav class="mt-3"><ul class="pagination">';
        echo '<li class="page-item ' . ($page <= 1 ? 'disabled' : '') . '">';
        echo '<a class="page-link" href="?q=' . urlencode($_GET['q']) . '&filter=' . $filter . '&per_page=' . $per_page . '&page=' . ($page - 1) . '">Previous</a>';
        echo '</li>';
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
            echo '<a class="page-link" href="?q=' . urlencode($_GET['q']) . '&filter=' . $filter . '&per_page=' . $per_page . '&page=' . $i . '">' . $i . '</a>';
            echo '</li>';
        }
        echo '<li class="page-item ' . ($page >= $total_pages ? 'disabled' : '') . '">';
        echo '<a class="page-link" href="?q=' . urlencode($_GET['q']) . '&filter=' . $filter . '&per_page=' . $per_page . '&page=' . ($page + 1) . '">Next</a>';
        echo '</li>';
        echo '</ul></nav>';
    } else {
        // Halaman awal tanpa search, redirect ke verifikasi.php
        header('Location: verifikasi.php');
        exit;
    }
} catch (PDOException $e) {
    logError("Gagal query di search_pendaftar.php: " . $e->getMessage());
    echo '<p>Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>';
}
?>