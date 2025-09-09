<?php
$mysqli = new mysqli("localhost", "root", "", "utierp");

/* cadastrar cliente */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['atualizar'])) {
    $nome      = $_POST['nome'];
    $email     = $_POST['email'] ?? null;
    $telefone  = $_POST['telefone'] ?? null;
    $cpf_cnpj  = $_POST['cpf_cnpj'] ?? null;
    $endereco  = $_POST['endereco'] ?? null;
    $cidade    = $_POST['cidade'] ?? null;
    $uf        = $_POST['uf'] ?? null;

    $stmt = $mysqli->prepare("
        INSERT INTO clientes (nome, email, telefone, cpf_cnpj, endereco, cidade, uf)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssssss", $nome, $email, $telefone, $cpf_cnpj, $endereco, $cidade, $uf);

    if ($stmt->execute()) {
        header("Location: ../visoes/clientes_listar.php?msg=cadastrado");
        exit;
    } else {
        echo "Erro ao cadastrar cliente: " . $stmt->error;
    }
}

/* atualizar cliente */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $id        = $_POST['id'];
    $nome      = $_POST['nome'];
    $email     = $_POST['email'] ?? null;
    $telefone  = $_POST['telefone'] ?? null;
    $cpf_cnpj  = $_POST['cpf_cnpj'] ?? null;
    $endereco  = $_POST['endereco'] ?? null;
    $cidade    = $_POST['cidade'] ?? null;
    $uf        = $_POST['uf'] ?? null;

    $stmt = $mysqli->prepare("
        UPDATE clientes 
        SET nome=?, email=?, telefone=?, cpf_cnpj=?, endereco=?, cidade=?, uf=? 
        WHERE id=?
    ");
    $stmt->bind_param("sssssssi", $nome, $email, $telefone, $cpf_cnpj, $endereco, $cidade, $uf, $id);

    if ($stmt->execute()) {
        header("Location: ../visoes/clientes_listar.php?msg=atualizado");
        exit;
    } else {
        echo "Erro ao atualizar cliente: " . $stmt->error;
    }
}

/* inativar cliente */
if (isset($_GET['inativar'])) {
    $id = $_GET['inativar'];
    $stmt = $mysqli->prepare("UPDATE clientes SET ativo=0 WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../visoes/clientes_listar.php?msg=inativado");
        exit;
    } else {
        echo "Erro ao inativar cliente: " . $stmt->error;
    }
}
