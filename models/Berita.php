<?php
class Berita {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM berita ORDER BY tanggal DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO berita (judul, isi, gambar, deskripsi_gambar, tanggal) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['judul'], $data['isi'], $data['gambar'], $data['deskripsi_gambar'], $data['tanggal']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE berita SET judul = ?, isi = ?, gambar = ?, deskripsi_gambar = ?, tanggal = ? WHERE id = ?");
        $stmt->execute([$data['judul'], $data['isi'], $data['gambar'], $data['deskripsi_gambar'], $data['tanggal'], $data['id']]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM berita WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>