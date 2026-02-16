$(document).ready(function () {
    $('#filtroAnoStats').on('change', function () {
        let ano = $(this).val();

        if (ano !== "") {
            $.ajax({
                url: '../config/secagem/match/status_ano.php',
                type: 'POST',
                data: { ano: ano },
                dataType: 'json',
                success: function (res) {
                    // Atualiza os labels com os IDs que configuramos anteriormente
                    $('#label-total').text(res.total);
                    $('#label-maximo').text(res.maximo);
                    $('#label-soma').text(res.soma);
                    $('#label-minimo').text(res.minimo);
                },
                error: function (err) {
                    console.error('Erro ao buscar dados anuais:', err);
                }
            });
        }
    });
});

