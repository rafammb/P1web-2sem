<?php

class Database {
    private $conn;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("sqlite:" . __DIR__ . "/../../db/database.db");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo json_encode(["success" => false, "error" => "Erro ao conectar ao banco de dados: " . $e->getMessage()]);
                return null;
            }
        }
        return $this->conn;
    }
}
?>
