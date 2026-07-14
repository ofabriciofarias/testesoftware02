<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($postData) {
        try {
            $userModel = new User($this->pdo);
            $user = $userModel->authenticate($postData['login'], $postData['senha']);

            if ($user) {
                return "Login realizado com sucesso! Bem-vindo, " . htmlspecialchars($user['login']) . ".";
            } else {
                return "Erro: Login ou senha inválidos.";
            }
        } catch (Exception $e) {
            return "Erro de validação: " . $e->getMessage();
        }
    }
}