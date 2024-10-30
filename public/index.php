<?php 
require __DIR__ . '/../src/Models/Produto.php';
require __DIR__ . '/../src/Models/Log.php';
require __DIR__ . '/../src/Controllers/LogController.php';
require __DIR__ . '/../src/Controllers/ProdutoController.php';
require __DIR__ . '/../src/Config/Database.php';

$db = new Database();
$produtoController = new ProdutoController($db);
$logController = new LogController($db);

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/':
        echo file_get_contents('index.html'); 
        break;

    case '/api/produtos':
        if ($requestMethod === 'GET') {
            echo listarProdutos($produtoController);
        } elseif ($requestMethod === 'POST') {
            echo criarProduto($produtoController);
        }
        break;

    case (preg_match('/\/api\/produtos\/(\d+)/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        if ($requestMethod === 'GET') {
            echo buscarProdutoPorId($produtoController, $id);
        } elseif ($requestMethod === 'PUT') {
            echo atualizarProduto($produtoController, $id);
        } elseif ($requestMethod === 'DELETE') {
            echo deletarProduto($produtoController, $id);
        }
        break;

    case '/api/logs':
        if ($requestMethod === 'GET') {
            echo listarLogs($logController);
        }
        break;

    case (preg_match('/\/api\/logs\/(\d+)/', $requestUri, $matches) ? true : false):
        $id = $matches[1];
        if ($requestMethod === 'GET') {
            echo buscarLogPorId($logController, $id);
        }
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
        return json_encode(["success" => true, "data" => $produtos]);
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode(["error" => $e->getMessage()]);
    }
}

function buscarProdutoPorId($produtoController, $id) {
    try {
        $produto = $produtoController->buscarPorId($id);
        
        if ($produto) {
            return json_encode(["success" => true, "data" => $produto]);
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
        return json_encode(["success" => true, "data" => $logs]);
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode(["error" => $e->getMessage()]);
    }
}

function buscarLogPorId($logController, $id) {
    try {
        $log = $logController->buscarPorId($id);
        
        if ($log) {
            return json_encode(["success" => true, "data" => $log]);
        } else {
            return json_encode(["error" => "Log não encontrado!"]);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 400 Bad Request");
        return json_encode(["error" => $e->getMessage()]);
    }
}
