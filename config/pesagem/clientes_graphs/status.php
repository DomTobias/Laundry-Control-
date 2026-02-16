<?php
include_once(__DIR__ . '/../../conexao.php');

// Busca dados apenas do dia atual (Hoje)
$sql = "
    SELECT 
        c.nome_cliente, 
        COALESCE(SUM(p.peso), 0) as total 
    FROM clientes c
    LEFT JOIN pesagem p ON c.id_cliente = p.id_cliente 
        AND DATE(p.data_inicio) = CURDATE() 
    GROUP BY c.id_cliente, c.nome_cliente
    HAVING total > 0
    ORDER BY total DESC
";

$res = mysqli_query($conexao, $sql);
$labels_inicial = []; 
$dados_inicial = [];

while ($row = mysqli_fetch_assoc($res)) {
    $labels_inicial[] = $row['nome_cliente'];
    $dados_inicial[] = (float)$row['total'];
}

// Transformamos em JSON para o JavaScript ler
$json_labels = json_encode($labels_inicial);
$json_dados = json_encode($dados_inicial);
?>