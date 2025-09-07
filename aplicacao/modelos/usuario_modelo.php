<?php
class usuario_modelo {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // busca usuário pelo e-mail
    public function buscar_por_email($email) {
        $sql = "select * from usuario where email = :email limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindvalue(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
