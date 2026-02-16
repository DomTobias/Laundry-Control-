<?php
// Limpa qualquer saída anterior para não corromper o JSON
ob_clean(); 
header('Content-Type: application/json');

// Ajuste o caminho conforme sua estrutura real
include_once(__DIR__ . '/../../conexao.php'); 

$data = $_GET['data'] ?? null;

if (!$data) {
    echo json_encode(['error' => 'Data não fornecida']);
    exit;
}

$sql = "WITH RECURSIVE horas AS (
            SELECT 0 AS hora
            UNION ALL
            SELECT hora + 1 FROM horas WHERE hora < 23
        )
        SELECT
            h.hora as hora_index,
            COALESCE(SUM(p.peso), 0) AS total_peso
        FROM horas h
        LEFT JOIN secagem p
            ON HOUR(p.hora_inicio) = h.hora
           AND p.data_inicio = ?
        GROUP BY h.hora
        ORDER BY h.hora";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 's', $data);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$dadosFinal = array_fill(0, 24, 0);
while ($row = mysqli_fetch_assoc($res)) {
    $dadosFinal[(int)$row['hora_index']] = (float)$row['total_peso'];
}

$labels = [];
$valores = [];
foreach ($dadosFinal as $h => $peso) {
    $labels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ":00";
    $valores[] = $peso;
}

echo json_encode([
    'labels' => $labels,
    'dados' => $valores
]);
exit;