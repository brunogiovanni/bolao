$(document).ready(function () {
    localStorage.clear();
    // for (let i = 0; i < localStorage.length; i++) {
    //     if (localStorage.getItem('mandante-' + i) !== null && localStorage.getItem('mandante-' + i) !== '' && localStorage.getItem('mandante-' + i) !== undefined) {
    //         $("#placar-mandante-" + i).val(localStorage.getItem('mandante-' + i));
    //         $("#placar-visitante-" + i).val(localStorage.getItem('visitante-' + i));
    //     }
    // }
});

function salvarLance(placarMandante, placarVisitante, id, jogoId) {
    if ($("#id-aposta-" + id).val() !== '') {
        localStorage.setItem('id-aposta-' + id, $("#id-aposta-" + id).val());
    }
    localStorage.setItem('jogo-' + id, jogoId);
    if (placarMandante !== null && placarMandante !== '' && placarMandante !== undefined) {
        localStorage.setItem('mandante-' + id, placarMandante);
        localStorage.setItem('casa-' + id, $("#time1-" + id).val());
    }
    if (placarVisitante !== null && placarVisitante !== '' && placarVisitante !== undefined) {
        localStorage.setItem('visitante-' + id, placarVisitante);
        localStorage.setItem('fora-' + id, $("#time2-" + id).val());
    }
}

function salvarApostas() {
    let token = $("[name='_csrfToken'").val();
    let placares = [];
    for (let i = 0; i < quantidadeApostas; i++) {
        if (localStorage.getItem('mandante-' + i) !== null && localStorage.getItem('mandante-' + i) !== '' && localStorage.getItem('mandante-' + i) !== undefined) {
            placares.push({
                id: localStorage.getItem('id-aposta-' + i),
                placar1: localStorage.getItem('mandante-' + i),
                placar2: localStorage.getItem('visitante-' + i),
                jogos_id: localStorage.getItem('jogo-' + i),
                time1: localStorage.getItem('casa-' + i),
                time2: localStorage.getItem('fora-' + i),
            });
        }
    }

    $.ajax({
        url: '/apostas/salvarApostas.json',
        method: 'post',
        headers: {
            'X-CSRF-Token': token
        },
        dataType: 'json',
        data: { apostas: placares },
        success: function (retorno) {
            // if (retorno.mensagem === 'sucesso') {
            //     $("#mensagem-sucesso").show();
            //     $("#mensagem-erro").hide();
            //     localStorage.clear();
            // } else {
            //     $("#mensagem-sucesso").hide();
            //     $("#mensagem-erro").show();
            // }
            document.location.reload();
        },
        error: function (error) {
            $("#mensagem-erro").show();
            console.error(error);
        }
    });
}
