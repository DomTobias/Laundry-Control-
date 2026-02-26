document.addEventListener("DOMContentLoaded", function () {

    fetch("/config/dosagem/media_desvio.php")
        .then(response => response.json())
        .then(data => {

            new Chart(
                document.getElementById('graficoDesvio'),
                {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Média de Desvio (minutos)',
                            data: data.dados,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            );

        })
        .catch(error => {
            console.error("Erro ao carregar gráfico:", error);
        });

});