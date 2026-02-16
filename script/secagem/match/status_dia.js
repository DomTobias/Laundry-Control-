$(document).ready(function() {
    // Escuta a mudança no input de data
    $('#dataDia').on('change', function() {
        let dataSelecionada = $(this).val();

        if (dataSelecionada !== "") {
            $.ajax({
                url: '../config/secagem/match/status_dia.php',
                type: 'POST',
                data: { data_escolhida: dataSelecionada },
                dataType: 'json',
                success: function(response) {
                    // Atualiza os IDs que criamos no passo 1
                    $('#label-total').text(response.total);
                    $('#label-maximo').text(response.maximo);
                    $('#label-soma').text(response.soma);
                    $('#label-minimo').text(response.minimo);
                },
                error: function(err) {
                    console.error("Erro na busca:", err);
                }
            });
        }
    });
});