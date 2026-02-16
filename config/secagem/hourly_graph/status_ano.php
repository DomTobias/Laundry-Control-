<?php
header('Content-Type: application/json');
include_once(__DIR__ . '/../../conexao.php'); 

$ano = $_GET['ano'] ?? date('Y');

// 1. Criar array fixo com os 12 meses preenchidos com zero
$mesesNome = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
$dadosFinal = array_fill(1, 12, 0);

// 2. Buscar somas no banco agrupadas por mês
$sql = "SELECT 
            MONTH(data_inicio) as mes, 
            SUM(peso) as total 
        FROM secagem
        WHERE YEAR(data_inicio) = ?
        GROUP BY MONTH(data_inicio)
        ORDER BY MONTH(data_inicio) ASC";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'i', $ano);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

// 3. Injetar valores reais no array de meses
while ($row = mysqli_fetch_assoc($res)) {
    $dadosFinal[(int)$row['mes']] = (float)$row['total'];
}

// 4. Retornar os nomes dos meses como labels e os valores
echo json_encode([
    'labels' => $mesesNome,
    'dados'  => array_values($dadosFinal)
]);
exit;