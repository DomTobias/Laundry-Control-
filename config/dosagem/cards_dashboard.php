<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../conexao.php';

$data = $_GET['data'] ?? date('Y-m-d');

if (!$conexao) {
    echo json_encode(['error' => 'Erro conexão']);
    exit;
}

/*
    🔹 MÉTRICAS:
    1) Eficiência Geral
    2) Total de Ciclos
    3) Média Real
    4) Percentual de Processos Atrasados
*/

$sql = "
SELECT 
    /* 1️⃣ Eficiência Geral */
    ROUND(
        (AVG(r.tempo) / NULLIF(AVG(d.minuto),0)) * 100,
        2
    ) AS eficiencia_geral,

    /* 2️⃣ Total de Ciclos */
    COUNT(*) AS total_ciclos,

    /* 3️⃣ Média Real */
    ROUND(AVG(d.minuto),2) AS media_real,

    /* 4️⃣ Percentual de Processos Atrasados */
    ROUND(
        (SUM(CASE 
            WHEN (CAST(d.minuto AS SIGNED) - CAST(r.tempo AS SIGNED)) > 0 
            THEN 1 ELSE 0 END) 
        / NULLIF(COUNT(*),0)) * 100,
        2
    ) AS percentual_atraso

FROM dosagem d
INNER JOIN receita r 
    ON d.id_receita = r.id_receita
WHERE DATE(d.data) = ?
";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $data);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

echo json_encode([
    "eficiencia_geral"  => (float)($row['eficiencia_geral'] ?? 0),
    "total_ciclos"      => (int)($row['total_ciclos'] ?? 0),
    "media_real"        => (float)($row['media_real'] ?? 0),
    "percentual_atraso" => (float)($row['percentual_atraso'] ?? 0)
]);

mysqli_close($conexao);