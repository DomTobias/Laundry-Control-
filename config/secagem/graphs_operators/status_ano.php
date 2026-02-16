<?php
include_once(__DIR__ . '/../../conexao.php');

$ano = $_GET['ano'] ?? null;

if (!$ano) {
    echo json_encode(['labels' => [], 'dados' => []]);
    exit;
}

$sql = "
    SELECT 
        pr.nome AS nome_operador,
        SUM(s.peso) AS total
    FROM secagem s
    JOIN operadores pr ON pr.id_operador = s.id_operador
    WHERE YEAR(s.data_inicio) = ?
    GROUP BY pr.id_operador, pr.nome
    ORDER BY total DESC
";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'i', $ano);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels[] = $row['nome_operador'];
    $dados[]  = (float)$row['total'];
}

echo json_encode([
    'labels' => $labels,
    'dados'  => $dados
]);
