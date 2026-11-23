<?php

require_once 'config/database.php';

$id_candidato = $_SESSION['id'];

$stmt = $pdo->prepare("
    SELECT 
        SUM(CASE WHEN q.id_questao <= 15 THEN 1 ELSE 2 END) as pontuacao_total,
        COUNT(r.id_resposta) as total_acertos,
        c.perfil_usuario
    FROM respostas_candidato r
    JOIN opcoes_respostas o ON r.id_opcao_escolhida = o.id_opcao
    JOIN questoes q ON r.id_questao = q.id_questao
    JOIN candidatos c ON r.id_candidato = c.id_candidato
    WHERE r.id_candidato = ? AND o.correta = 1
    GROUP BY c.id_candidato, c.perfil_usuario
");
$stmt->execute([$id_candidato]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

$pontos = $dados['pontuacao_total'] ?? 0;
$totalAcertos = $dados['total_acertos'] ?? 0;
$perfil = $dados['perfil_usuario'] ?? 'estudante';

if ($pontos <= 9) {
    $nivel = "Júnior Iniciante";
} elseif ($pontos <= 16) {
    $nivel = "Júnior / Intermediário";
} elseif ($pontos <= 21) {
    $nivel = "Pleno";
} else {

    if ($perfil === 'estudante') {
        $nivel = "Pleno";
    } else {
        $nivel = "Sênior";
    }
}

$stmtUpdate = $pdo->prepare("UPDATE candidatos SET nivel = ?, pontuacao = ? WHERE id_candidato = ?");
$stmtUpdate->execute([$nivel, $pontos, $id_candidato]);

require 'views/resultado.php';
