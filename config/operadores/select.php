<?php
include_once('../config/conexao.php');

$sql_operadores = "SELECT * FROM operadores";
$result_operadores = mysqli_query($conexao, $sql_operadores);

if (!$result_operadores) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

?>