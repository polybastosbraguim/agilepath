<?php

require_once 'config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT id_candidato, nome, senha, cargo FROM candidatos WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {

        $_SESSION['id'] = $usuario['id_candidato'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['cargo'];

        session_regenerate_id(true);

        if ($usuario['cargo'] === 'admin') {
            header("Location: index.php?rota=admin");
            exit();
        } else {
            header("Location: index.php?rota=dashboard");
            exit();
        }
    } else {
        header("Location: index.php?rota=login&erro=1");
        exit();
    }
}
