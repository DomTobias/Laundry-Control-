<?php
$local = '127.0.0.1:3306';
$username = 'root';
$password = 'Elis@2019!';
$banco = 'laundrycontrol';

$conexao = new mysqli($local, $username, $password, $banco,3306);

if ($conexao->connect_error) {
    die("❌ Erro na conexão: " . $conexao->connect_error);
}

?>