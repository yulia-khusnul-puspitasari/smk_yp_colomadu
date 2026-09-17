<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByRole($role) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ?");
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['username'], $data['password'], $data['nama'], $data['role']]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ?, nama = ? WHERE id = ?");
        $stmt->execute([$data['username'], $data['password'], $data['nama'], $data['id']]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>