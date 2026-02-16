<?php
include_once(__DIR__ . '/../../conexao.php');
$sql_stats = "
    SELECT
        COUNT(*)      AS total,
        SUM(peso)     AS soma,
        MAX(peso)     AS maximo,
        MIN(peso)     AS minimo
    FROM pesagem
";

$result_stats = mysqli_query($conexao, $sql_stats);

if (!$result_stats) {
    die("Erro na consulta dos indicadores: " . mysqli_error($conexao));
}

$stats = mysqli_fetch_assoc($result_stats);

// Garantia contra NULL
$total  = $stats['total']  ?? 0;
$soma   = $stats['soma']   ?? 0;
$maximo = $stats['maximo'] ?? 0;
$minimo = $stats['minimo'] ?? 0;

?>