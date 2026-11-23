<?php
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT id_candidato, nome, senha, perfil_usuario FROM candidatos WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['id'] = $usuario['id_candidato'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['perfil_usuario'];

        header("Location: dashboard.php");
        exit();
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Agile Path</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: #0b3d91;
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        .login-box {
            margin-top: 40px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .left-side {
            padding: 60px 40px;
            text-align: center;
        }

        .left-side h2 {
            color: #123b88;
            font-weight: bold;
        }

        .left-side p {
            color: #666;
        }

        .icon-circle {

            width: 120px;
            height: 120px;
            border: 3px solid #123b88;
            border-radius: 50%;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #123b88;
            font-size: 45px;
            margin-bottom: 25px;

        }

        .features {

            margin-top: 40px;
            text-align: left;

        }

        .features p {

            margin-bottom: 18px;
            color: #555;

        }

        .right-side {

            padding: 50px;

        }

        .right-side h3 {

            color: #123b88;
            font-weight: bold;
            margin-bottom: 30px;

        }

        .btn-login {

            background: #1457ff;
            color: white;
            width: 100%;
            font-weight: bold;

        }

        .btn-login:hover {

            background: #0c47dc;
            color: white;

        }

        .footer {

            background: #0b3d91;
            color: white;
            padding: 30px;

        }

        .footer a {

            color: white;
            text-decoration: none;

        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 50px;
            height: 48px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            color: #6c757d;
            font-size: 18px;
            padding: 0;
        }

        .toggle-password:hover {
            color: #0d47a1;
        }

        .password {

            position: relative;

        }

        .password i {

            position: absolute;
            right: 15px;
            top: 12px;
            cursor: pointer;

        }

        @media(max-width:768px) {

            .left-side {

                padding: 30px;

            }

            .right-side {

                padding: 30px;

            }

        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg">

        <div class="container">

            <a class="navbar-brand fw-bold" href="#">
                AGILE PATH
            </a>

            <button class="navbar-toggler bg-light" data-bs-toggle="collapse" data-bs-target="#menu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>

                    <li class="nav-item"><a class="nav-link" href="#">Ranking</a></li>

                    <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>

                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2">Entrar</a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <div class="container">

        <div class="login-box row">

            <div class="col-lg-5 left-side">

                <div class="icon-circle">

                    <i class="fa-solid fa-lock"></i>

                </div>

                <h2>Bem-vindo ao Agile Path</h2>

                <p>Valide suas habilidades em TI e alcance o próximo nível.</p>

                <div class="features">

                    <p><i class="fa-regular fa-circle-check text-primary"></i> Testes práticos em tempo real</p>

                    <p><i class="fa-regular fa-circle-check text-primary"></i> Monitoramento anti-fraude</p>

                    <p><i class="fa-regular fa-circle-check text-primary"></i> Classificação automática</p>

                </div>

            </div>

            <div class="col-lg-7 right-side">

                <h3>Acessar conta</h3>

                <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
                    <div class="alert alert-danger text-center">
                        E-mail ou senha incorretos. Tente novamente!
                    </div>
                <?php endif; ?>

                <form action="index.php?rota=auth" method="POST">

                    <div class="mb-3">

                        <label>E-mail</label>

                        <input type="email" class="form-control" name="email" placeholder="seu@email.com" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Senha</label>

                        <div class="password-wrapper">

                            <input type="password" class="form-control" name="senha" id="senha"
                                placeholder="Digite sua senha" required>

                            <button type="button" class="toggle-password" onclick="mostrarSenha()">

                                <i id="iconeSenha" class="fa-regular fa-eye-slash"></i>

                            </button>

                        </div>

                    </div>

                    <div class="text-end mb-3">

                        <a href="#">Esqueceu sua senha?</a>

                    </div>

                    <button class="btn btn-login">

                        Entrar

                    </button>

                    <div class="text-center mt-4">

                        Ainda não tem uma conta?<br>

                        <a href="index.php?rota=cadastro"
                            style="color: #007bff; text-decoration: none; font-weight: bold;">
                            Cadastre-se aqui
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <footer class="footer mt-5">

        <div class="container">

            <div class="row">

                <div class="col-md-4">

                    <h5>AGILE PATH</h5>

                    <p>Classificação e Competências em TI</p>

                </div>

                <div class="col-md-2">

                    <h6>Links</h6>

                    <a href="#">Sobre</a><br>
                    <a href="#">Ranking</a><br>
                    <a href="#">Contato</a>

                </div>

                <div class="col-md-3">

                    <h6>Suporte</h6>

                    <a href="#">FAQ</a><br>
                    <a href="#">Termos</a><br>
                    <a href="#">Privacidade</a>

                </div>

                <div class="col-md-3">

                    <h6>Siga-nos</h6>

                    <i class="fab fa-linkedin fa-lg me-3"></i>
                    <i class="fab fa-github fa-lg me-3"></i>
                    <i class="fab fa-instagram fa-lg"></i>

                </div>

            </div>

            <hr>

            <div class="text-center">

                © <?php echo date('Y') ?> Agile Path. Todos os direitos reservados.

            </div>

        </div>

    </footer>

    <script>
        function mostrarSenha() {

            const senha = document.getElementById("senha");
            const icone = document.getElementById("iconeSenha");

            if (senha.type === "password") {

                senha.type = "text";
                icone.classList.remove("fa-eye-slash");
                icone.classList.add("fa-eye");

            } else {

                senha.type = "password";
                icone.classList.remove("fa-eye");
                icone.classList.add("fa-eye-slash");

            }

        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>