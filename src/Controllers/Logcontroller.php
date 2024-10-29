<?php

require_once __DIR__ . '/../Models/Log.php';

class LogController {
    private $log;

    public function __construct($db) {
        $this->log = new Log($db);
    }

    public function listar() {
        try {
            $logs = $this->log->listar();
            return json_encode(["success" => true, "data" => $logs]);
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public function buscarPorId($id) {
        try {
            $log = $this->log->buscarPorId($id);
            if ($log) {
                return json_encode(["success" => true, "data" => $log]);
            } else {
                return json_encode(["success" => false, "error" => "Log não encontrado!"]);
            }
        } catch (Exception $e) {
            return json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    }
    public function registrar($acao, $produtoId, $userInsert) {
        return $this->log->registrar($acao, $produtoId, $userInsert);
    }
}