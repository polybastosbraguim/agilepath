<?php

require_once 'config/database.php';
require_once 'helpers/auth.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php?rota=login");
    exit;
}

$idCandidato = $_SESSION['id'];
$msg = $_GET['msg'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'atualizar_perfil') {
    $novoNome = trim($_POST['nome']);
    $novoEmail = trim($_POST['email']);
    $novoCargo = trim($_POST['cargo']);

    if (!empty($novoNome) && !empty($novoEmail)) {
        $stmtUp = $pdo->prepare("UPDATE candidatos SET nome = ?, email = ?, perfil_usuario = ? WHERE id_candidato = ?");
        $stmtUp->execute([$novoNome, $novoEmail, $novoCargo, $idCandidato]);

        $_SESSION['nome'] = $novoNome;

        header("Location: index.php?rota=perfil&msg=atualizado");
        exit;
    }
}

$stmt = $pdo->prepare("SELECT id_candidato, nome, email, perfil_usuario, nivel, pontuacao FROM candidatos WHERE id_candidato = ?");
$stmt->execute([$idCandidato]);
$candidato = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtRespostas = $pdo->prepare("SELECT COUNT(*) as total FROM respostas_candidato WHERE id_candidato = ?");
$stmtRespostas->execute([$idCandidato]);
$fezTeste = $stmtRespostas->fetch(PDO::FETCH_ASSOC)['total'] > 0;

$podeRefazer = true;

$stmtHistorico = $pdo->prepare("
    SELECT r.*, q.enunciado, q.alternativa_correta 
    FROM respostas_candidato r 
    JOIN questoes q ON r.id_questao = q.id_questao 
    WHERE r.id_candidato = ?
");

$historicoRespostas = [];
try {
    $stmtHistorico->execute([$idCandidato]);
    $historicoRespostas = $stmtHistorico->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {

    $historicoRespostas = [];
}

require 'views/perfil.php';
