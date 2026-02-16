<?php
include_once(__DIR__ . '/../../conexao.php');
// Verifica se existe uma data enviada via POST
if (isset($_POST['data_escolhida'])) {
    $data = mysqli_real_escape_string($conexao, $_POST['data_escolhida']);

    $sql = "SELECT 
                COUNT(*) as total, 
                SUM(peso) as soma, 
                MAX(peso) as maximo, 
                MIN(peso) as minimo 
            FROM pesagem 
            WHERE DATE(data_inicio) = '$data'";

    $res = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($res);

    // Retorna apenas JSON para o JavaScript
    echo json_encode([
        'total'  => number_format($row['total'] ?? 0, 0, ',', '.'),
        'soma'   => number_format($row['soma'] ?? 0, 2, ',', '.'),
        'maximo' => number_format($row['maximo'] ?? 0, 2, ',', '.'),
        'minimo' => number_format($row['minimo'] ?? 0, 2, ',', '.')
    ]);
    exit; // Encerra aqui para não enviar mais nada
}