<?php
$msgSucesso = $msgSucesso ?? '';
$msgErro = $msgErro ?? '';
$desafiosCadastrados = $desafiosCadastrados ?? [];
$filtroNivel = $_GET['categoria'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar Desafios - Agile Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
        }

        .card-custom {
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
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fa-solid fa-code text-primary me-2"></i> Gerenciamento de Desafios</h2>
                    <a href="index.php?rota=admin" class="btn btn-outline-dark">
                        <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Painel Admin
                    </a>
                </div>

                <?php if (!empty($msgSucesso)): ?>
                    <div class="alert alert-success"><?php echo $msgSucesso; ?></div>
                <?php endif; ?>

                <?php if (!empty($msgErro)): ?>
                    <div class="alert alert-danger"><?php echo $msgErro; ?></div>
                <?php endif; ?>

                <!-- Formulário de Cadastro -->
                <div class="card-custom mb-5">
                    <h4 class="mb-3 text-secondary"><i class="fa-solid fa-plus-circle me-1"></i> Cadastrar Novo Desafio
                    </h4>
                    <form action="index.php?rota=admin_cadastrar_desafio" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nível do Desafio:</label>
                            <select name="nivel" class="form-select" required>
                                <option value="">Selecione o nível...</option>
                                <option value="Junior">Junior</option>
                                <option value="Pleno">Pleno</option>
                                <option value="Senior">Senior</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Enunciado / Descrição do Problema:</label>
                            <textarea name="desafio_nivel" class="form-control" rows="4"
                                placeholder="Escreva o enunciado detalhado do desafio técnico..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="fa-solid fa-save me-1"></i> Salvar Desafio
                        </button>
                    </form>
                </div>

                <div class="card-custom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
                        <h4 class="mb-0 text-secondary"><i class="fa-solid fa-list me-1"></i> Desafios Cadastrados</h4>

                        <div class="btn-group" role="group">
                            <a href="index.php?rota=admin_cadastrar_desafio"
                                class="btn btn-sm <?php echo empty($filtroNivel) ? 'btn-dark' : 'btn-outline-dark'; ?>">Todos</a>
                            <a href="index.php?rota=admin_cadastrar_desafio&categoria=Junior"
                                class="btn btn-sm <?php echo $filtroNivel === 'Junior' ? 'btn-primary' : 'btn-outline-primary'; ?>">Junior</a>
                            <a href="index.php?rota=admin_cadastrar_desafio&categoria=Pleno"
                                class="btn btn-sm <?php echo $filtroNivel === 'Pleno' ? 'btn-primary' : 'btn-outline-primary'; ?>">Pleno</a>
                            <a href="index.php?rota=admin_cadastrar_desafio&categoria=Senior"
                                class="btn btn-sm <?php echo $filtroNivel === 'Senior' ? 'btn-primary' : 'btn-outline-primary'; ?>">Senior</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th style="width: 20%;">Nível</th>
                                    <th style="width: 70%;">Enunciado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($desafiosCadastrados)): ?>
                                    <?php foreach ($desafiosCadastrados as $d): ?>
                                        <tr>
                                            <td class="fw-bold">#<?php echo $d['id']; ?></td>
                                            <td>
                                                <span class="badge bg-secondary px-2 py-1">
                                                    <?php echo htmlspecialchars($d['nivel']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo nl2br(htmlspecialchars($d['desafio_nivel'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">Nenhum desafio encontrado para
                                            esta categoria.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>