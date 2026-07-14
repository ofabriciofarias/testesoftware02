<?php
// app/Models/User.php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authenticate($login, $password) {
        if (empty($login) || empty($password)) {
            throw new Exception("Os campos login e senha não podem estar vazios.");
        }

        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE login = :login LIMIT 1");
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha confere com a criptografia
        if ($user && password_verify($password, $user['senha'])) {
            return $user;
        }

        return false;
    }

    public function isPasswordEncrypted($login) {
        $stmt = $this->pdo->prepare("SELECT senha FROM user WHERE login = :login LIMIT 1");
        $stmt->execute(['login' => $login]);
        $hash = $stmt->fetchColumn();
        
        // Verifica se a string é um hash do algoritmo BCRYPT do PHP
        return $hash && password_get_info($hash)['algo'] === PASSWORD_BCRYPT;
    }
}

