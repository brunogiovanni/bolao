$(document).ready(function () {
    if (localStorage.length > 0) {
        for (let i = 0; i < localStorage.length; i++) {
            $("#placar-mandante-" + i).val(localStorage.getItem('mandante-' + i));
            $("#placar-visitante-" + i).val(localStorage.getItem('visitante-' + i));
        }
    }
});

function salvarLance(placarMandante, placarVisitante, id, jogoId) {
    localStorage.setItem('jogo-' + id, jogoId);
    if (placarMandante !== null && placarMandante !== '' && placarMandante !== undefined) {
        localStorage.setItem('mandante-' + id, placarMandante);
    }
    if (placarVisitante !== null && placarVisitante !== '' && placarVisitante !== undefined) {
        localStorage.setItem('visitante-' + id, placarVisitante);
    }
}

function salvarApostas() {
    let placares = [];
    for (let i = 0; i < quantidadeApostas; i++) {
        placares.push({
            placar1: localStorage.getItem('mandante-' + i),
            placar2: localStorage.getItem('visitante-' + i),
            jogos_id: localStorage.getItem('jogo-' + i)
        });
    }

    $.ajax({
        url: '/apostas/salvarApostas.json',
        method: 'post',
        dataType: 'json',
        data: { apostas: placares },
        success: function (retorno) {
            if (retorno === 'sucesso') {
                $("#mensagem-sucesso").show();
                $("#mensagem-erro").hide();
            } else {
                $("#mensagem-sucesso").hide();
                $("#mensagem-erro").show();
            }
            localStorage.clear();
        },
        error: function (error) {
            $("#mensagem-erro").html('Houve um problema ao cadastrar as apostas! Tente novamente ou entre em contato com a administração!');
            $("#mensagem-erro").show();
        }
    });
}
