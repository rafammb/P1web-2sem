<?php

class Log {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection(); 
    }

    public function listar() {
        $sql = "SELECT * FROM logs";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM logs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrar($acao, $produtoId, $userInsert) {
        $sql = "INSERT INTO logs (acao, data_hora, produto_id, userInsert) VALUES (?, CURRENT_TIMESTAMP, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$acao, $produtoId, $userInsert]);
    }
}
?>