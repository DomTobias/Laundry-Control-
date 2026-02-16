document.addEventListener('DOMContentLoaded', function() {
    const ctxBar = document.getElementById('barOperators');
    if (!ctxBar) return;

    const initialData = window.OPERADORES_DATA || { labels: [], dados: [] };

    const barChart = new Chart(ctxBar, {
        type: 'bar',
        // --- ADIÇÃO: Registrar o plugin ---
        plugins: [ChartDataLabels], 
        data: {
            labels: initialData.labels,
            datasets: [{
                label: 'Total Processado (kg)',
                data: initialData.dados,
                backgroundColor: '#81C784',
                borderRadius: 8,
                barThickness: 18
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            // --- ADIÇÃO: Expandir o layout para o texto não cortar ---
            layout: {
                padding: {
                    right: 40 
                }
            },
            plugins: {
                legend: { labels: { color: '#fff' } },
                // --- CONFIGURAÇÃO DO DATALABELS ---
                datalabels: {
                    anchor: 'end',      // Fixa o texto na extremidade da barra
                    align: 'right',     // Posiciona à direita da extremidade
                    color: '#ccc',      // Cor do texto
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value) => value + ' kg' // Formata o valor
                }
            },
            scales: {
                x: {
                    ticks: { color: '#aaa', callback: value => value + ' kg' },
                    grid: { color: 'rgba(255,255,255,0.05)' }
                },
                y: {
                    ticks: { color: '#aaa' },
                    grid: { display: false }
                }
            }
        }
    });

    // Lógica de Filtro (Mesma estrutura do gráfico de pizza)
    const cardBar = ctxBar.closest('.chart-card');
    const inputDia = cardBar.querySelector('.campoDia');
    const selectMes = cardBar.querySelector('.campoMes');
    const selectAnoMes = cardBar.querySelector('.campoMesAno');
    const selectAnoSolo = cardBar.querySelector('.campoAno');

    function atualizarBarra(url) {
        fetch(url)
            .then(r => r.json())
            .then(json => {
                barChart.data.labels = json.labels || [];
                barChart.data.datasets[0].data = json.dados || [];
                barChart.update();
            })
            .catch(err => console.error("Erro ao atualizar operadores:", err));
    }

    // Eventos
    inputDia.addEventListener('change', function() {
        if (this.value) {
            atualizarBarra(`../config/secagem/graphs_operators/status_dia.php?data=${this.value}`);
        }
    });

    function checkMesOp() {
        if (selectMes.value && selectAnoMes.value) {
            atualizarBarra(`../config/secagem/graphs_operators/status_mes.php?mes=${selectMes.value}&ano=${selectAnoMes.value}`);
        }
    }
    selectMes.addEventListener('change', checkMesOp);
    selectAnoMes.addEventListener('change', checkMesOp);

    selectAnoSolo.addEventListener('change', function() {
        if (this.value) {
            atualizarBarra(`../config/secagem/graphs_operators/status_ano.php?ano=${this.value}`);
        }
    });
});