<?php
class Pendaftaran {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO pendaftaran (user_id, nik, alamat, nama_ortu, pekerjaan_ortu, jurusan, berkas_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['user_id'], $data['nik'], $data['alamat'], $data['nama_ortu'], $data['pekerjaan_ortu'], $data['jurusan'], $data['berkas_path']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE pendaftaran SET nik = ?, alamat = ?, nama_ortu = ?, pekerjaan_ortu = ?, jurusan = ?, berkas_path = ? WHERE user_id = ?");
        $stmt->execute([$data['nik'], $data['alamat'], $data['nama_ortu'], $data['pekerjaan_ortu'], $data['jurusan'], $data['berkas_path'], $data['user_id']]);
    }
}
?>