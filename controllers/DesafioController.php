<?php

require_once 'config/database.php';
require_once 'helpers/auth.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php?rota=login");
    exit;
}

$id_candidato = $_SESSION['id'];

$prazo = new DateTime();
$prazo->modify('+3 days');
$dataLimite = $prazo->format('d/m/Y');

$stmt = $pdo->prepare("SELECT nome, nivel FROM candidatos WHERE id_candidato = ?");
$stmt->execute([$id_candidato]);
$candidato = $stmt->fetch(PDO::FETCH_ASSOC);

$nivelCandidato = $candidato['nivel'] ?? null;
$nomeCandidato = $candidato['nome'] ?? 'Candidato';

if (empty($nivelCandidato) || $nivelCandidato === 'Não avaliado') {
    header("Location: index.php?rota=dashboard&msg=sem_nivel");
    exit;
}

$msgSucesso = '';
$msgErro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo_zip'])) {
    $file = $_FILES['arquivo_zip'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($extensao === 'zip') {
            $para = 'suporte@agilepath.com';
            $assunto = 'Resolução do desafio';
            $mensagem = "O candidato " . $nomeCandidato . " (ID: {$id_candidato}) enviou a resolução do desafio técnico em anexo.";

            $boundary = md5(time());
            $headers = "From: no-reply@agilepath.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

            $body = "--{$boundary}\r\n";
            $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $body .= $mensagem . "\r\n";

            $conteudoArquivo = chunk_split(base64_encode(file_get_contents($file['tmp_name'])));
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Type: application/zip; name=\"" . $file['name'] . "\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; name=\"arquivo_zip\"; filename=\"" . $file['name'] . "\"\r\n\r\n";
            $body .= $conteudoArquivo . "\r\n";
            $body .= "--{$boundary}--";

            @mail($para, $assunto, $body, $headers);

            $msgSucesso = "Resolução enviada com sucesso para suporte@agilepath.com!";
        } else {
            $msgErro = "Por favor, envie um arquivo compactado válido no formato .zip";
        }
    } else {
        $msgErro = "Erro ao carregar o arquivo. Tente novamente.";
    }
}

$palavraChave = 'Junior';
$nivelLower = mb_strtolower($nivelCandidato);
if (str_contains($nivelLower, 'pleno') || str_contains($nivelLower, 'intermediário')) {
    $palavraChave = 'Pleno';
} elseif (str_contains($nivelLower, 'senior') || str_contains($nivelLower, 'sênior') || str_contains($nivelLower, 'avançado')) {
    $palavraChave = 'Senior';
}

$stmtDesafio = $pdo->prepare("SELECT * FROM desafio WHERE nivel LIKE ? ORDER BY RAND() LIMIT 1");
$stmtDesafio->execute(['%' . $palavraChave . '%']);
$desafio = $stmtDesafio->fetch(PDO::FETCH_ASSOC);

require 'views/desafio.php';
