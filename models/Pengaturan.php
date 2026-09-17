<?php
class Pengaturan {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getLatest() {
        $stmt = $this->db->prepare("SELECT * FROM pengaturan ORDER BY created_at DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO pengaturan (tahun_ajaran, kuota, tanggal_mulai, tanggal_akhir, nilai_minimal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['tahun_ajaran'], $data['kuota'], $data['tanggal_mulai'], $data['tanggal_akhir'], $data['nilai_minimal']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE pengaturan SET tahun_ajaran = ?, kuota = ?, tanggal_mulai = ?, tanggal_akhir = ?, nilai_minimal = ? WHERE id = ?");
        $stmt->execute([$data['tahun_ajaran'], $data['kuota'], $data['tanggal_mulai'], $data['tanggal_akhir'], $data['nilai_minimal'], $data['id']]);
    }
}
?>