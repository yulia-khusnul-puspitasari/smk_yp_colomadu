<?php
class Sekolah {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getLatest() {
        $stmt = $this->db->prepare("SELECT * FROM sekolah ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO sekolah (alamat, kontak, visi, misi) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['alamat'], $data['kontak'], $data['visi'], $data['misi']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE sekolah SET alamat = ?, kontak = ?, visi = ?, misi = ? WHERE id = ?");
        $stmt->execute([$data['alamat'], $data['kontak'], $data['visi'], $data['misi'], $data['id']]);
    }
}
?>