<?php
    require_once __DIR__ . '/../config/auth.php';
    include_once('../config/operadores/select.php');
    include_once('../config/clientes/select.php');
    include_once('../config/processos/select.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/info.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../icons/laundry.png">
    <title>Laundry Control</title>
</head>
<body>

    <aside class="menu">
        <a href="secagem.php">
            <div class="menu-item">
                <img src="../icons/laundry.png" alt="Secagem">
                <span>Secagem</span>
            </div>
        </a>

        <a href="pesagem.php">
            <div class="menu-item ">
                <img src="../icons/scale.png" alt="Pesagem">
                <span>Pesagem</span>
            </div>
        </a>

        <div class="menu-item active">
            <img src="../icons/info_selection.png" alt="Informações">
            <span>Info</span>
        </div>
    </aside>

    <div class="main-content">
        <div class="card-table">

            <div class="card">
                <h1>Operadores</h1>
                <button class="btn-add" onclick="openModal('modal-operadores')">+ Adicionar</button>

                <table>
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data Criação</th>
                            <th scope="col">Hora Criação</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_operadores)) { ?>
                                <tr>
                                    <td><?= $row['id_operador'] ?></td>
                                    <td><?= $row['nome'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['data_criacao'])) ?></td>
                                    <td><?= $row['hora_criacao'] ?></td>
                                </tr>
                            <?php } ?>    
                        </tbody>
                </table>
            </div>

            <div class="card">
                <h1>Clientes</h1>
                <button class="btn-add" onclick="openModal('modal-clientes')">+ Adicionar</button>        

                <table>
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_clientes)) { ?>
                                <tr>
                                    <td class="col-id"><?= $row['id_cliente'] ?></td>
                                    <td><?= $row['nome_cliente'] ?></td>
                                </tr>
                            <?php } ?>    
                        </tbody>
                </table>
            </div>

            <div class="card">
                <h1>Processos</h1>
                <button class="btn-add" onclick="openModal('modal-processos')">+ Adicionar</button>

                <table>
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data Criação</th>
                            <th scope="col">Hora Criação</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_processos)) { ?>
                                <tr>
                                    <td><?= $row['id_processo'] ?></td>
                                    <td><?= $row['nome'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['data_criacao'])) ?></td>
                                    <td><?= $row['hora_criacao'] ?></td>
                                </tr>
                            <?php } ?>    
                        </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal" id="modal-operadores">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Operador</h2>
                <span class="close" onclick="closeModal('modal-operadores')">&times;</span>
            </div>

            <form method='post' action='../config/operadores/insert.php'>
                <label>Nome do Operador</label>
                <input type="text" placeholder="Digite o nome" name="nome" required>

                <button type="submit" name="submit" class="btn-save">Salvar</button>
            </form>
        </div>
    </div>

    <div class="modal" id="modal-clientes">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Cliente</h2>
                <span class="close" onclick="closeModal('modal-clientes')">&times;</span>
            </div>

            <form method="post" action="../config/clientes/insert.php">
                <label>Nome do Cliente</label>
                <input type="text" placeholder="Digite o nome" name="nome" required>

                <button type="submit" name="submit" class="btn-save">Salvar</button>
            </form>
        </div>
    </div>

    <div class="modal" id="modal-processos">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Processo</h2>
                <span class="close" onclick="closeModal('modal-processos')">&times;</span>
            </div>

            <form method='post' action='../config/processos/insert.php'>
                <label>Nome do Processo</label>
                <input type="text" placeholder="Digite o nome" name="nome" required>

                <button type="submit" name="submit" class="btn-save">Salvar</button>
            </form>
        </div>
    </div>


    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>


</body>
</html>
