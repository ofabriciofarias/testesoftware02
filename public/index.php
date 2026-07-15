<?php
// public/index.php
session_start();
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/CalculatorController.php';

// Conexão com o Banco de Dados
$pdo = new PDO("mysql:host=localhost;dbname=projexemplo", "root", "");

// Variáveis de controle de estado da tela
$mensagemLogin = "";
$resultadoSoma = null;
$erroSoma = null;
$resultadoSubtracao = null;
$erroSubtracao = null;

// Verifica se houve uma requisição POST e qual formulário a originou
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ROTA DO LOGIN: Se vieram os campos de usuário e senha
    if (isset($_POST['login']) && isset($_POST['senha'])) {
        $auth = new AuthController($pdo);
        $mensagemLogin = $auth->login($_POST);
    } 
    // ROTA DA CALCULADORA: Se veio a ação de somar
    elseif (isset($_POST['acao']) && $_POST['acao'] === 'somar') {
        $calc = new CalculatorController();
        try {
            $resultadoSoma = $calc->somar($_POST['numero1'], $_POST['numero2']);
        } catch (Exception $e) {
            $erroSoma = $e->getMessage();
        }
    }elseif (isset($_POST['subtracao']) && $_POST['subtracao'] === 'sub') {
        $calc = new CalculatorController();
        try{
            $resultadoSubtracao = $calc->subtrair($_POST['numero1'], $_POST['numero2']);
        }catch(Exception $e){
            $erroSubtracao = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Introdução aos Testes de Software</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f4f7f6; }
        header { background-color: #2c3e50; color: white; display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; }
        .logo { font-size: 24px; font-weight: bold; }
        .login-form input { padding: 8px; margin-right: 10px; border-radius: 4px; border: 1px solid #ccc; }
        .login-form button { padding: 8px 15px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .login-form button:hover { background-color: #2ecc71; }
        .alert { background: #e74c3c; color: white; padding: 10px; text-align: center; }
        .alert.success { background: #27ae60; }
        .content { max-width: 900px; margin: 40px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        .calculadora-box { background: #ecf0f1; padding: 20px; border-radius: 8px; margin-top: 30px; }
        .calculadora-box input { padding: 10px; margin-right: 10px; width: 120px; border: 1px solid #ccc; border-radius: 4px;}
        .calculadora-box button { padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
        
        .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fff; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 300px; border-radius: 8px; text-align: center; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .resultado-texto { font-size: 24px; color: #27ae60; margin-top: 15px; }
    </style>
</head>
<body>

<header>
    <div class="logo">TestLab Academy</div>
    <!-- FORMULÁRIO DE LOGIN -->
    <form class="login-form" method="POST" action="index.php">
        <input type="text" name="login" id="campo-login" placeholder="Usuário" required>
        <input type="password" name="senha" id="campo-senha" placeholder="Senha" required>
        <button type="submit" id="btn-login">Entrar</button>
    </form>
</header>

<?php if ($mensagemLogin): ?>
    <div class="alert <?= strpos($mensagemLogin, 'sucesso') !== false ? 'success' : '' ?>">
        <?= $mensagemLogin ?>
    </div>
<?php endif; ?>

<div class="content">
    <h1>Tipos de Testes de Software</h1>
    <p>Garantir a qualidade do software é essencial. Teste abaixo nossa funcionalidade matemática:</p>
    
    <!-- FORMULÁRIO DA CALCULADORA -->
    <div class="calculadora-box">
        <h2>Calculadora de Soma</h2>
        <form method="POST" action="index.php">
            <input type="number" step="any" name="numero1" id="num1" placeholder="Nº 1">
            <span style="font-size: 20px; font-weight:bold;">+</span>
            <input type="number" step="any" name="numero2" id="num2" placeholder="Nº 2">
            <button type="submit" name="acao" value="somar" id="btn-somar">Calcular</button>
        </form>
    </div>

    <!-- FORMULÁRIO DA CALCULADORA -->
    <div class="calculadora-box">
        <h2>Calculadora de Subtração</h2>
        <form method="POST" action="index.php">
            <input type="number" step="any" name="numero1" id="num1" placeholder="Nº 1">
            <span style="font-size: 20px; font-weight:bold;">-</span>
            <input type="number" step="any" name="numero2" id="num2" placeholder="Nº 2">
            <button type="submit" name="subtracao" value="sub" id="btn-subtracao">Calcular</button>
        </form>
    </div>
</div>

<!-- MODAL DE RESULTADO DA CALCULADORA -->
<?php if ($resultadoSoma !== null || $erroSoma !== null): ?>
<div id="meuModal" class="modal" style="display: block;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('meuModal').style.display='none'">&times;</span>
        
        <?php if ($resultadoSoma !== null): ?>
            <h3>Resultado da Soma</h3>
            <div class="resultado-texto" id="resultado-valor"><?= htmlspecialchars($resultadoSoma) ?></div>
        <?php else: ?>
            <h3 style="color: red;">Erro</h3>
            <p><?= htmlspecialchars($erroSoma) ?></p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- MODAL DE RESULTADO DA CALCULADORA Subtração-->
<?php if ($resultadoSubtracao !== null || $erroSubtracao !== null): ?>
<div id="meuModal" class="modal" style="display: block;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('meuModal').style.display='none'">&times;</span>
        
        <?php if ($resultadoSubtracao !== null): ?>
            <h3>Resultado da Subtração</h3>
            <div class="resultado-texto" id="resultado-valor"><?= htmlspecialchars($resultadoSubtracao) ?></div>
        <?php else: ?>
            <h3 style="color: red;">Erro</h3>
            <p><?= htmlspecialchars($erroSubtracao) ?></p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

</body>
</html>