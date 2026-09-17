<?php
class Pendaftar {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function countByStatus($status = null) {
        if ($status) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM pendaftar WHERE status = ?");
            $stmt->execute([$status]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM pendaftar");
            $stmt->execute();
        }
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM pendaftar ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM pendaftar WHERE id IN (SELECT id FROM pendaftaran WHERE user_id = ?)");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO pendaftar (nama, nis, nik, nama_ortu, pekerjaan_ortu, jurusan, berkas, asal_sekolah) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['nama'], $data['nis'], $data['nik'], $data['nama_ortu'], $data['pekerjaan_ortu'], $data['jurusan'], $data['berkas_path'], $data['asal_sekolah']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE pendaftar SET nama = ?, nis = ?, nik = ?, nama_ortu = ?, pekerjaan_ortu = ?, jurusan = ?, berkas = ?, asal_sekolah = ? WHERE id = ?");
        $stmt->execute([$data['nama'], $data['nis'], $data['nik'], $data['nama_ortu'], $data['pekerjaan_ortu'], $data['jurusan'], $data['berkas_path'], $data['asal_sekolah'], $data['id']]);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE pendaftar SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
}
?>