<?php
class Nilai {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addOrUpdate($data) {
        $stmt = $this->db->prepare("SELECT id FROM nilai WHERE pendaftar_id = ?");
        $stmt->execute([$data['pendaftar_id']]);
        if ($stmt->fetch()) {
            $stmt = $this->db->prepare("UPDATE nilai SET nilai_tes = ? WHERE pendaftar_id = ?");
            $stmt->execute([$data['nilai_tes'], $data['pendaftar_id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO nilai (pendaftar_id, nilai_tes) VALUES (?, ?)");
            $stmt->execute([$data['pendaftar_id'], $data['nilai_tes']]);
        }
    }

    public function getByPendaftarId($pendaftar_id) {
        $stmt = $this->db->prepare("SELECT * FROM nilai WHERE pendaftar_id = ?");
        $stmt->execute([$pendaftar_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>