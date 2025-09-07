<?php
// inicia sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// configuração do banco
$host = "localhost";
$db   = "utierp";
$user = "root";
$pass = "";

// conexão pdo
try {
    $pdo = new pdo("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (pdoexception $e) {
    die("erro ao conectar: " . $e->getmessage());
}
