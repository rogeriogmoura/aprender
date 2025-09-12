<?php
// aplicacao/migrations/_conexao_mysqli.php
function conexao_mysqli() {
  $host = "localhost";
  $usuario = "root";
  $senha = "";
  $banco = "utierp";

  $mysqli = new mysqli($host, $usuario, $senha, $banco);
  if ($mysqli->connect_errno) {
    throw new Exception("Falha na conexão: " . $mysqli->connect_error);
  }
  return $mysqli;
}
