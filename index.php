<?php

session_start();
require_once 'config/database.php';
require_once 'helpers/auth.php';

$rota = $_GET['rota'] ?? 'login';

$rotasProtegidas = ['dashboard', 'teste', 'salvar-resposta', 'salvar_resposta', 'resultado', 'admin'];

if (in_array($rota, $rotasProtegidas)) {
    verificarLogin();
}

switch ($rota) {

    case 'admin':
        require 'controllers/AdminController.php';
        break;

    case 'login':
        require 'views/login.php';
        break;

    case 'auth':
        require 'controllers/AuthController.php';
        break;

    case 'dashboard':
        require 'controllers/DashboardController.php';
        break;

    case 'teste':
        require 'controllers/TesteController.php';
        break;

    case 'salvar-resposta':
    case 'salvar_resposta':
        require 'controllers/SalvarRespostaController.php';
        break;

    case 'resultado':
        require 'controllers/ResultadoController.php';
        break;

    case 'sair':
        require 'controllers/LogoutController.php';
        break;

    case 'cadastro':
        require 'views/cadastro.php';
        break;

    case 'salvar-cadastro':
        require 'controllers/CadastroController.php';
        break;

    case 'desqualificar':
        require 'controllers/DesqualificarController.php';
        break;

    case 'perfil':
        require_once 'controllers/PerfilController.php';
        break;

    case 'desafio':
        require_once 'controllers/DesafioController.php';
        break;

    case 'admin_cadastrar_desafio':
        require_once 'controllers/AdminDesafioController.php';
        break;

    case 'certificado':
        require_once 'controllers/CertificadoController.php';
        break;

    default:
        echo "404 - Página não encontrada";
}
