<?php

class Produto {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection(); 
    }

    public function listar() {
        $sql = "SELECT * FROM produtos";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados) {
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, userInsert) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$dados['nome'], $dados['descricao'], $dados['preco'], $dados['estoque'], $dados['userInsert']]);
        return $this->conn->lastInsertId();
    }

    public function atualizar($id, $dados) {
        $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, estoque = ?, userInsert = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$dados['nome'], $dados['descricao'], $dados['preco'], $dados['estoque'], $dados['userInsert'], $id]);
    }

    public function deletar($id) {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
