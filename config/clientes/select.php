<?php
include_once('../config/conexao.php');

$sql_clientes = "SELECT * FROM clientes";
$result_clientes = mysqli_query($conexao, $sql_clientes);

if (!$result_clientes) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

?>