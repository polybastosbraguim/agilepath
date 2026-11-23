<?php

require_once 'config/database.php';

$id_candidato = $_SESSION['id'];

$stmtVerifica = $pdo->prepare("SELECT status_teste FROM candidatos WHERE id_candidato = ?");
$stmtVerifica->execute([$id_candidato]);
$usuario = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

if (!$usuario || $usuario['status_teste'] !== 'apto') {
    require 'views/aviso.php';
    exit();
}

$id_questao = $_GET['id'] ?? 1;

$total_questoes = 20;

if ($id_questao > $total_questoes) {
    header("Location: index.php?rota=resultado");
    exit();
}

if ($id_questao == 1) {
    $pdo->prepare("DELETE FROM respostas_candidato WHERE id_candidato = ?")->execute([$id_candidato]);
}

$stmt = $pdo->prepare("SELECT q.id_questao, q.enunciado, q.codigo_exemplo, o.id_opcao, o.texto_opcao 
                       FROM questoes q 
                       JOIN opcoes_respostas o ON q.id_questao = o.id_questao 
                       WHERE q.id_questao = :id ORDER BY RAND()");
$stmt->execute(['id' => $id_questao]);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'views/teste.php';
