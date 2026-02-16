<?php
include_once(__DIR__ . '/../../conexao.php');

if (!empty($_POST['ano'])) {
    $ano = (int) $_POST['ano'];

    $sql = "
        SELECT 
            COUNT(*) as total,
            SUM(peso) as soma,
            MAX(peso) as maximo,
            MIN(peso) as minimo
        FROM pesagem
        WHERE YEAR(data_inicio) = $ano
    ";

    $res = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($res);

    echo json_encode([
        'total'  => number_format($row['total'] ?? 0, 0, ',', '.'),
        'soma'   => number_format($row['soma'] ?? 0, 2, ',', '.'),
        'maximo' => number_format($row['maximo'] ?? 0, 2, ',', '.'),
        'minimo' => number_format($row['minimo'] ?? 0, 2, ',', '.')
    ]);
    exit;
}