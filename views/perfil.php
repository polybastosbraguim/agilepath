<?php
$msg = $msg ?? '';
$fezTeste = $fezTeste ?? false;
$candidato = $candidato ?? [
    'nome' => '',
    'email' => '',
    'perfil_usuario' => '',
    'nivel' => '',
    'pontuacao' => 0
];
$podeRefazer = $podeRefazer ?? false;
$historicoRespostas = $historicoRespostas ?? [];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus Dados e Perfil - Agile Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
        }

        .profile-card {
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
                    <h2><i class="fa-solid fa-id-card text-primary me-2"></i> Meu Perfil e Desempenho</h2>
                    <div>
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Editar Dados
                        </button>
                        <a href="index.php?rota=dashboard" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                </div>

                <?php if ($msg === 'atualizado'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Dados atualizados com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php
                $bgStatusCard = $fezTeste ? 'bg-success bg-opacity-10 border-success' : 'bg-warning bg-opacity-10 border-warning';
                ?>

                <div
                    class="profile-card mb-4 border border-2 <?php echo $fezTeste ? 'border-success-subtle' : 'border-warning-subtle'; ?>">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-4 text-primary mb-3">
                            <i class="fa-solid fa-user fa-3x"></i>
                        </div>
                        <h3 class="fw-bold"><?php echo htmlspecialchars($candidato['nome']); ?></h3>
                        <p class="text-muted mb-0"><?php echo htmlspecialchars($candidato['email']); ?></p>

                        <span class="badge bg-primary mt-2 px-3 py-2 fs-6">
                            <i class="fa-solid fa-briefcase me-1"></i>
                            <?php echo ucfirst($candidato['perfil_usuario'] ?? 'Estudante'); ?>
                        </span>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 border <?php echo $bgStatusCard; ?>">
                                <span class="text-muted small d-block">Status do Teste</span>
                                <h5 class="fw-bold mt-1 mb-0">
                                    <?php if ($fezTeste): ?>
                                        <span class="text-success"><i class="fa-solid fa-circle-check me-1"></i>
                                            Realizado</span>
                                    <?php else: ?>
                                        <span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i>
                                            Pendente</span>
                                    <?php endif; ?>
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 border">
                                <span class="text-muted small d-block">Nível Alcançado</span>
                                <h5 class="fw-bold mt-1 mb-0 text-primary">
                                    <?php echo htmlspecialchars($candidato['nivel'] ?? 'Não avaliado'); ?>
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 border">
                                <span class="text-muted small d-block">Pontuação Total</span>
                                <h5 class="fw-bold mt-1 mb-0 text-dark">
                                    <?php echo $candidato['pontuacao']; ?> pts
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-4 border">
                                <span class="text-muted small d-block">Restrições (Anti-Trapaça)</span>
                                <h5 class="fw-bold mt-1 mb-0">
                                    <span class="text-success"><i class="fa-solid fa-shield-halved me-1"></i> Sem
                                        restrições</span>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-4 text-center border">
                        <p class="text-muted small mb-2"><i class="fa-solid fa-clock-rotate-left me-1"></i> Política de
                            Nova Tentativa: O teste pode ser refeito após um período de 6 meses.</p>
                        <?php if ($podeRefazer): ?>
                            <a href="index.php?rota=teste" class="btn btn-outline-success btn-sm fw-bold">
                                <i class="fa-solid fa-rotate-right me-1"></i> Refazer Avaliação Agora
                            </a>
                        <?php else: ?>
                            <button class="btn btn-outline-secondary btn-sm fw-bold" disabled>
                                <i class="fa-solid lock me-1"></i> Disponível após o prazo de 6 meses
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($historicoRespostas)): ?>
                    <div class="profile-card mb-4">
                        <h4 class="mb-3"><i class="fa-solid fa-list-check text-warning me-2"></i> Gabarito e Histórico de
                            Respostas</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Questão</th>
                                        <th>Sua Resposta</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historicoRespostas as $h): ?>
                                        <?php $acertou = ($h['resposta_usuario'] === $h['alternativa_correta']); ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($h['enunciado'] ?? 'Questão do Teste'); ?></td>
                                            <td><code><?php echo htmlspecialchars($h['resposta_usuario']); ?></code></td>
                                            <td class="text-center">
                                                <?php if ($acertou): ?>
                                                    <span class="badge bg-success">Acertou</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Errou</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-labelledby="modalEditarPerfilLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="index.php?rota=perfil" method="POST">
                    <input type="hidden" name="acao" value="atualizar_perfil">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="modalEditarPerfilLabel"><i
                                class="fa-solid fa-pen-to-square text-primary me-2"></i> Editar Meus Dados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Nome Completo</label>
                            <input type="text" name="nome" class="form-control"
                                value="<?php echo htmlspecialchars($candidato['nome']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo htmlspecialchars($candidato['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Categoria / Perfil</label>
                            <select name="cargo" class="form-select">
                                <?php $cargoAtual = strtolower($candidato['perfil_usuario'] ?? 'estudante'); ?>
                                <option value="estudante"
                                    <?php echo ($cargoAtual === 'estudante') ? 'selected' : ''; ?>>Estudante</option>
                                <option value="profissional"
                                    <?php echo ($cargoAtual === 'profissional') ? 'selected' : ''; ?>>Profissional
                                </option>
                                <option value="professor"
                                    <?php echo ($cargoAtual === 'professor') ? 'selected' : ''; ?>>Professor</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>