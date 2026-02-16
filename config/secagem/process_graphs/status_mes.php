<?php
include_once(__DIR__ . '/../../conexao.php');

$mes = $_GET['mes'] ?? null;
$ano = $_GET['ano'] ?? null;

if (!$mes || !$ano) {
    echo json_encode(['labels' => [], 'dados' => []]);
    exit;
}

$sql = "
    SELECT 
        pr.nome AS nome_processo,
        SUM(s.peso) AS total
    FROM secagem s
    JOIN processos pr ON pr.id_processo = s.id_processo
    WHERE MONTH(s.data_inicio) = ?
      AND YEAR(s.data_inicio) = ?
    GROUP BY pr.id_processo, pr.nome
    ORDER BY total DESC
";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $mes, $ano);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels[] = $row['nome_processo'];
    $dados[]  = (float)$row['total'];
}

echo json_encode([
    'labels' => $labels,
    'dados'  => $dados
]);
