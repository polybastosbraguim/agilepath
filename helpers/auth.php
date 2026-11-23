<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('verificarLogin')) {
    function verificarLogin()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: index.php?rota=login");
            exit;
        }
    }
}
