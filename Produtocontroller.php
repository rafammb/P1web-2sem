<?php

require_once __DIR__ . '/../Models/Produto.php';
require_once __DIR__ . '/../Models/Log.php';

class ProdutoController {
    private $produto;
    private $log;

    public function __construct($db) {
        $this->produto = new Produto($db);
        $this->log = new Log($db);
    }

    public function listar() {
        try {
            $produtos = $this->produto->listar();
            return json_encode(["success" => true, "data" => $produtos]);
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public function buscarPorId($id) {
        try {
            $produto = $this->produto->buscarPorId($id);
            if ($produto) {
                return json_encode(["success" => true, "data" => $produto]);
            } else {
                return json_encode(["success" => false, "error" => "Produto não encontrado!"]);
            }
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public function criar($dados) {
        try {
            $id = $this->produto->criar($dados);
            return json_encode(["success" => true, "message" => "Produto criado com ID: $id"]);
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public function atualizar($id, $dados) {
        try {
            if ($this->produto->atualizar($id, $dados)) {
                return json_encode(["success" => true, "message" => "Produto atualizado com sucesso!"]);
            } else {
                return json_encode(["success" => false, "error" => "Produto não encontrado ou não atualizado."]);
            }
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public function deletar($id, $userInsert) {
        try {
            $produtoExistente = $this->produto->buscarPorId($id);
            if (!$produtoExistente) {
                return json_encode(["success" => false, "error" => "Produto com id $id não encontrado."]);
            }

            if ($this->produto->deletar($id)) {
                $this->log->registrar('exclusão', $id, $userInsert);
                return json_encode(["success" => true, "message" => "Produto excluído com sucesso!"]);
            }
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }
}
?>
