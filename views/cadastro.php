<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Página de Cadastro - AgilePath</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        .container-auth {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .container-auth:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .header-auth {
            text-align: center;
            margin-bottom: 25px;
        }

        .footer-auth {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-auth">
        <div class="header-auth">
            <h1>AgilePath</h1>
            <p>Crie sua conta para começar</p>
        </div>

        <form action="index.php?rota=salvar-cadastro" method="POST" class="form-auth">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" id="nome" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>

            <div class="form-group">
                <label for="perfil">Perfil</label>
                <select name="perfil" id="perfil" required>
                    <option value="Estudante">Estudante</option>
                    <option value="Profissional">Profissional</option>
                    <option value="Professor">Professor</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">Criar Conta</button>
        </form>

        <div class="footer-auth">
            <p>Já tem uma conta? <a href="index.php?rota=login">Entre agora</a></p>
        </div>
    </div>
</body>

</html>