<?php
error_reporting(0);
ini_set('display_errors', 0);

include_once(__DIR__ . '/../conexao.php');

header('Content-Type: application/json');

if (!$conexao) {
    echo json_encode(['error' => 'Erro na conexão']);
    exit;
}

$ano  = isset($_GET['ano']) ? (int)$_GET['ano'] : null;
$mes  = isset($_GET['mes']) ? (int)$_GET['mes'] : null;
$data = $_GET['data'] ?? null;

$sql = "
    SELECT 
        d.id_maquina,
        ROUND(
            (AVG(r.tempo) / NULLIF(AVG(d.minuto),0)) * 100,
            2
        ) AS eficiencia_percentual
    FROM dosagem d
    INNER JOIN receita r 
        ON d.id_receita = r.id_receita
";

$conditions = [];
$params = [];
$types = "";

if ($data) {
    $conditions[] = "DATE(d.data) = ?";
    $params[] = $data;
    $types .= "s";
}

if ($ano && !$mes) {
    $conditions[] = "YEAR(d.data) = ?";
    $params[] = $ano;
    $types .= "i";
}

if ($ano && $mes) {
    $conditions[] = "YEAR(d.data) = ? AND MONTH(d.data) = ?";
    $params[] = $ano;
    $params[] = $mes;
    $types .= "ii";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " GROUP BY d.id_maquina ORDER BY d.id_maquina ASC";

$stmt = mysqli_prepare($conexao, $sql);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$labels = [];
$dados  = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = "Máquina " . $row['id_maquina'];
    $dados[]  = (float)($row['eficiencia_percentual'] ?? 0);
}

echo json_encode([
    "labels" => $labels,
    "dados"  => $dados
]);

mysqli_stmt_close($stmt);
mysqli_close($conexao);