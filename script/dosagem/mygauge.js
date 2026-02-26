document.addEventListener("DOMContentLoaded", function () {

    function getColor(valor) {
        if (valor >= 80) return '#00ff88';
        if (valor >= 60) return '#ffc107';
        return '#ff4d4d';
    }

    function criarGauge(canvasId, percentual) {

        const restante = 100 - percentual;
        const ctx = document.getElementById(canvasId).getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [percentual, restante],
                    backgroundColor: [
                        getColor(percentual),
                        '#1c1c1c'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '75%',
                rotation: -90,
                circumference: 180,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw(chart) {
                    const { width, height } = chart;
                    const ctx = chart.ctx;
                    ctx.save();
                    ctx.font = "bold 18px sans-serif";
                    ctx.fillStyle = "white";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText(percentual + "%", width / 2, height / 1.3);
                }
            }]
        });
    }

    fetch("/config/dosagem/gauges_eficiencia.php?ano=2026")
        .then(response => response.json())
        .then(data => {

            const container = document.getElementById("gaugeContainer");
            container.innerHTML = "";

            data.labels.forEach((label, index) => {

                const card = document.createElement("div");
                card.classList.add("gauge-card");

                const titulo = document.createElement("h3");
                titulo.innerText = label;

                const canvas = document.createElement("canvas");
                canvas.id = "gauge" + index;

                card.appendChild(titulo);
                card.appendChild(canvas);
                container.appendChild(card);

                criarGauge(canvas.id, data.dados[index]);
            });

        })
        .catch(error => {
            console.error("Erro ao carregar dados:", error);
        });

});