<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../modelos/usuario_modelo.php';

$usuario_modelo = new usuario_modelo($pdo);

// se já está logado → redireciona para dashboard
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("location: ../visoes/dashboard_" . strtolower($_SESSION['funcao']) . ".php");
    exit;
}

// se enviou login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $usuario = $usuario_modelo->buscar_por_email($email);

    if ($usuario && $senha === $usuario->senha) {

        // cria sessão
        $_SESSION['logado'] = true;
        $_SESSION['id_usuario'] = $usuario->id;
        $_SESSION['nome'] = $usuario->nome;
        $_SESSION['email'] = $usuario->email;
        $_SESSION['funcao'] = strtolower($usuario->funcao); // admin, gerente, tecnico, atendente

        // redireciona para o dashboard da função
        header("location: ../visoes/dashboard_" . $_SESSION['funcao'] . ".php");
        exit;
    } else {
        $_SESSION['erro'] = "e-mail ou senha inválidos.";
        header("location: ../visoes/login.php");
        exit;
    }
}
