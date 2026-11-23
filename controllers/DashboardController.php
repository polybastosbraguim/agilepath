<?php
require_once 'config/database.php';

$id_candidato = $_SESSION['id'];

$stmt = $pdo->prepare("SELECT nome, nivel, pontuacao FROM candidatos WHERE id_candidato = ?");
$stmt->execute([$id_candidato]);
$candidato = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $candidato['nome'] ?? 'Candidato';
$nivel = $candidato['nivel'] ?? 'Não avaliado';
$pontuacao = $candidato['pontuacao'] ?? 0;

$fezTeste = ($nivel !== 'Não avaliado' && !empty($nivel));

$stmtRanking = $pdo->prepare("SELECT COUNT(*) + 1 AS posicao FROM candidatos WHERE pontuacao > ?");
$stmtRanking->execute([$pontuacao]);
$rankingUser = $stmtRanking->fetch(PDO::FETCH_ASSOC);
$posicao_global = $rankingUser['posicao'] ?? 1;

$stmtListaRanking = $pdo->query("SELECT id_candidato, nome, nivel, pontuacao FROM candidatos ORDER BY pontuacao DESC");
$ranking = $stmtListaRanking->fetchAll(PDO::FETCH_ASSOC);

require 'views/dashboard.php';
