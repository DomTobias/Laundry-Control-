$(document).ready(function () {

    $('#mesSelecionado, #anoSelecionado').on('change', function () {

        let mes = $('#mesSelecionado').val();
        let ano = $('#anoSelecionado').val();

        if (mes && ano) {
            $.ajax({
                url: '../config/pesagem/match/status_mes.php',
                type: 'POST',
                data: { mes: mes, ano: ano },
                dataType: 'json',
                success: function (res) {
                    console.log(res); // DEBUG

                    $('#label-total').text(res.total);
                    $('#label-maximo').text(res.maximo);
                    $('#label-soma').text(res.soma);
                    $('#label-minimo').text(res.minimo);
                },
                error: function (err) {
                    console.error('Erro AJAX:', err);
                }
            });
        }
    });

});
