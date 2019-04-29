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
    // if ($("#id-aposta-" + id).val() !== '') {
    //     localStorage.setItem('id-aposta-' + id, $("#id-aposta-" + id).val());
    // }
    // localStorage.setItem('jogo-' + id, jogoId);
    // if (placarMandante !== null && placarMandante !== '' && placarMandante !== undefined) {
    //     localStorage.setItem('mandante-' + id, placarMandante);
    //     localStorage.setItem('casa-' + id, $("#time1-" + id).val());
    // }
    // if (placarVisitante !== null && placarVisitante !== '' && placarVisitante !== undefined) {
    //     localStorage.setItem('visitante-' + id, placarVisitante);
    //     localStorage.setItem('fora-' + id, $("#time2-" + id).val());
    // }
    console.log('desabilitado');
}

function salvarApostas() {
    let token = $("[name='_csrfToken']").val();
    let placares = [];
    for (let i = 0; i <= quantidadeApostas; i++) {
        if (($('#placar-mandante-' + i).val() !== null && $('#placar-mandante-' + i).val() !== '' && $('#placar-mandante-' + i).val() !== undefined) && ($('#placar-visitante-' + i).val() !== null && $('#placar-visitante-' + i).val() !== '' && $('#placar-visitante-' + i).val() !== undefined)) {
        // if (localStorage.getItem('mandante-' + i) !== null && localStorage.getItem('mandante-' + i) !== '' && localStorage.getItem('mandante-' + i) !== undefined) {
            placares.push({
                id: $('#id-aposta-' + i).val(),
                placar1: $('#placar-mandante-' + i).val(),
                placar2: $('#placar-visitante-' + i).val(),
                jogos_id: $('#jogo-id-' + i).val(),
                time1: $('#time1-' + i).val(),
                time2: $('#time2-' + i).val(),
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
            console.log(retorno);
            // if (retorno.mensagem === 'sucesso') {
            //     $("#mensagem-sucesso").show();
            //     $("#mensagem-erro").hide();
            // localStorage.clear();
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
