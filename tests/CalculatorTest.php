<?php
// tests/CalculatorTest.php

// Carrega o autoloader e a classe a ser testada
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Controllers/CalculatorController.php';

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {
    
    private $calc;

    // O setUp roda antes de cada teste, garantindo uma instância limpa
    protected function setUp(): void {
        $this->calc = new CalculatorController();
    }

    // Missão 1.1: Testar o caminho feliz (cálculo correto)
    public function testSomaDeDoisNumerosPositivos() {
        // Arrange & Act
        $resultado = $this->calc->somar(15, 25);
        
        // Assert
        $this->assertEquals(40, $resultado, "A soma de 15 e 25 deveria ser exatamente 40.");
    }

    // Missão 1.2: Testar o caminho de erro (tratamento de exceções)
    public function testSomaRejeitaLetras() {
        // Assert: Prepara o teste para esperar uma falha controlada
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Os valores fornecidos devem ser números válidos.");
        
        // Act: Executa a ação que deve disparar a exceção
        $this->calc->somar("A", "B");
    }
}