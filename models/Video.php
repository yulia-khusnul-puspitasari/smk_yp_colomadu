<?php
class Video {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM video ORDER BY tanggal_upload DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO video (url, judul, tanggal_upload) VALUES (?, ?, ?)");
        $stmt->execute([$data['url'], $data['judul'], $data['tanggal_upload']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE video SET url = ?, judul = ?, tanggal_upload = ? WHERE id = ?");
        $stmt->execute([$data['url'], $data['judul'], $data['tanggal_upload'], $data['id']]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM video WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>