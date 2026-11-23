<?php
$nome = $nome ?? 'Candidato';
$nivel = $nivel ?? 'Junior';
$pontuacao = $pontuacao ?? 0;
$codigoValidacao = $codigoValidacao ?? '00000000';
$dataEmissao = $dataEmissao ?? date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificado - Agile Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                background: white !important;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .certificate-container {
                border: 8px solid #0d6efd !important;
                box-shadow: none !important;
                margin: 0;
                width: 100%;
                max-width: 100%;
            }
        }

        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .certificate-container {
            background: white;
            border: 10px solid #0d6efd;
            border-radius: 12px;
            padding: 50px;
            max-width: 900px;
            margin: 40px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <a href="index.php?rota=dashboard" class="btn btn-outline-dark">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Dashboard
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fa-solid fa-print me-1"></i> Salvar em PDF / Imprimir
            </button>
        </div>

        <div class="certificate-container">
            <div class="mb-4">
                <i class="fa-solid fa-code fa-3x text-primary mb-2"></i>
                <h2 class="fw-bold text-uppercase text-primary m-0">Agile Path</h2>
                <p class="text-muted small">Plataforma de Validação de Competências Técnicas</p>
            </div>

            <h1 class="fw-bold text-dark my-4" style="font-size: 2.3rem;">Certificado de Conclusão</h1>
            <p class="text-secondary fs-5">Certificamos para os devidos fins que</p>

            <h2 class="fw-bold text-dark text-decoration-underline my-3 display-6">
                <?php echo htmlspecialchars($nome); ?></h2>

            <p class="fs-5 text-secondary px-4">
                concluiu com êxito a avaliação técnica, alcançando o nível
                <strong class="text-dark"><?php echo htmlspecialchars($nivel); ?></strong>
                com pontuação de <strong class="text-dark"><?php echo round($pontuacao); ?> pts</strong>.
            </p>

            <div class="row mt-5 pt-4 border-top align-items-center text-start">
                <div class="col-sm-6 text-muted small">
                    <p class="mb-1">Emitido em: <strong><?php echo $dataEmissao; ?></strong></p>
                    <p class="mb-0">Código de Validação: <strong><?php echo $codigoValidacao; ?></strong></p>
                </div>
                <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                    <div class="fw-bold text-primary fs-5">Equipe Agile Path</div>
                    <div class="text-muted small">Validação Oficial de Perfil</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>