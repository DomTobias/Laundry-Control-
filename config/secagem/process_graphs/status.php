<?php
include_once(__DIR__ . '/../../conexao.php');

$sql = "
    SELECT 
        pr.nome AS nome_processo,
        COALESCE(SUM(s.peso), 0) AS total
    FROM processos pr
    LEFT JOIN secagem s 
        ON pr.id_processo = s.id_processo
        AND DATE(s.data_inicio) = CURDATE()
    GROUP BY pr.id_processo, pr.nome
    HAVING total > 0
    ORDER BY total DESC
";

$res = mysqli_query($conexao, $sql);

$labels_inicial = [];
$dados_inicial  = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels_inicial[] = $row['nome_processo'];
    $dados_inicial[]  = (float)$row['total'];
}

$json_labels = json_encode($labels_inicial);
$json_dados  = json_encode($dados_inicial);
