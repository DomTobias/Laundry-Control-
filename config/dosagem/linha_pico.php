<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../conexao.php';

$data = $_GET['data'] ?? date('Y-m-d');

$sql = "
    SELECT 
        d.id_maquina,
        TIME_FORMAT(d.hora, '%H:%i') AS hora_formatada,
        (
            CAST(d.minuto AS SIGNED) - 
            CAST(r.tempo AS SIGNED)
        ) AS desvio
    FROM dosagem d
    INNER JOIN receita r 
        ON d.id_receita = r.id_receita
    WHERE DATE(d.data) = ?
    ORDER BY d.hora ASC
";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $data);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$labels = [];
$maquinas = [];

while ($row = mysqli_fetch_assoc($result)) {

    $hora = $row['hora_formatada'];
    $maq  = "Máquina " . $row['id_maquina'];
    $desv = (float)$row['desvio'];

    if (!in_array($hora, $labels)) {
        $labels[] = $hora;
    }

    if (!isset($maquinas[$maq])) {
        $maquinas[$maq] = [];
    }

    $maquinas[$maq][$hora] = $desv;
}

$datasets = [];

foreach ($maquinas as $maq => $valores) {

    $dataPoints = [];

    foreach ($labels as $hora) {
        $dataPoints[] = $valores[$hora] ?? null;
    }

    $datasets[] = [
        "label" => $maq,
        "data"  => $dataPoints,
        "fill"  => false,
        "tension" => 0.3
    ];
}

echo json_encode([
    "labels" => $labels,
    "datasets" => $datasets
]);

mysqli_close($conexao);