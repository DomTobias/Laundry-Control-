document.addEventListener("DOMContentLoaded", function () {

    function gerarCores(valores) {
        return valores.map(valor => {
            if (valor > 0) return '#ff4d4d';     // 🔴 acima do padrão
            if (valor < 0) return '#00ff88';     // 🟢 abaixo do padrão
            return '#ffc107';                    // 🟡 neutro
        });
    }

    fetch("/config/dosagem/desvio_receita.php")
        .then(response => response.json())
        .then(data => {

            new Chart(
                document.getElementById('grafich_column'),
                {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Média de Desvio (min)',
                            data: data.dados,
                            backgroundColor: gerarCores(data.dados),
                            borderRadius: 8
                        }]
                    },
                    options: {
                        indexAxis: 'y', // horizontal
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: { color: 'white' }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: { color: 'white' },
                                grid: { color: '#222' }
                            },
                            y: {
                                ticks: { color: 'white' },
                                grid: { display: false }
                            }
                        }
                    }
                }
            );

        })
        .catch(error => {
            console.error("Erro gráfico desvio receita:", error);
        });

});