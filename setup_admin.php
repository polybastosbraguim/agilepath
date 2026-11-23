<?php

require_once 'config/database.php';

$nome = "Polayne da Silva Bastos";
$email = "polaynesbastos@agilepath.com";
$senhaPura = "polyadmin";
$senhaHash = password_hash($senhaPura, PASSWORD_DEFAULT);
$cargo = "admin";
$nivel = "admin";

try {

    $stmtCheck = $pdo->prepare("SELECT id_candidato FROM candidatos WHERE email = ?");
    $stmtCheck->execute([$email]);

    if ($stmtCheck->rowCount() > 0) {

        $stmtUpdate = $pdo->prepare("UPDATE candidatos SET cargo = ?, nivel = ?, senha = ? WHERE email = ?");
        $stmtUpdate->execute([$cargo, $nivel, $senhaHash, $email]);
        echo "Usuário já existia e foi promovido a Administrador com sucesso!";
    } else {

        $stmtInsert = $pdo->prepare("INSERT INTO candidatos (nome, email, senha, cargo, nivel, pontuacao) VALUES (?, ?, ?, ?, ?, 0)");
        $stmtInsert->execute([$nome, $email, $senhaHash, $cargo, $nivel]);
        echo "Administrador criado do zero com sucesso!<br>E-mail: <b>$email</b><br>Senha: <b>$senhaPura</b>";
    }
} catch (PDOException $e) {
    echo "Erro ao criar admin: " . $e->getMessage();
}
