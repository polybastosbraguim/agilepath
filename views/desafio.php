<?php
$nivelCandidato = $nivelCandidato ?? 'Não definido';
$dataLimite = $dataLimite ?? '3 dias';
$desafio = $desafio ?? null;
$msgSucesso = $msgSucesso ?? '';
$msgErro = $msgErro ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Desafio de Programação - Agile Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
        }

        .challenge-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fa-solid fa-code text-primary me-2"></i> Desafio Técnico</h2>
                    <a href="index.php?rota=dashboard" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Dashboard
                    </a>
                </div>

                <?php if (!empty($msgSucesso)): ?>
                    <div class="alert alert-success"><?php echo $msgSucesso; ?></div>
                <?php endif; ?>

                <?php if (!empty($msgErro)): ?>
                    <div class="alert alert-danger"><?php echo $msgErro; ?></div>
                <?php endif; ?>

                <div class="challenge-card mb-4">
                    <span class="badge bg-primary mb-3 px-3 py-2 fs-6">Nível:
                        <?php echo htmlspecialchars($nivelCandidato); ?></span>

                    <?php if ($desafio): ?>
                        <h4 class="fw-bold text-dark mb-3">Enunciado do Problema:</h4>
                        <p class="fs-5 text-secondary p-3 bg-light rounded border">
                            <?php echo nl2br(htmlspecialchars($desafio['desafio_nivel'])); ?></p>

                        <!-- Parágrafo informando o prazo calculado em PHP -->
                        <div class="alert alert-info py-2 small mb-4">
                            <i class="fa-solid fa-clock me-1"></i> Você tem até o dia
                            <strong><?php echo $dataLimite; ?></strong> (72 horas) para resolver este desafio
                            e enviar o arquivo com a solução para o E-mail suporte@agilepath.com com o seguinte assunto
                            "Resolução do Desafio".
                        </div>

                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">Nenhum desafio cadastrado para este nível no momento.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>