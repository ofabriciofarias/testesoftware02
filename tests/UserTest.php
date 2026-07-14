<?php

// tests/UserTest.php

// 1. Carrega as dependências do Composer (incluindo o PHPUnit)
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Carrega a classe do nosso sistema que vamos testar
require_once __DIR__ . '/../app/Models/User.php';

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    private $pdo;
    private $userModel;

    protected function setUp(): void {
        // Usamos um banco em memória ou de teste para não sujar o banco de produção
        $this->pdo = new PDO("mysql:host=localhost;dbname=projexemplo", "root", "");
        $this->userModel = new User($this->pdo);
    }

    // 1. Teste se os campos estão sendo validados como preenchidos
    public function testExcecaoLancadaQuandoCamposVazios() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Os campos login e senha não podem estar vazios.");
        
        $this->userModel->authenticate("", "");
    }

    // 2. Teste de Login Válido e Inválido
    public function testLoginInvalidoRetornaFalse() {
        $resultado = $this->userModel->authenticate("admin", "senhaerrada");
        $this->assertFalse($resultado, "O sistema não deve logar com senha incorreta.");
    }

    public function testLoginValidoRetornaUsuario() {
        $resultado = $this->userModel->authenticate("admin", "password");
        $this->assertIsArray($resultado, "O sistema deve retornar os dados do usuário em caso de sucesso.");
        $this->assertEquals("admin", $resultado['login']);
    }

    // 3. Teste se a senha no banco está devidamente criptografada (BCRYPT)
    public function testSenhaEstaCriptografada() {
        $estaCriptografada = $this->userModel->isPasswordEncrypted("admin");
        $this->assertTrue($estaCriptografada, "A senha no banco de dados deve estar criptografada com hash seguro.");
    }
}