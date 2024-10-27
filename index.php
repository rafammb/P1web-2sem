<?php
require_once 'src/Models/Produto.php';
require_once 'src/Models/Log.php';
require_once 'src/Controllers/LogController.php';
require_once 'src/Controllers/ProdutoController.php';
require_once 'src/Config/Database.php';

$db = new Database();
$produtoController = new ProdutoController($db);
$logController = new LogController($db);

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/':
        echo "Bem-vindo ao sistema de gerenciamento de produtos!";
        break;

    case '/produtos/criar':
        if ($requestMethod === 'POST') {
            echo criarProduto($produtoController);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido. Use POST para criar um produto."]);
        }
        break;

    case '/produtos/listar':
        echo listarProdutos($produtoController);
        break;

    case (preg_match('/\/produtos\/buscar\/(\d+)/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        echo buscarProdutoPorId($produtoController, $id);
        break;

    case (preg_match('/\/produtos\/atualizar\/(\d+)/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        if ($requestMethod === 'PUT') {
            echo atualizarProduto($produtoController, $id);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido. Use PUT para atualizar um produto."]);
        }
        break;

    case (preg_match('/\/produtos\/deletar\/(\d+)/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        if ($requestMethod === 'DELETE') {
            echo deletarProduto($produtoController, $id);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido. Use DELETE para excluir um produto."]);
        }
        break;

    case '/logs':
        echo listarLogs($logController);
        break;

    case (preg_match('/\/logs\/(\d+)/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        echo buscarLogPorId($logController, $id);
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["error" => "Rota não encontrada"]);
        break;
}

function criarProduto($produtoController) {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $novoProduto = [
            'nome' => $data['nome'] ?? 'Produto Teste',
            'descricao' => $data['descricao'] ?? 'Descrição de Teste',
            'preco' => $data['preco'] ?? 49.99,
            'estoque' => $data['estoque'] ?? 100,
            'userInsert' => 'admin'
        ];

        $id = $produtoController->criar($novoProduto);
        return json_encode(["success" => true, "id" => $id]);
    } catch (Exception $e) {
        return json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}

function listarProdutos($produtoController) {
    try {
        $produtos = $produtoController->listar();
        return json_encode($produtos);
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode(["error" => $e->getMessage()]);
    }
}

function buscarProdutoPorId($produtoController, $id) {
    try {
        $produto = $produtoController->buscarPorId($id);
        
        if ($produto) {
            return json_encode($produto);
        } else {
            return json_encode(["error" => "Produto não encontrado!"]);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        return json_encode(["error" => $e->getMessage()]);
    }
}

function atualizarProduto($produtoController, $id) {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $dadosAtualizados = [
            'nome' => $data['nome'] ?? 'Produto Atualizado',
            'descricao' => $data['descricao'] ?? 'Descrição Atualizada',
            'preco' => $data['preco'] ?? 59.99,
            'estoque' => $data['estoque'] ?? 150,
            'userInsert' => 'admin'
        ];

        if ($produtoController->atualizar($id, $dadosAtualizados)) {
            return json_encode(["success" => true, "message" => "Produto atualizado com sucesso!"]);
        } else {
            return json_encode(["success" => false, "error" => "Erro ao atualizar o produto."]);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        return json_encode(["error" => $e->getMessage()]);
    }
}

function deletarProduto($produtoController, $id) {
    try {
        $produtoController->deletar($id, 'admin');
        return json_encode(["success" => true, "message" => "Produto excluído com sucesso!"]);
    } catch (Exception $e) {
        return json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}

function listarLogs($logController) {
    try {
        $logs = $logController->listar();
        return json_encode($logs);
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode(["error" => $e->getMessage()]);
    }
}

function buscarLogPorId($logController, $id) {
    try {
        $log = $logController->buscarPorId($id);
        
        if ($log) {
            return json_encode($log);
        } else {
            return json_encode(["error" => "Log não encontrado!"]);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        return json_encode(["error" => $e->getMessage()]);
    }
}
