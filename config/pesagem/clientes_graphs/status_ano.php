<?php
include_once(__DIR__ . '/../../conexao.php');

$ano = $_GET['ano'] ?? null;

if (!$ano) {
    echo json_encode(['labels' => [], 'dados' => []]);
    exit;
}

$sql = "
    SELECT 
        c.nome_cliente,
        SUM(p.peso) AS total
    FROM clientes c
    JOIN pesagem p 
        ON c.id_cliente = p.id_cliente
    WHERE YEAR(p.data_inicio) = ?
    GROUP BY c.id_cliente, c.nome_cliente
    ORDER BY total DESC
";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'i', $ano);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels[] = $row['nome_cliente'];
    $dados[]  = (float)$row['total'];
}

echo json_encode([
    'labels' => $labels,
    'dados'  => $dados
]);