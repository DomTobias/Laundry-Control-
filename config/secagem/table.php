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
    l.id_secagem,
    l.data_inicio,
    l.hora_inicio,
    l.secadora,
    l.id_processo,
    l.id_operador,
    l.id_tara,
    l.peso_molhado,
    l.peso,
    -- COALESCE para o nome do Processo
    COALESCE(pr.nome, '-') AS nome_processo,
    -- COALESCE para o valor da Tara
    COALESCE(v.valor_tara, '-') AS valor_tara,
    -- COALESCE para o nome do Operador
    COALESCE(op.nome, '-') AS nome_operador
FROM secagem l
-- Join com Processos
LEFT JOIN processos pr ON l.id_processo = pr.id_processo
-- Join com Tara
LEFT JOIN tara v        ON l.id_tara     = v.id_tara
-- Join com Operadores
LEFT JOIN operadores op ON l.id_operador = op.id_operador

$whereData
ORDER BY l.id_secagem DESC
";

$result = mysqli_query($conexao, $sql_table);

if (!$result) {
    die("Erro na consulta da tabela: " . mysqli_error($conexao));
}
?>