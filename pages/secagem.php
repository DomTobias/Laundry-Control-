<?php
    require_once __DIR__ . '/../config/auth.php';
    include_once('../config/secagem/table.php');
    include_once('../config/secagem/match/status.php');
    include_once('../config/secagem/match/status_dia.php');
    include_once('../config/secagem/match/status_mes.php');
    include_once('../config/secagem/match/status_ano.php');
    include_once('../config/secagem/process_graphs/status.php');
    include_once('../config/secagem/graphs_operators/status.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/secagem.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../icons/laundry.png">
    <title>Laundry Control</title>
</head>
<body>

    <aside class="menu">
        <div class="menu-item active">
            <img src="../icons/laundry_selection.png" alt="Secagem">
            <span>Secagem</span>
        </div>

        <a href="pesagem.php">
            <div class="menu-item ">
                <img src="../icons/scale.png" alt="Pesagem">
                <span>Pesagem</span>
            </div>
        </a>

        <a href="info.php">
            <div class="menu-item">
                <img src="../icons/info.png" alt="Informações">
                <span>Info</span>
            </div>
        </a>

    </aside>

    <main class="dashboard">

        <!-- CARD ESTATÍSTICAS -->
        <div class="card stats-card">

            <div class="selection-date">
                <select class="tipo-select" onchange="mostrarCampo(this)">
                    <option value="">-- Selecione --</option>
                    <option value="dia">Dia</option>
                    <option value="mes">Mês</option>
                    <option value="ano">Ano</option>
                </select>

                <input type="date" class="input-dinamico campoDia" id="dataDia">
                
                <div class="input-dinamico grupoMes" style="display: none; gap: 10px;">
                    <select class="select-estilizado campoMes" id="mesSelecionado">
                        <option value="">Mês</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <select class="select-estilizado campoMesAno" id="anoSelecionado">
                        <option value="">Ano</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>

                <select class="input-dinamico campoAno" id="filtroAnoStats">
                    <option value="">Selecione o Ano</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>

            <div class="stats-grid">
                <div class="stat-box stat-count">
                    <span class="label">COUNT</span>
                    <span id="label-total" class="value"><?= number_format($total, 0, ',', '.') ?></span>
                </div>

                <div class="stat-box stat-max">
                    <span class="label">MAX</span>
                    <span id="label-maximo" class="value"><?= number_format($maximo, 2, ',', '.') ?></span>
                </div>

                <div class="stat-box stat-sum">
                    <span class="label">SOMA</span>
                    <span id="label-soma" class="value"><?= number_format($soma, 2, ',', '.') ?></span>
                </div>

                <div class="stat-box stat-min">
                    <span class="label">MIN</span>
                    <span id="label-minimo" class="value"><?= number_format($minimo, 2, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <!-- CARD GRÁFICO PIE -->
        <div class="card chart-card">
            <div class="selection-date">
                <select class="tipo-select" onchange="mostrarCampo(this)">
                    <option value="">-- Selecione --</option>
                    <option value="dia">Dia</option>
                    <option value="mes">Mês</option>
                    <option value="ano">Ano</option>
                </select>

                <input type="date" class="input-dinamico campoDia"  id="dataCliente">
                
                <div class="input-dinamico grupoMes" style="display: none; gap: 10px;">
                    <select class="select-estilizado campoMes" >
                        <option value="">Mês</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <select class="select-estilizado campoMesAno" >
                        <option value="">Ano</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2025">2026</option>
                    </select>
                </div>

                <select class="input-dinamico campoAno">
                    <option value="">Selecione o Ano</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
            <canvas id="pieChart"></canvas>
        </div>

        <!-- CARD GRÁFICO LINHA -->
        <div class="card chart-card">
            <div class="selection-date">
                <select class="tipo-select" onchange="mostrarCampo(this)">
                    <option value="">-- Selecione --</option>
                    <option value="dia">Dia</option>
                    <option value="mes">Mês</option>
                    <option value="ano">Ano</option>
                </select>

                <input type="date" class="input-dinamico campoDia" id="dataHoraPico">
                
                <div class="input-dinamico grupoMes" style="display: none; gap: 10px;">
                    <select class="select-estilizado campoMes" id="mesLinha">
                        <option value="">Mês</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <select class="select-estilizado campoMesAno" id="anoLinha">
                        <option value="">Ano</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>

                <select class="input-dinamico campoAno" id="filtroAnoLinha">
                    <option value="">Selecione o Ano</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
            
            <canvas id="lineChart"></canvas>
        </div>

        <!-- CARD GRÁFICO BARRAS -->
        <div class="card chart-card">

            <div class="selection-date">
                <select class="tipo-select" onchange="mostrarCampo(this)">
                    <option value="">-- Selecione --</option>
                    <option value="dia">Dia</option>
                    <option value="mes">Mês</option>
                    <option value="ano">Ano</option>
                </select>

                <input type="date" class="input-dinamico campoDia">
                
                <div class="input-dinamico grupoMes" style="display: none; gap: 10px;">
                    <select class="select-estilizado campoMes">
                        <option value="">Mês</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <select class="select-estilizado campoMesAno">
                        <option value="">Ano</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2025">2026</option>
                    </select>
                </div>

                <select class="input-dinamico campoAno">
                    <option value="">Selecione o Ano</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>

            <canvas id="barOperators"></canvas>
        </div>

    </main>

    <div class="register">
        <h1>Registros Secagens</h1>

        <form method="GET" action="" class="filtro-tabela">
            <div class="filtro-tabela" style="margin-bottom: 15px;">
                <label class="filter-label">Filtrar Tabela por Dia:</label>
                <input type="date" name="data" class="filter-input" id="dataFiltroPesagem" value="<?= $dataFiltro ?? date('Y-m-d') ?>">
            </div>
        </form>

        <div class="table">
            <table id="secagensTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data Inicio</th>
                        <th>Hora Inicio</th>
                        <th>Secadora</th>
                        <th>Processo</th>
                        <th>Operador</th>
                        <th>Tara</th>
                        <th>Peso Molhado</th>
                        <th>Peso</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr data-row-id="<?= $row['id_secagem'] ?>">
                            <td><?= $row['id_secagem'] ?></td>
                            <td><?= date('d/m/Y', strtotime($row['data_inicio'])) ?></td>
                            <td><?= $row['hora_inicio'] ?></td>
                            <td><?= $row['secadora'] ?></td>
                            <td><?= $row['nome_processo'] ?></td>
                            <td><?= $row['nome_operador'] ?></td>
                            <td><?= $row['valor_tara'] ?></td>
                            <td><?= $row['peso_molhado'] ?></td>
                            <td><?= $row['peso'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
            
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="../script/secagem/table.js"></script>
    <script>
        window.CLIENTE_GRAPH = {
            labels: <?= $json_labels ?>,
            dados: <?= $json_dados ?>
        };
    </script>
    <script src="../script/secagem/process_graph.js"></script>
    <script src="../script/secagem/hourly_graph.js"></script>

    <script>
        window.OPERADORES_DATA = <?= $json_operadores ?>;
    </script>
    
    <script src="../script/secagem/graph_operators.js"></script>
    <script src="../script/secagem/match/status_dia.js"></script>
    <script src="../script/secagem/match/status_mes.js"></script>
    <script src="../script/secagem/match/status_ano.js"></script>

    <script>
        function mostrarCampo(selectElement) {
            const container = selectElement.parentElement;
            const valor = selectElement.value;

            // Esconde todos os campos dinâmicos primeiro
            const todosCampos = container.querySelectorAll('.input-dinamico');
            todosCampos.forEach(c => c.style.display = "none");

            // Lógica de exibição específica
            if (valor === "dia") {
                container.querySelector('.campoDia').style.display = "block";
            } 
            else if (valor === "mes") {
                // Exibe o grupo (div) que contém Mês e Ano lado a lado
                const grupo = container.querySelector('.grupoMes');
                grupo.style.display = "flex"; 
            } 
            else if (valor === "ano") {
                container.querySelector('.campoAno').style.display = "block";
            }
        }

        document.getElementById('dataFiltroPesagem').addEventListener('change', function() {
            this.form.submit(); // Envia o formulário automaticamente ao trocar a data
        });
    </script>

</body>
</html>
