<?php
class Foto {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM foto ORDER BY tanggal_upload DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO foto (nama_file, keterangan, tanggal_upload) VALUES (?, ?, ?)");
        $stmt->execute([$data['nama_file'], $data['keterangan'], $data['tanggal_upload']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE foto SET nama_file = ?, keterangan = ?, tanggal_upload = ? WHERE id = ?");
        $stmt->execute([$data['nama_file'], $data['keterangan'], $data['tanggal_upload'], $data['id']]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM foto WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>