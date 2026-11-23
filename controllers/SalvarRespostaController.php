<?php

require 'helpers/auth.php';
verificarLogin();
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_candidato = $_SESSION['id'];
    $id_questao = $_POST['id_questao'];
    $id_opcao = $_POST['id_opcao'] ?? null;

    if ($id_opcao) {

        $stmtVerifica = $pdo->prepare("SELECT correta FROM opcoes_respostas WHERE id_opcao = ?");
        $stmtVerifica->execute([$id_opcao]);
        $resultado = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

        $foi_acerto = ($resultado && $resultado['correta'] == 1) ? 1 : 0;

        $stmt = $pdo->prepare("INSERT INTO respostas_candidato (id_candidato, id_questao, id_opcao_escolhida, acertou) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_candidato, $id_questao, $id_opcao, $foi_acerto]);
    }

    $proxima = $id_questao + 1;
    if ($proxima > 20) {
        header("Location: index.php?rota=resultado");
    } else {
        header("Location: index.php?rota=teste&id=" . $proxima);
    }
    exit;
}
