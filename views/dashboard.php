<?php
$nome = $nome ?? $_SESSION['nome'] ?? 'Usuário';
$nivel = $nivel ?? null;
$pontuacao = $pontuacao ?? 0;
$posicao_global = $posicao_global ?? 1;
$ranking = $ranking ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Agile Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fb;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .progress {
            height: 10px;
        }

        .sidebar-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
            padding: 10px;
            border-top: 1px solid #ddd;
            z-index: 1000;
        }
    </style>
</head>

<body class="pb-5">

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Olá, <?php echo htmlspecialchars($nome); ?></h3>
            <div>
                <?php if (!empty($nivel) && $nivel !== 'Não avaliado'): ?>
                    <a href="index.php?rota=certificado" class="btn btn-primary">
                        <i class="fa-solid fa-file-pdf me-1"></i> Baixar Certificado
                    </a>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled title="Faça o teste para liberar o certificado">
                        <i class="fa-solid fa-lock me-1"></i> Baixar Certificado
                    </button>
                <?php endif; ?>
                <a href="index.php?rota=perfil" class="btn btn-outline-primary">
                    <i class="fa-solid fa-user-gear me-1"></i> Ver Meus Dados
                </a>
                <a href="index.php?rota=sair" class="btn btn-danger">Sair do Sistema</a>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4 stat-card text-center d-flex flex-column justify-content-center">
                <p class="text-muted mb-1">Seu nível</p>
                <h2 class="text-primary fw-bold"><?php echo htmlspecialchars($nivel ?: 'Não avaliado'); ?></h2>

                <div class="row justify-content-center mb-4">
                    <div class="col-lg-7">
                        <div class="stat-card p-4 text-center">

                            <?php if (!empty($nivel) && $nivel !== 'Não avaliado'): ?>
                                <a href="index.php?rota=desafio" class="btn btn-dark w-100 py-3 fw-bold">
                                    <i class="fa-solid fa-code me-2"></i> INICIAR DESAFIO DE CÓDIGO
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100 py-3 fw-bold" disabled>
                                    <i class="fa-solid fa-lock me-2"></i> FAÇA O TESTE PRIMEIRO PARA LIBERAR O DESAFIO
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 stat-card text-center d-flex flex-column justify-content-center">
                <p class="text-muted mb-1">Pontuação final</p>
                <h2 class="fw-bold"><?php echo round($pontuacao); ?></h2>
                <div class="progress mt-2">
                    <div class="progress-bar" style="width: <?php echo max(0, min(100, $pontuacao)); ?>%"></div>
                </div>
            </div>
            <div class="col-md-4 stat-card text-center d-flex flex-column justify-content-center">
                <p class="text-muted mb-1">Ranking Global</p>
                <h2 class="fw-bold">#<?php echo $posicao_global; ?></h2>
                <a href="#secaoRanking" class="btn btn-outline-primary btn-sm mt-1">Ver Ranking</a>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 mb-3">
                <div class="stat-card h-100 d-flex flex-column text-center p-4">
                    <h5>Próximos Passos</h5>
                    <p class="text-muted small">Valide novas competências e suba de nível no Ranking Global.</p>

                    <div class="mt-3">
                        <?php if (!empty($fezTeste)): ?>
                            <button class="btn btn-secondary w-100 py-3 fw-bold" disabled
                                title="Você já concluiu a avaliação técnica.">
                                <i class="fa-solid fa-lock me-2"></i> TESTE JÁ REALIZADO
                            </button>
                            <p class="text-center mt-2 small text-muted">Avaliação concluída com sucesso.</p>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary w-100 py-3 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#modalRegrasTeste">
                                <i class="fa-solid fa-play me-2"></i> INICIAR NOVO TESTE
                            </button>
                            <p class="text-center mt-2 small text-muted">Tempo estimado: 40 min</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" id="secaoRanking">
            <div class="col-lg-10">
                <div class="stat-card p-4">
                    <h4 class="mb-3"><i class="fa-solid fa-trophy text-warning me-2"></i> Ranking Global de Candidatos
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th># Pos.</th>
                                    <th>Nome</th>
                                    <th>Nível</th>
                                    <th class="text-center">Pontuação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ranking)): ?>
                                    <?php foreach ($ranking as $index => $c): ?>
                                        <tr>
                                            <td class="fw-bold">
                                                <?php if ($index === 0): ?>
                                                    <span class="text-warning"><i class="fa-solid fa-medal"></i> #1</span>
                                                <?php elseif ($index === 1): ?>
                                                    <span class="text-secondary"><i class="fa-solid fa-medal"></i> #2</span>
                                                <?php elseif ($index === 2): ?>
                                                    <span class="text-danger"><i class="fa-solid fa-medal"></i> #3</span>
                                                <?php else: ?>
                                                    #<?php echo $index + 1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($c['nome']); ?></td>
                                            <td><?php echo htmlspecialchars($c['nivel'] ?? 'Não avaliado'); ?></td>
                                            <td class="text-center fw-bold"><?php echo $c['pontuacao']; ?> pts</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Nenhum candidato no ranking
                                            ainda.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav d-flex justify-content-around">
        <a href="index.php?rota=dashboard" class="text-decoration-none text-dark text-center"><i
                class="fa-solid fa-house"></i><br><small>Início</small></a>

        <?php if (!empty($fezTeste)): ?>
            <span class="text-muted text-center" style="cursor: not-allowed; opacity: 0.6;" title="Teste já realizado">
                <i class="fa-solid fa-lock"></i><br><small>Teste</small>
            </span>
        <?php else: ?>
            <a href="index.php?rota=teste" class="text-decoration-none text-dark text-center"><i
                    class="fa-solid fa-play"></i><br><small>Teste</small></a>
        <?php endif; ?>

        <a href="#secaoRanking" class="text-decoration-none text-dark text-center"><i
                class="fa-solid fa-trophy"></i><br><small>Ranking</small></a>
    </nav>

    <!-- Modal de Regras e Sistema Anti-Fraude -->
    <div class="modal fade" id="modalRegrasTeste" tabindex="-1" aria-labelledby="modalRegrasTesteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="modalRegrasTesteLabel">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> Regras da Avaliação
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Antes de iniciar o seu teste técnico na <strong>Agile Path</strong>,
                        atente-se às diretrizes oficiais:</p>

                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="fa-solid fa-shield-halved text-primary me-2"></i> <strong>Sistema
                                Anti-Fraude:</strong> O ambiente monitora a navegação. Trocar de aba ou tentar burlar o
                            sistema poderá invalidar a sua tentativa.</li>
                        <li class="mb-2"><i class="fa-solid fa-clock text-primary me-2"></i> <strong>Tempo
                                Estimado:</strong> Reserve cerca de 40 minutos de foco total sem interrupções.</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-exclamation text-primary me-2"></i>
                            <strong>Tentativa Única:</strong> O teste só pode ser realizado uma vez por ciclo (novas
                            tentativas apenas após 6 meses).
                        </li>
                        <li class="mb-3"><i class="fa-solid fa-wifi text-primary me-2"></i> <strong>Conexão
                                Estável:</strong> Certifique-se de que sua internet está estável antes de prosseguir.
                        </li>
                    </ul>

                    <div class="alert alert-warning py-2 small mb-0">
                        <i class="fa-solid fa-info-circle me-1"></i> Ao clicar em "Estou ciente e iniciar", a avaliação
                        começará imediatamente.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="index.php?rota=teste" class="btn btn-primary px-4 fw-bold">Estou Ciente e Iniciar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>