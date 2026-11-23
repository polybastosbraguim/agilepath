<?php

/** 
 * @var array $resultado
 * @var array $total
 */
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Resultado - Agile Path</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <style>
        .result-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .score-circle {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: #007bff;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: bold;
            margin: 20px auto;
            border: 5px solid #e9ecef;
        }

        .score-circle span {
            font-size: 14px;
            font-weight: normal;
            opacity: 0.9;
        }

        .nivel-badge {
            display: inline-block;
            padding: 6px 15px;
            background: #e7f1ff;
            color: #007bff;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0 20px 0;
        }

        .btn-action {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-dashboard {
            background: #007bff;
            color: white;
        }

        .btn-dashboard:hover {
            background: #0056b3;
        }
    </style>

</head>

<body>

    <?php

    $pontos = $pontos ?? 0;
    $nivel = $nivel ?? 'Não avaliado';
    $totalAcertos = $totalAcertos ?? 0;
    ?>

    <div class="result-container">
        <h2>Resultado do Teste</h2>
        <p>Parabéns por concluir, <strong><?php echo htmlspecialchars($_SESSION['nome']); ?></strong>!</p>

        <div class="score-circle">
            <?php echo $pontos; ?>
            <span>de 25 pts</span>
        </div>

        <p>Sua classificação técnica estimada:</p>
        <div>
            <span class="nivel-badge"><?php echo $nivel; ?></span>
        </div>

        <p><small>Você acertou <?php echo $totalAcertos; ?> questões no total (incluindo os trechos de código
                práticos).</small></p>

        <div>
            <a href="index.php?rota=dashboard" class="btn-action btn-dashboard">Voltar para o Painel</a>
        </div>
    </div>

</body>

</html>