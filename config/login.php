<?php
session_start();

$envPath = __DIR__ . '/.env';

if (!file_exists($envPath)) {
    die('ERRO: arquivo .env não encontrado em ' . $envPath);
}

$env = parse_ini_file($envPath);

if ($env === false) {
    die('ERRO: não foi possível ler o arquivo .env');
}

$usuario_env = trim($env['APP_USER'] ?? '');
$senha_env   = trim($env['APP_PASS'] ?? '');

$usuario = trim($_POST['usuario'] ?? '');
$senha   = trim($_POST['senha'] ?? '');

if ($usuario === $usuario_env && $senha === $senha_env) {
    $_SESSION['logado'] = true;
    $_SESSION['usuario'] = $usuario;

    header('Location: ../pages/secagem.php');
    exit;
}

header('Location: index.php?erro=1');
exit;
