<?php
// aplicacao/migrations/_conexao.php
// Arquivo central de conexão PDO para todas as migrations.
// Banco de dados: utierp

function conexao() {
    $host = "127.0.0.1";     // ou "localhost"
    $porta = "3306";         // porta padrão do MySQL no XAMPP
    $banco = "utierp";       // nome do banco real do projeto
    $user  = "root";         // usuário padrão do MySQL no XAMPP
    $pass  = "";             // senha padrão do MySQL no XAMPP (normalmente vazia)
    $charset = "utf8mb4";    // charset recomendado

    $dsnBanco = "mysql:host=$host;port=$porta;dbname=$banco;charset=$charset";
    $opcoes = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lançar exceções em erros
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch em arrays associativos
        PDO::ATTR_EMULATE_PREPARES   => false,                  // usar prepared statements nativos
    ];

    try {
        return new PDO($dsnBanco, $user, $pass, $opcoes);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco '$banco': " . $e->getMessage());
    }
}
