<?php
class Komentar {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO komentar (pendaftar_id, panitia_id, komentar) VALUES (?, ?, ?)");
        $stmt->execute([$data['pendaftar_id'], $data['panitia_id'], $data['komentar']]);
    }

    public function getByPendaftarId($pendaftar_id) {
        $stmt = $this->db->prepare("SELECT k.*, u.nama as panitia_nama FROM komentar k JOIN users u ON k.panitia_id = u.id WHERE k.pendaftar_id = ? ORDER BY k.timestamp DESC");
        $stmt->execute([$pendaftar_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>