document.addEventListener("DOMContentLoaded", function () {

    fetch("/config/dosagem/tendencia_desvio.php", {
        method: "GET",
        credentials: "include"
    })
    .then(response => {

        if (!response.ok) {
            throw new Error("Erro HTTP: " + response.status);
        }

        return response.json();
    })
    .then(data => {

        if (data.error) {
            console.error("Erro retornado pelo PHP:", data.error);
            return;
        }

        new Chart(
            document.getElementById('tendenciaChart'),
            {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Média de Desvio (min)',
                        data: data.dados,
                        borderColor: '#00ff88',
                        backgroundColor: 'rgba(0, 255, 136, 0.2)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: '#00ff88'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: { color: 'white' }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: 'white' },
                            grid: { color: '#222' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: 'white' },
                            grid: { color: '#222' }
                        }
                    }
                }
            }
        );

    })
    .catch(error => {
        console.error("Erro gráfico tendência:", error);
    });

});