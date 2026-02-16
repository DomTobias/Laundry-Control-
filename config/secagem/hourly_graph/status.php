<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

include_once(__DIR__ . '/../../conexao.php');

// DIA ATUAL AUTOMÁTICO
$data = date('Y-m-d');

$sql = "
SELECT 
    LPAD(h.hora, 2, '0') AS hora,
    COALESCE(SUM(p.peso), 0) AS total_peso
FROM (
    SELECT 0 hora UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
    UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
    UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
    UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
    UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19
    UNION ALL SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23
) h
LEFT JOIN secagem p
    ON HOUR(p.hora_inicio) = h.hora
   AND p.data_inicio = ?
GROUP BY h.hora
ORDER BY h.hora
";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 's', $data);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels[] = $row['hora'] . ':00';
    $dados[]  = (float) $row['total_peso'];
}

echo json_encode([
    'labels' => $labels,
    'dados'  => $dados
]);
exit;
