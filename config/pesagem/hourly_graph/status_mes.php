<?php
header('Content-Type: application/json');
// Ajuste o caminho da conexão se necessário (3 ou 4 níveis)
include_once(__DIR__ . '/../../conexao.php'); 

$mes = $_GET['mes'] ?? date('m');
$ano = $_GET['ano'] ?? date('Y');

// 1. Descobrir quantos dias tem o mês selecionado
$quantidadeDias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

// 2. Criar um array preenchido com zeros para todos os dias
$dadosFinal = [];
for ($i = 1; $i <= $quantidadeDias; $i++) {
    $diaFormatado = str_pad($i, 2, '0', STR_PAD_LEFT);
    $dadosFinal[$diaFormatado] = 0;
}

// 3. Buscar somas no banco de dados
$sql = "SELECT 
            DATE_FORMAT(data_inicio, '%d') as dia, 
            SUM(peso) as total 
        FROM pesagem 
        WHERE MONTH(data_inicio) = ? AND YEAR(data_inicio) = ?
        GROUP BY dia
        ORDER BY dia ASC";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $mes, $ano);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

// 4. Preencher o array de zeros com os valores reais onde houver pesagem
while ($row = mysqli_fetch_assoc($res)) {
    $dadosFinal[$row['dia']] = (float)$row['total'];
}

// 5. Retornar labels (01, 02...) e dados
echo json_encode([
    'labels' => array_keys($dadosFinal),
    'dados'  => array_values($dadosFinal)
]);
exit;