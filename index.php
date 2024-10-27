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
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case '/produtos/listar':
        if ($requestMethod === 'GET') {
            echo listarProdutos($produtoController);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case (preg_match('/\/produtos\/buscar\/(\d+)/', $requestUri, $matches) ? true : false):
        if ($requestMethod === 'GET') {
            $id = $matches[1];
            echo buscarProdutoPorId($produtoController, $id);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case (preg_match('/\/produtos\/atualizar\/(\d+)/', $requestUri, $matches) ? true : false):
        if ($requestMethod === 'PUT') {
            $id = $matches[1];
            echo atualizarProduto($produtoController, $id);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case (preg_match('/\/produtos\/deletar\/(\d+)/', $requestUri, $matches) ? true : false):
        if ($requestMethod === 'DELETE') {
            $id = $matches[1];
            echo deletarProduto($produtoController, $id);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case '/logs':
        if ($requestMethod === 'GET') {
            echo listarLogs($logController);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    case (preg_match('/\/logs\/(\d+)/', $requestUri, $matches) ? true : false):
        if ($requestMethod === 'GET') {
            $id = $matches[1];
            echo buscarLogPorId($logController, $id);
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(["error" => "Método não permitido"]);
        }
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["error" => "Rota não encontrada"]);
        break;
}

function criarProduto($produtoController) {
    try {
        $novoProduto = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição de Teste',
            'preco' => 49.99,
            'estoque' => 100,
            'userInsert' => 'admin'
        ];

        $id = $produtoController->criar($novoProduto);
        http_response_code(201); // Código de status 201 Created
        return json_encode([
            "success" => true,
            "id" => $id,
            "message" => "Produto criado com sucesso!"
        ]);
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        return json_encode(["error" => $e->getMessage()]);
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
        $dadosAtualizados = [
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição Atualizada',
            'preco' => 59.99,
            'estoque' => 150,
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
