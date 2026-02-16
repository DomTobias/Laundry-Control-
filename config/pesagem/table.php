<?php
include_once(__DIR__ . '/../conexao.php');

// Pega a data via GET
$dataFiltro = $_GET['data'] ?? null;

if ($dataFiltro) {
    // Se o usuário selecionou uma data, filtra exatamente por ela
    $dataLimpa = mysqli_real_escape_string($conexao, $dataFiltro);
    $whereData = "WHERE l.data_inicio = '$dataLimpa'";
} else {
    // Padrão ao carregar a página: hoje
    $whereData = "WHERE l.data_inicio = CURDATE()";
}

$sql_table = "
    SELECT
        l.id_pesagem,
        l.data_inicio,
        l.hora_inicio,
        l.id_cliente,
        l.id_tara,
        l.peso_bruto,
        l.peso,
        COALESCE(p.nome_cliente, '-') AS nome_cliente,
        COALESCE(v.valor_tara, '-')   AS valor_tara
    FROM pesagem l
    LEFT JOIN clientes p ON l.id_cliente = p.id_cliente
    LEFT JOIN tara v     ON l.id_tara    = v.id_tara
    $whereData
    ORDER BY l.id_pesagem DESC
";

$result = mysqli_query($conexao, $sql_table);

if (!$result) {
    die("Erro na consulta da tabela: " . mysqli_error($conexao));
}
?>