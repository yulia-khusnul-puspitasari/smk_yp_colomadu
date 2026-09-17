<?php
session_start();
require '../config/database.php';
require '../config/logging.php';
require '../vendor/fpdf/fpdf.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] != 'panitia') {
    header('Location: login.php');
    exit;
}

class PDF extends FPDF {
    function TableHeader() {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Nama', 1);
        $this->Cell(20, 7, 'NIS', 1);
        $this->Cell(30, 7, 'NIK', 1);
        $this->Cell(30, 7, 'Nama Orang Tua', 1);
        $this->Cell(30, 7, 'Pekerjaan Ortu', 1);
        $this->Cell(20, 7, 'Jurusan', 1);
        $this->Cell(30, 7, 'Asal Sekolah', 1);
        $this->Cell(20, 7, 'Status', 1);
        $this->Cell(25, 7, 'No HP', 1);
        $this->Cell(35, 7, 'Email', 1);
        $this->Ln();
    }

    function TableRow($data) {
        $this->SetFont('Arial', '', 10);
        // Lebar kolom dalam mm
        $widths = [30, 20, 30, 30, 30, 20, 30, 20, 25, 35];
        // Tinggi baris per teks (5mm per baris)
        $line_height = 5;
        // Hitung jumlah baris untuk setiap kolom
        $max_lines = 1;
        foreach ($data as $index => $text) {
            $nb = $this->NbLines($widths[$index], $text);
            if ($nb > $max_lines) {
                $max_lines = $nb;
            }
        }
        // Total tinggi baris
        $row_height = $line_height * $max_lines;
        // Simpan posisi awal
        $x_start = $this->GetX();
        $y_start = $this->GetY();

        // Gambar border untuk seluruh baris
        $x = $x_start;
        foreach ($widths as $width) {
            $this->Rect($x, $y_start, $width, $row_height);
            $x += $width;
        }

        // Isi teks dengan MultiCell tanpa border
        $x = $x_start;
        foreach ($data as $index => $text) {
            $this->SetXY($x, $y_start);
            $this->MultiCell($widths[$index], $line_height, $text, 0, 'L');
            $x += $widths[$index];
        }

        // Pindah ke baris berikutnya
        $this->SetY($y_start + $row_height);
    }

    function NbLines($w, $txt) {
        // Hitung jumlah baris untuk MultiCell
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Handle download request
if (isset($_GET['type'])) {
    try {
        $type = $_GET['type'];
        $where = '';
        $title = '';
        
        if ($type === 'all') {
            $title = 'Laporan Semua Pendaftar';
        } elseif ($type === 'diterima') {
            $where = "WHERE status = 'diterima'";
            $title = 'Laporan Pendaftar Diterima';
        } elseif ($type === 'ditolak') {
            $where = "WHERE status = 'ditolak'";
            $title = 'Laporan Pendaftar Ditolak';
        } else {
            throw new Exception("Tipe laporan tidak valid");
        }
        
        $stmt = $db->prepare("SELECT nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, asal_sekolah, status, nohp, email FROM pendaftar $where ORDER BY created_at DESC");
        $stmt->execute();
        $pendaftar = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $pdf = new PDF();
        $pdf->AddPage('L');
        $pdf->SetLineWidth(0.2); // Garis border lebih tebal, rapi
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Tanggal: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->TableHeader();
        
        foreach ($pendaftar as $p) {
            $pdf->TableRow([
                $p['nama'],
                $p['nis'],
                $p['nik'],
                $p['nama_ortu'],
                $p['pekerjaan_ortu'],
                $p['jurusan'],
                $p['asal_sekolah'],
                $p['status'],
                $p['nohp'],
                $p['email']
            ]);
        }
        
        $filename = str_replace(' ', '_', strtolower($title)) . '_' . date('Ymd_His') . '.pdf';
        $pdf->Output('D', $filename);
        exit;
    } catch (Exception $e) {
        logError("Gagal generate PDF: " . $e->getMessage());
        $error = "Terjadi kesalahan saat generate PDF: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Laporan - SMK Colomadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
   
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row flex-grow-1">
            <?php include '../includes/sidebar_panitia.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2 class="mt-4">Download Laporan</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="download.php?type=all" class="btn btn-primary w-100" style="background-color: #60A5FA;">Download Laporan Pendaftar</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="download.php?type=diterima" class="btn btn-primary w-100" style="background-color: #60A5FA;">Download Laporan Diterima</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="download.php?type=ditolak" class="btn btn-primary w-100" style="background-color: #60A5FA;">Download Laporan Ditolak</a>
                    </div>
                </div>
            </main>
        </div>
        <?php include '../includes/footer.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>