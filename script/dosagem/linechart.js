document.addEventListener("DOMContentLoaded", function () {

    fetch("/config/dosagem/linha_pico.php?data=2026-02-09")
        .then(response => response.json())
        .then(data => {

            new Chart(
                document.getElementById('LineChart'),
                {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        spanGaps: true, // conecta pontos mesmo com null
                        elements: {
                            line: {
                                borderWidth: 2
                            },
                            point: {
                                radius: 4
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'white'
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: { color: 'white' }
                            },
                            y: {
                                ticks: { color: 'white' }
                            }
                        }
                    }
                }
            );

        })
        .catch(error => {
            console.error("Erro gráfico linha:", error);
        });

});