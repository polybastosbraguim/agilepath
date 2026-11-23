<?php

require_once 'config/database.php';
require_once 'helpers/auth.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php?rota=login");
    exit;
}

$msgSucesso = '';
$msgErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desafio_nivel = trim($_POST['desafio_nivel'] ?? '');
    $nivel = trim($_POST['nivel'] ?? '');

    if (!empty($desafio_nivel) && !empty($nivel)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO desafio (desafio_nivel, nivel) VALUES (?, ?)");
            $stmt->execute([$desafio_nivel, $nivel]);
            $msgSucesso = "Desafio cadastrado com sucesso!";
        } catch (PDOException $e) {
            $msgErro = "Erro ao cadastrar desafio: " . $e->getMessage();
        }
    } else {
        $msgErro = "Preencha todos os campos.";
    }
}

$filtroNivel = $_GET['categoria'] ?? '';

if (!empty($filtroNivel)) {
    $stmtLista = $pdo->prepare("SELECT * FROM desafio WHERE nivel = ? ORDER BY id DESC");
    $stmtLista->execute([$filtroNivel]);
} else {
    $stmtLista = $pdo->query("SELECT * FROM desafio ORDER BY id DESC");
}

$desafiosCadastrados = $stmtLista->fetchAll(PDO::FETCH_ASSOC);

require 'views/admin_cadastrar_desafio.php';
