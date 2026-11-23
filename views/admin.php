<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel do Administrador - Agile Path</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #f5f7fb;
        }

        .admin-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .bg-info {
            --bs-bg-opacity: 1;
            background-color: rgb(19, 101, 117) !important;
        }

        .text-warning {
            --bs-text-opacity: 1;
            color: rgb(68 174 252) !important;
        }
    </style>
</head>

<body>
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>Painel do Administrador</h3>
                <p class="text-muted mb-0">Gerenciamento de candidatos, níveis e ranking global.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="index.php?rota=admin_cadastrar_desafio" class="btn btn-outline-primary">
                    <i class="fa-solid fa-code me-1"></i> Cadastrar Desafio
                </a>
                <button class="btn btn-outline-success"><i class="fa-solid fa-download"></i> Baixar Planilha
                    (CSV)</button>
                <a href="index.php?rota=dashboard" class="btn btn-outline-dark"><i class="fa-solid fa-arrow-left"></i>
                    Voltar</a>
                <a href="index.php?rota=sair" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i>
                    Sair</a>
            </div>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'excluido'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Candidato excluído com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['msg'] === 'resetado'): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Teste do candidato resetado com sucesso! Ele já pode refazer a prova.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['msg'] === 'cargo_alterado'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Cargo do candidato alterado com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="row mb-4">

            <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 justify-content-center">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary me-3">
                            <i class="fa-solid fa-users fa-2x"></i>
                        </div>
                        <div>
                            <span class="text-muted small">Total de Candidatos</span>
                            <h2 class="fw-bold mb-0"><?php echo isset($candidatos) ? count($candidatos) : 0; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-3 bg-white rounded-4">
                    <h6 class="text-muted mb-2"><i class="fa-solid fa-chart-pie me-1"></i> Distribuição de Níveis dos
                        Candidatos</h6>
                    <div style="height: 140px; position: relative;">
                        <canvas id="graficoNiveis"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="card border-0 shadow-sm p-2 rounded-4 h-100 justify-content-center">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 ps-2"><i
                                class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" id="filtroTabela"
                            class="form-control border-0 bg-transparent shadow-none fs-7"
                            placeholder="Pesquisar por nome...">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div
                    class="card border-0 shadow-sm p-2 rounded-4 d-flex flex-row flex-wrap align-items-center justify-content-lg-end gap-1 bg-white">
                    <span class="text-muted small fw-bold me-1 ps-2"><i class="fa-solid fa-filter me-1"></i>
                        Filtros:</span>
                    <a href="index.php?rota=admin"
                        class="btn btn-sm px-2 py-1 <?php echo empty($_GET['filtro']) ? 'btn-dark' : 'btn-outline-dark'; ?>">Todos</a>
                    <a href="index.php?rota=admin&filtro=Iniciante"
                        class="btn btn-sm px-2 py-1 <?php echo (isset($_GET['filtro']) && $_GET['filtro'] === 'Iniciante') ? 'btn-primary' : 'btn-outline-primary'; ?>">Iniciantes</a>
                    <a href="index.php?rota=admin&filtro=Intermediário"
                        class="btn btn-sm px-2 py-1 <?php echo (isset($_GET['filtro']) && $_GET['filtro'] === 'Intermediário') ? 'btn-warning text-dark' : 'btn-outline-warning text-dark'; ?>">Intermediários</a>
                    <a href="index.php?rota=admin&filtro=Avançado"
                        class="btn btn-sm px-2 py-1 <?php echo (isset($_GET['filtro']) && $_GET['filtro'] === 'Avançado') ? 'btn-success' : 'btn-outline-success'; ?>">Avançados</a>
                    <a href="index.php?rota=admin&filtro=nao_avaliado"
                        class="btn btn-sm px-2 py-1 <?php echo (isset($_GET['filtro']) && $_GET['filtro'] === 'nao_avaliado') ? 'btn-secondary' : 'btn-outline-secondary'; ?>">Não
                        Avaliados</a>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <h4 class="mb-3"><i class="fa-solid fa-trophy text-warning me-2"></i> Ranking Global e Candidatos</h4>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th># Pos.</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Cargo</th>
                            <th>Nível</th>
                            <th class="text-center">Pontuação</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($candidatos)): ?>
                            <?php foreach ($candidatos as $index => $c): ?>
                                <tr>
                                    <td class="fw-bold">
                                        <?php if ($index === 0 && empty($_GET['filtro'])): ?>
                                            <span class="text-warning"><i class="fa-solid fa-medal"></i> #1</span>
                                        <?php elseif ($index === 1 && empty($_GET['filtro'])): ?>
                                            <span class="text-secondary"><i class="fa-solid fa-medal"></i> #2</span>
                                        <?php elseif ($index === 2 && empty($_GET['filtro'])): ?>
                                            <span class="text-danger"><i class="fa-solid fa-medal"></i> #3</span>
                                        <?php else: ?>
                                            #<?php echo $index + 1; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($c['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($c['email']); ?></td>
                                    <td>
                                        <span
                                            class="badge bg-<?php echo (isset($c['cargo']) && $c['cargo'] === 'admin') ? 'success' : 'info'; ?>">
                                            <?php echo ucfirst($c['cargo'] ?? 'estudante'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $nivelCandidato = $c['nivel'] ?? 'Não avaliado';
                                        $classeBadge = 'bg-secondary';

                                        if (str_contains($nivelCandidato, 'Iniciante')) {
                                            $classeBadge = 'bg-primary';
                                        } elseif (str_contains($nivelCandidato, 'Intermediário')) {
                                            $classeBadge = 'bg-warning text-dark';
                                        } elseif (str_contains($nivelCandidato, 'Avançado')) {
                                            $classeBadge = 'bg-success';
                                        }
                                        ?>
                                        <span
                                            class="badge <?php echo $classeBadge; ?>"><?php echo htmlspecialchars($nivelCandidato); ?></span>
                                    </td>
                                    <td class="text-center fw-bold"><?php echo $c['pontuacao']; ?> pts</td>
                                    <td class="text-center">

                                        <a href="index.php?rota=admin&acao=mudar_cargo&id=<?php echo $c['id_candidato']; ?>"
                                            class="btn btn-sm btn-outline-primary me-1" title="Alternar Cargo (Admin/Estudante)"
                                            onclick="return confirm('Deseja alternar o cargo deste usuário?');">
                                            <i class="fa-solid fa-user-shield"></i>
                                        </a>

                                        <a href="index.php?rota=admin&acao=resetar&id=<?php echo $c['id_candidato']; ?>"
                                            class="btn btn-sm btn-warning me-1" title="Resetar Teste"
                                            onclick="return confirm('Tem certeza que deseja zerar o teste deste candidato?');">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </a>

                                        <a href="index.php?rota=admin&acao=excluir&id=<?php echo $c['id_candidato']; ?>"
                                            class="btn btn-sm btn-danger" title="Excluir Candidato"
                                            onclick="return confirm('Atenção: Deseja realmente excluir este candidato permanentemente?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Nenhum candidato encontrado com este
                                    filtro.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('graficoNiveis').getContext('2d');
        const graficoNiveis = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Iniciantes', 'Intermediários', 'Avançados', 'Não Avaliados'],
                datasets: [{
                    data: [
                        <?php echo isset($estatisticas['iniciante']) ? $estatisticas['iniciante'] : 0; ?>,
                        <?php echo isset($estatisticas['intermediario']) ? $estatisticas['intermediario'] : 0; ?>,
                        <?php echo isset($estatisticas['avancado']) ? $estatisticas['avancado'] : 0; ?>,
                        <?php echo isset($estatisticas['nao_avaliado']) ? $estatisticas['nao_avaliado'] : 0; ?>
                    ],
                    backgroundColor: ['#0d6efd', '#ffc107', '#198754', '#6c757d'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        document.getElementById('filtroTabela').addEventListener('keyup', function() {
            let termo = this.value.toLowerCase();
            let linhas = document.querySelectorAll('tbody tr');

            linhas.forEach(linha => {
                let textoLinha = linha.innerText.toLowerCase();
                linha.style.display = textoLinha.includes(termo) ? '' : 'none';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>