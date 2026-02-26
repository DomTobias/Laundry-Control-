<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../conexao.php';

if (!$conexao) {
    echo json_encode(['error' => 'Erro conexão']);
    exit;
}

$sql = "
    SELECT 
        d.id_maquina,
        ROUND(
            AVG(
                CAST(d.minuto AS SIGNED) - 
                CAST(r.tempo AS SIGNED)
            ),2
        ) AS media_desvio
    FROM dosagem d
    INNER JOIN receita r 
        ON d.id_receita = r.id_receita
    GROUP BY d.id_maquina
    ORDER BY media_desvio DESC
";

$result = mysqli_query($conexao, $sql);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = "Máquina " . $row['id_maquina'];
    $dados[]  = (float)$row['media_desvio'];
}

echo json_encode([
    "labels" => $labels,
    "dados"  => $dados
]);

mysqli_close($conexao);