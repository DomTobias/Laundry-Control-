<?php
include_once(__DIR__ . '/../../conexao.php');

$sql = "
    SELECT 
        pr.nome AS nome_operador,
        COALESCE(SUM(s.peso), 0) AS total
    FROM operadores pr
    LEFT JOIN secagem s 
        ON pr.id_operador = s.id_operador
        AND DATE(s.data_inicio) = CURDATE()
    GROUP BY pr.id_operador, pr.nome
    HAVING total > 0
    ORDER BY total DESC
";

$res = mysqli_query($conexao, $sql);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels[] = $row['nome_operador'];
    $dados[]  = (float)$row['total'];
}

$json_operadores = json_encode([
    'labels' => $labels,
    'dados'  => $dados
]);
