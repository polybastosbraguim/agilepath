<?php

/** @var array $dados */
$id_atual = $dados[0]['id_questao'];
$total_questoes = 20;

$porcentagem_progresso = ($id_atual / $total_questoes) * 100;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Teste em Tempo Real - AgilePath</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        .codigo-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 15px;
            font-family: Consolas, Monaco, monospace;
            white-space: pre-wrap;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-4">
        <div class="row">

            <div class="col-md-3">
                <div class="card p-3 mb-3">
                    <h6 class="mb-2">Progresso do teste</h6>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar" style="width: <?php echo $porcentagem_progresso; ?>%">
                        </div>
                    </div>
                    <p class="fw-bold">Questão <?php echo $id_atual; ?> de <?php echo $total_questoes; ?></p>
                </div>

                <div class="card p-3 mb-3">
                    <h6 class="mb-3">Navegação</h6>
                    <div class="d-flex flex-wrap">
                        <?php for ($i = 1; $i <= $total_questoes; $i++): ?>
                            <a href="index.php?rota=teste&id=<?php echo $i; ?>"
                                class="btn btn-sm btn-<?php echo ($i == $id_atual) ? 'primary' : 'outline-secondary'; ?> m-1"
                                style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="card p-3 border-danger">
                    <h6 class="text-danger mb-2"><i class="bi bi-shield-lock"></i> Monitoramento</h6>
                    <p class="mb-1">Foco da tela: <strong>Ativo</strong></p>
                    <p class="mb-0">Tentativas de saída: <strong>0</strong></p>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="mb-0">Questão <?php echo $id_atual; ?> de <?php echo $total_questoes; ?></h4>
                        <span class="badge bg-<?php echo ($id_atual > 15) ? 'warning text-dark' : 'secondary'; ?>">
                            <?php echo ($id_atual > 15) ? 'Prática (Código)' : 'Teórica'; ?>
                        </span>
                    </div>

                    <p class="fs-5 mb-3"><?php echo $dados[0]['enunciado']; ?></p>

                    <?php if (!empty($dados[0]['codigo_exemplo'])): ?>
                        <div class="codigo-box mb-4"><?php echo htmlspecialchars($dados[0]['codigo_exemplo']); ?></div>
                    <?php endif; ?>

                    <form action="index.php?rota=salvar_resposta" method="POST">
                        <input type="hidden" name="id_questao" value="<?php echo $id_atual; ?>">

                        <div class="list-group mb-4">
                            <?php foreach ($dados as $opcao): ?>
                                <label class="list-group-item d-flex align-items-center py-3">
                                    <input type="radio" name="id_opcao" value="<?php echo $opcao['id_opcao']; ?>"
                                        class="me-3" required>
                                    <span><?php echo htmlspecialchars($opcao['texto_opcao']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <!--<a href="index.php?rota=teste&id=<?php echo max(1, $id_atual - 1); ?>"
                                class="btn btn-outline-secondary">← Anterior</a>
                            <button type="reset" class="btn btn-outline-danger"><i class="bi bi-trash"></i>
                                Limpar</button>-->

                            <?php if ($id_atual == $total_questoes): ?>
                                <button type="submit" class="btn btn-success">Finalizar Prova ✓</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary">Próxima questão →</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let tentativaDisparada = false;

        document.querySelector('form').addEventListener('submit', function() {
            sessionStorage.setItem('navegando', 'true');
        });

        document.addEventListener("visibilitychange", function() {

            if (document.hidden && !tentativaDisparada && !sessionStorage.getItem('navegando')) {
                tentativaDisparada = true;

                navigator.sendBeacon('index.php?rota=desqualificar');

                alert("Atenção: A troca de abas não é permitida durante a prova. Você foi desqualificado.");
                window.location.href = 'index.php?rota=dashboard';
            }
        });

        window.onload = function() {
            sessionStorage.removeItem('navegando');
        };
    </script>

</body>

</html>