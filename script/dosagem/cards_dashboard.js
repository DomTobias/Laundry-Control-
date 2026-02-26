fetch("/config/dosagem/cards_dashboard.php?data=2026-02-09")
    .then(response => response.json())
    .then(data => {

        document.getElementById("eficienciaGeral").innerText =
            data.eficiencia_geral + "%";

        document.getElementById("totalCiclos").innerText =
            data.total_ciclos;

        document.getElementById("mediaReal").innerText =
            data.media_real + " min";

        document.getElementById("percentualAtraso").innerText =
            data.percentual_atraso + "%";
    });