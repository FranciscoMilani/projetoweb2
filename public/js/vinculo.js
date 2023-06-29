var questoesInseridas = [];

$(document).ready(function(){

    $('.botao-vinculo').click(function() {
        $botao = $(this);
        let celula = $(this).closest('tr').find('td:first');
        let pontos = $(this).closest('tr').find('.ponto-input').val();
        let ordem = $(this).closest('tr').find('.ordem-input').val();
        let idQuestao = celula.text();
        
        if (pontos.trim() !== '' && ordem.trim() !== ''){
            $.ajax({
                url: 'CriaVinculo.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    pontos: pontos,
                    ordem: ordem,
                    questionarioId: qId,
                    questaoId: idQuestao,
                },
                success: function(dados) {
                    if (dados.status === 'sucesso'){
                        //Swal.fire("Cadastro efetuado para a questão de ID " + idQuestao);
                        switchBotaoVinculo($botao);
                    } else if (dados.status === 'erro'){
                        Swal.fire("Ocorreu um erro");
                    } else if (dados.status === 'ja_existe'){
                        Swal.fire("Ocorreu um erro. A questão já está cadastrada");
                    } else if (dados.status === 'ordem_repetida'){
                        Swal.fire("A ordem não pode se repetir");
                    } else if (dados.status === 'ordem_menor_que_um'){
                        Swal.fire("A ordem não pode ser menor que 1");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire("Ocorreu um erro inesperado", '', 'error');
                }
            })
            .done(function(){

            });
        } else {
            Swal.fire("Não pode inserir valores vazios");
            return;
        }
    });

    $('.botao-remove-vinculo').click(function() {
        let botao = $(this);
        let celula = $(this).closest('tr').find('td:first');
        let idQuestao = celula.text();
        
        $.ajax({
            url: 'RemoveVinculo.php',
            type: 'POST',
            dataType: 'json',
            data: {
                questionarioId: qId,
                questaoId: idQuestao,
            },
            success: function(dados) {
                if (dados.status === 'sucesso'){
                    //Swal.fire("Removido Vínculo");
                    switchBotaoVinculo(botao);
                } else if (dados.status === 'erro'){
                    Swal.fire("Ocorreu um erro inesperado ao desvincular");
                }
            },
            error: function(xhs, status, erro) {
                Swal.fire("Ocorreu um erro inesperado");
            }
        })
        .done(function(){

        });
    });
});

function switchBotaoVinculo($botaoVinculo){
    let pontos = $botaoVinculo.closest('tr').find('.ponto-input');
    let ordem = $botaoVinculo.closest('tr').find('.ordem-input');
    $botaoOutro = $botaoVinculo.siblings(".btn").not($botaoVinculo);

    if ($botaoVinculo.hasClass('botao-remove-vinculo')){
        ordem.val('');
        pontos.val('');
    }

    pontos.prop('disabled', !pontos.is(':disabled'));
    ordem.prop('disabled', !ordem.is(':disabled'));

    $botaoVinculo.prop('hidden', true);
    $botaoVinculo.prop('disabled', true);
    $botaoOutro.prop('hidden', false);
    $botaoOutro.prop('disabled', false);
}