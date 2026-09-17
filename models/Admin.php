<?php
class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>