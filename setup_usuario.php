<?php

require_once 'config/database.php';

try {

    $pdo->exec("INSERT IGNORE INTO classificacoes (id_classificacao, nome_nivel) VALUES (1, 'Iniciante'), (2, 'Intermediário'), (3, 'Avançado')");


    $nome = 'Sistema';
    $email = 'sistema@agilepath.com';
    $senha_hash = password_hash('123456', PASSWORD_DEFAULT);
    $perfil = 'Estudante';
    $id_classificacao = 1;

    $stmt = $pdo->prepare("INSERT INTO candidatos (nome, email, senha, perfil_usuario, id_classificacao) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha_hash, $perfil, $id_classificacao]);

    echo "<h1>Sucesso!</h1>";
    echo "<p>Usuário <strong>$email</strong> criado com sucesso!</p>";
    echo "<p>Senha: <strong>123456</strong></p>";
    echo "<a href='login.php'>Ir para a tela de login</a>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
