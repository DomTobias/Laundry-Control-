<?php

if (isset($_POST['submit'])) {

    include_once ('../conexao.php');

    $nome = $_POST['nome'];

    $sql = "INSERT INTO processos (nome) VALUES
    ('$nome')";

    $result = mysqli_query($conexao, $sql);
    
    if ($result) {
        header('Location: ../../pages/info.php');
        exit();
    } else {
        echo "Erro ao inserir: " . $conexao->error;
    }

} 

?>
