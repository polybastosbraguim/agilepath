<?php
require_once 'config/database.php';

$id_candidato = $_SESSION['id'];

$stmt = $pdo->prepare("UPDATE candidatos SET status_teste = 'desqualificado' WHERE id_candidato = ?");
$stmt->execute([$id_candidato]);

exit;
