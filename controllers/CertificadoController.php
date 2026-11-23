<?php

require_once 'config/database.php';
require_once 'helpers/auth.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php?rota=login");
    exit;
}

$id_candidato = $_SESSION['id'];

$stmt = $pdo->prepare("SELECT nome, nivel, pontuacao FROM candidatos WHERE id_candidato = ?");
$stmt->execute([$id_candidato]);
$candidato = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $candidato['nome'] ?? 'Candidato';
$nivel = $candidato['nivel'] ?? 'Não avaliado';
$pontuacao = $candidato['pontuacao'] ?? 0;

if (empty($nivel) || $nivel === 'Não avaliado') {
    header("Location: index.php?rota=dashboard&msg=sem_nivel");
    exit;
}

$codigoValidacao = strtoupper(substr(md5($id_candidato . $nivel), 0, 8));
$dataEmissao = date('d/m/Y');

require 'views/certificado.php';
