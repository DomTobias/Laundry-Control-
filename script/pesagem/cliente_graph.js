// 1. Inicialização do Canvas e Contexto
const ctx = document.getElementById('pieChart');

// 2. Plugin para Mensagem de "Sem Registro"
const pluginVazio = {
    id: 'emptyChart',
    afterDraw(chart) {
        const { datasets } = chart.data;
        const hasData = datasets[0].data.length > 0 && datasets[0].data.some(v => v > 0);

        if (!hasData) {
            const { ctx, chartArea: { top, bottom, left, right, width, height } } = chart;
            chart.clear();
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = 'bold 16px sans-serif';
            ctx.fillStyle = '#888'; // Cor da mensagem
            ctx.fillText('Sem registros para este período', left + width / 2, top + height / 2);
            ctx.restore();
        }
    }
};

// 3. Instância do Gráfico
let clienteChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: window.CLIENTE_GRAPH.labels || [],
        datasets: [{
            label: 'Pesagens por Cliente',
            data: window.CLIENTE_GRAPH.dados || [],
            backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#9C27B0', '#FF5722', '#00BCD4'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: 10 // Adiciona um respiro interno para o motor do Chrome
        },
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#fff',
                    padding: 20, // Espaçamento da legenda para não colar no gráfico
                    generateLabels: (chart) => {
                        const data = chart.data.datasets[0].data;
                        if (!data || data.length === 0 || !data.some(v => v > 0)) return [];
                        return Chart.defaults.plugins.legend.labels.generateLabels(chart);
                    }
                }
            }
        }
    },
    plugins: [pluginVazio]
});

// 4. Seleção dos Elementos de Filtro (Apenas dentro do card do gráfico)
const cardPie = ctx.closest('.chart-card');
const inputDia = cardPie.querySelector('.campoDia');
const selectMes = cardPie.querySelector('.campoMes');
const selectAnoMes = cardPie.querySelector('.campoMesAno');
const selectAnoSolo = cardPie.querySelector('.campoAno');

// 5. Função Genérica para Atualizar o Gráfico
function atualizarDados(url) {
    fetch(url)
        .then(r => r.json())
        .then(json => {
            // Se o JSON vier vazio, resetamos para arrays vazios para disparar o plugin
            clienteChart.data.labels = (json.labels && json.labels.length > 0) ? json.labels : [];
            clienteChart.data.datasets[0].data = (json.dados && json.dados.length > 0) ? json.dados : [];
            clienteChart.update();
        })
        .catch(err => console.error("Erro na requisição:", err));
}

// 6. Eventos de Escuta (Listeners)

// Filtro por Dia
inputDia.addEventListener('change', function() {
    if (this.value) {
        atualizarDados(`../config/pesagem/clientes_graphs/status_dia.php?data=${this.value}`);
    }
});

// Filtro por Mês (Mês + Ano)
function checkMes() {
    if (selectMes.value && selectAnoMes.value) {
        atualizarDados(`../config/pesagem/clientes_graphs/status_mes.php?mes=${selectMes.value}&ano=${selectAnoMes.value}`);
    }
}
selectMes.addEventListener('change', checkMes);
selectAnoMes.addEventListener('change', checkMes);

// Filtro por Ano
selectAnoSolo.addEventListener('change', function() {
    if (this.value) {
        atualizarDados(`../config/pesagem/clientes_graphs/status_ano.php?ano=${this.value}`);
    }
});