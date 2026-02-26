<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para o index.php na raiz do projeto
    // O uso de um caminho relativo fixo ajuda o navegador a manter o contexto correto
    header('Location: ../index.php'); 
    exit;
}