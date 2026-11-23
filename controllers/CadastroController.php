<?php

require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['nome']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];

    if (empty($nome) || empty($email) || empty($senha) || empty($perfil)) {
        header("Location: index.php?rota=cadastro&erro=campos_vazios");
        exit();
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {

        $stmt = $pdo->prepare("INSERT INTO candidatos (nome, email, senha, perfil_usuario) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([$nome, $email, $senhaHash, $perfil])) {

            header("Location: index.php?rota=login&cadastro=sucesso");
            exit();
        } else {

            header("Location: index.php?rota=cadastro&erro=falha_banco");
            exit();
        }
    } catch (PDOException $e) {

        header("Location: index.php?rota=cadastro&erro=email_existente");
        exit();
    }
} else {

    header("Location: index.php?rota=cadastro");
    exit();
}
