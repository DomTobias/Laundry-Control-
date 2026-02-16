let lineChartInstance;

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('lineChart');
    if (!ctx) return;

    lineChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Peso Total (kg)',
                data: [],
                fill: true,
                tension: 0.4,
                borderColor: '#2196F3',
                backgroundColor: 'rgba(33, 150, 243, 0.2)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });

    carregarDiaAtual();

    // --- EVENTOS ---

    // Filtro por DIA
    const inputDia = document.getElementById('dataHoraPico');
    if (inputDia) {
        inputDia.addEventListener('change', () => {
            if (inputDia.value) carregarPorDia(inputDia.value);
        });
    }

    // Filtro por MÊS (Pega os selects dentro do card do gráfico de linha)
    // No seu HTML, certifique-se que esses IDs são únicos para este card
    const selectMes = document.querySelector('#lineChart').parentElement.querySelector('.campoMes');
    const selectAno = document.querySelector('#lineChart').parentElement.querySelector('.campoMesAno');

    if (selectMes && selectAno) {
        const dispararBuscaMes = () => {
            if (selectMes.value && selectAno.value) {
                carregarPorMes(selectMes.value, selectAno.value);
            }
        };
        selectMes.addEventListener('change', dispararBuscaMes);
        selectAno.addEventListener('change', dispararBuscaMes);
    }
});

/* ===============================
    FUNÇÕES DE FETCH
================================ */

    function carregarDiaAtual() {
        fetch('../config/pesagem/hourly_graph/status.php')
            .then(r => r.json())
            .then(atualizarGrafico)
            .catch(err => console.error('Erro status.php:', err));
    }

    function carregarPorDia(data) {
        fetch(`../config/pesagem/hourly_graph/status_dia.php?data=${data}`)
            .then(r => r.json())
            .then(atualizarGrafico)
            .catch(err => console.error('Erro status_dia.php:', err));
    }

    function carregarPorMes(mes, ano) {
        fetch(`../config/pesagem/hourly_graph/status_mes.php?mes=${mes}&ano=${ano}`)
            .then(r => r.json())
            .then(atualizarGrafico)
            .catch(err => console.error('Erro status_mes.php:', err));
    }

    function atualizarGrafico(json) {
        if (!json.labels || !json.dados) return;
        lineChartInstance.data.labels = json.labels;
        lineChartInstance.data.datasets[0].data = json.dados;
        lineChartInstance.update();
    }


const selectAnoApenas = document.getElementById('filtroAnoLinha');
    if (selectAnoApenas) {
        selectAnoApenas.addEventListener('change', () => {
            if (selectAnoApenas.value) {
                carregarPorAno(selectAnoApenas.value);
            }
        });
    }

    function carregarPorAno(ano) {
        fetch(`../config/pesagem/hourly_graph/status_ano.php?ano=${ano}`)
            .then(r => r.json())
            .then(atualizarGrafico)
            .catch(err => console.error('Erro status_ano.php:', err));
    }

// A função atualizarGrafico já cuida do resto!