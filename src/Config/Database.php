<?php


class Database {
    private $conn;

    public function getConnection() {
        try {
            $caminhoDB = __DIR__ . '/../../db/database.db';
            $this->conn = new PDO("sqlite:" . $caminhoDB);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao conectar ao banco de dados: " . $e->getMessage()
            ]);
            return null;
        }
    }
}
?>
