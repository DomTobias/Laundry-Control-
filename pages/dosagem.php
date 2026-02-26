<?php

    require_once __DIR__ . '/../config/auth.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/dosagem.css">
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
            <div class="menu-item">
                <img src="../icons/scale.png" alt="Pesagem">
                <span>Pesagem</span>
            </div>
        </a>
        <div class="menu-item active">
            <img src="../icons/doser_selection.png" alt="Dosagem">
            <span>Dosagem</span>
        </div>
        <a href="info.php">
            <div class="menu-item">
                <img src="../icons/info.png" alt="Informações">
                <span>Info</span>
            </div>
        </a>
    </aside>

    <main class="main-content">
        <div class="dashboard-container">

            <!-- Seção 1: Gauges de Eficiência -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Eficiência Percentual por Máquina</h1>
                </div>

                <div class="gauge-grid" id="gaugeContainer">
                    <!-- Gauges serão inseridos aqui -->
                </div>
            </div>

            <!-- Seção 2: Gráfico de Colunas -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Gráfico Eficiência Máquina Colunas</h1>
                    <div class="select-wrapper">
                        <select class="custom-select">
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="dia">Dia</option>
                            <option value="mes">Mês</option>
                            <option value="ano">Ano</option>
                        </select>
                    </div>
                </div>

                <div class="maq column_maq">
                    <canvas id="graficoDesvio"></canvas>
                </div>
            </div>

            <!-- Seção 3: Gráfico de Linhas -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Linha por Linha Máquinas</h1>
                    <div class="select-wrapper">
                        <select class="custom-select">
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="primeiro_turno">Primeiro Turno</option>
                            <option value="segundo_turno">Segundo Turno</option>
                        </select>
                    </div>
                </div>

                <div class="maq column_maq">
                    <canvas id="LineChart"></canvas>
                </div>
            </div>

            <!-- Seção 4: Cards de Eficiência -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Eficiência Percentual por Máquina</h1>
                    <div class="select-wrapper">
                        <select class="custom-select">
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="dia">Dia</option>
                            <option value="mes">Mês</option>
                            <option value="ano">Ano</option>
                        </select>
                    </div>
                </div>

                <div class="cards-grid">
                    <div class="maq1">
                        <h2>Eficiencia Geral do Dia</h2>
                        <p id="eficienciaGeral">--</p>
                    </div>

                    <div class="maq1">
                        <h2>Total de Ciclos</h2>
                        <p id="totalCiclos">--</p>
                    </div>

                    <div class="maq1">
                        <h2>Média Real por dia</h2>
                        <p id="mediaReal">--</p>
                    </div>

                    <div class="maq1">
                        <h2>Percentual de Atrasos</h2>
                        <p id="percentualAtraso">--</p>
                    </div>
                </div>
            </div>

            <!-- Seção 5: Gráfico de Barra -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Desvio por Receita</h1>
                    <div class="select-wrapper">
                        <select class="custom-select">
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="primeiro_turno">Primeiro Turno</option>
                            <option value="segundo_turno">Segundo Turno</option>
                        </select>
                    </div>
                </div>

                <div class="maq column_maq">
                    <canvas id="grafich_column"></canvas>
                </div>
            </div>

            <!-- Seção 7: Tendencias de Desvio -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Tendências de Desvio</h1>
                    <div class="select-wrapper">
                        <select class="custom-select">
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="primeiro_turno">Primeiro Turno</option>
                            <option value="segundo_turno">Segundo Turno</option>
                        </select>
                    </div>
                </div>

                <div class="maq column_maq">
                    <canvas id="tendenciaChart"></canvas>
                </div>
            </div>

            <!-- 7 Seção da Tabela Geral -->
            <div class="chart-section">
                <div class="chart-header">
                    <h1>Tabela Geral</h1>
                    <div class="select-wrapper">
                        <select class="custom-select">
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="primeiro_turno">Primeiro Turno</option>
                            <option value="segundo_turno">Segundo Turno</option>
                        </select>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table id="dosagensTable" class="table-general">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data Inicio</th>
                                <th>Hora Inicio</th>
                                <th>Máquina</th>
                                <th>Processo</th>
                                <th>Minutos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td>09/02/2026</td>
                                <td>10:45</td>
                                <td>5</td>
                                <td>LEVE LENÇOL</td>
                                <td>25</td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td>09/02/2026</td>
                                <td>11:15</td>
                                <td>3</td>
                                <td>PESADO UNIFORME</td>
                                <td>35</td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td>09/02/2026</td>
                                <td>11:50</td>
                                <td>1</td>
                                <td>MÉDIO TOALHA</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>004</td>
                                <td>09/02/2026</td>
                                <td>12:25</td>
                                <td>4</td>
                                <td>LEVE LENÇOL</td>
                                <td>25</td>
                            </tr>
                            <tr>
                                <td>005</td>
                                <td>09/02/2026</td>
                                <td>13:00</td>
                                <td>2</td>
                                <td>PESADO UNIFORME</td>
                                <td>35</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../script/dosagem/maq_column_maq.js"></script>
    <script src="../script/dosagem/linechart.js"></script>
    <script src="../script/dosagem/mygauge.js"></script>
    <script src="../script/dosagem/cards_dashboard.js"></script>
    <script src="../script/dosagem/grafich_column.js"></script>
    <script src="../script/dosagem/tendencia_chart.js"></script>
</body>
</html>
