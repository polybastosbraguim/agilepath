<?php

require_once 'config/database.php';
require_once 'helpers/auth.php';

if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
    header("Location: index.php?rota=dashboard");
    exit;
}

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $acao = $_GET['acao'];
    $idAlvo = intval($_GET['id']);

    if ($acao === 'excluir') {
        $stmtDelRespostas = $pdo->prepare("DELETE FROM respostas_candidato WHERE id_candidato = ?");
        $stmtDelRespostas->execute([$idAlvo]);

        $stmtDelCand = $pdo->prepare("DELETE FROM candidatos WHERE id_candidato = ?");
        $stmtDelCand->execute([$idAlvo]);

        header("Location: index.php?rota=admin&msg=excluido");
        exit;
    } elseif ($acao === 'resetar') {
        $stmtResetRespostas = $pdo->prepare("DELETE FROM respostas_candidato WHERE id_candidato = ?");
        $stmtResetRespostas->execute([$idAlvo]);

        $stmtResetCand = $pdo->prepare("UPDATE candidatos SET nivel = NULL, pontuacao = 0 WHERE id_candidato = ?");
        $stmtResetCand->execute([$idAlvo]);

        header("Location: index.php?rota=admin&msg=resetado");
        exit;
    } elseif ($acao === 'mudar_cargo') {

        $stmtCargo = $pdo->prepare("SELECT cargo FROM candidatos WHERE id_candidato = ?");
        $stmtCargo->execute([$idAlvo]);
        $candAtual = $stmtCargo->fetch(PDO::FETCH_ASSOC);

        if ($candAtual) {
            $novoCargo = ($candAtual['cargo'] === 'admin') ? 'estudante' : 'admin';

            $stmtUpdateCargo = $pdo->prepare("UPDATE candidatos SET cargo = ? WHERE id_candidato = ?");
            $stmtUpdateCargo->execute([$novoCargo, $idAlvo]);
        }

        header("Location: index.php?rota=admin&msg=cargo_alterado");
        exit;
    }
}

if (isset($_GET['acao']) && $_GET['acao'] === 'exportar') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ranking_candidatos.csv');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

    fputcsv($output, ['ID', 'Nome', 'E-mail', 'Cargo', 'Nível', 'Pontuação'], ';');

    $stmtExp = $pdo->query("SELECT id_candidato, nome, email, cargo, nivel, pontuacao FROM candidatos ORDER BY pontuacao DESC");
    while ($row = $stmtExp->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [
            $row['id_candidato'],
            $row['nome'],
            $row['email'],
            $row['cargo'],
            $row['nivel'] ?? 'Não avaliado',
            $row['pontuacao'] . ' pts'
        ], ';');
    }
    fclose($output);
    exit;
}

$stmtStats = $pdo->query("SELECT 
    SUM(CASE WHEN nivel LIKE '%Iniciante%' THEN 1 ELSE 0 END) as iniciante,
    SUM(CASE WHEN nivel LIKE '%Intermediário%' THEN 1 ELSE 0 END) as intermediario,
    SUM(CASE WHEN nivel LIKE '%Avançado%' THEN 1 ELSE 0 END) as avancado,
    SUM(CASE WHEN nivel IS NULL OR nivel = '' THEN 1 ELSE 0 END) as nao_avaliado
    FROM candidatos");
$estatisticas = $stmtStats->fetch(PDO::FETCH_ASSOC);

$filtroNivel = $_GET['filtro'] ?? '';

if (!empty($filtroNivel)) {
    if ($filtroNivel === 'nao_avaliado') {
        $stmt = $pdo->prepare("SELECT id_candidato, nome, email, cargo, nivel, pontuacao FROM candidatos WHERE nivel IS NULL OR nivel = '' ORDER BY pontuacao DESC");
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare("SELECT id_candidato, nome, email, cargo, nivel, pontuacao FROM candidatos WHERE nivel LIKE ? ORDER BY pontuacao DESC");
        $stmt->execute(["%$filtroNivel%"]);
    }
} else {
    $stmt = $pdo->query("SELECT id_candidato, nome, email, cargo, nivel, pontuacao FROM candidatos ORDER BY pontuacao DESC");
}

$candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'views/admin.php';
