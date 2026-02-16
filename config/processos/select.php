<?php
include_once('../config/conexao.php');

$sql_processos = "SELECT * FROM processos";
$result_processos = mysqli_query($conexao, $sql_processos);

if (!$result_processos) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
?>