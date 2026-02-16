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
        c.nome_cliente,
        SUM(p.peso) AS total
    FROM clientes c
    JOIN pesagem p 
        ON c.id_cliente = p.id_cliente
    WHERE MONTH(p.data_inicio) = ? AND YEAR(p.data_inicio) = ?
    GROUP BY c.id_cliente, c.nome_cliente
    ORDER BY total DESC
";

$stmt = mysqli_prepare($conexao, $sql);
// 'ii' pois mês e ano costumam ser inteiros
mysqli_stmt_bind_param($stmt, 'ii', $mes, $ano);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels[] = $row['nome_cliente'];
    $dados[]  = (float)$row['total']; // Usar float para pesos decimais
}

echo json_encode([
    'labels' => $labels,
    'dados'  => $dados
]);