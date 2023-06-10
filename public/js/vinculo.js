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
                        alert('Cadastro efetuado para a questão de ID ' + idQuestao);
                        switchBotaoVinculo($botao);
                    } else if (dados.status === 'erro'){
                        alert('Ocorreu um erro inesperado.');
                    } else if (dados.status === 'ja_existe'){
                        alert('Ocorreu um erro. A questão já está cadastrada.');
                    } else if (dados.status === 'ordem_repetida'){
                        alert('A ordem não pode se repetir');
                    }
                },
                error: function(xhs, status, erro) {
                    console.log(erro)
                    alert("Ocorreu um erro");
                }
            })
            .done(function(){

            });
        } else {
            alert('Não pode inserir valores vazios');
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
                    alert('Removido vínculo');
                    switchBotaoVinculo(botao);
                } else if (dados.status === 'erro'){
                    alert('Ocorreu um erro inesperado ao remover');
                }
            },
            error: function(xhs, status, erro) {
                console.log(erro)
                alert("Ocorreu um erro");
            }
        })
        .done(function(){

        });
    });
});

function switchBotaoVinculo($botaoVinculo){
    pontos = $botaoVinculo.closest('tr').find('.ponto-input');
    ordem = $botaoVinculo.closest('tr').find('.ordem-input');

    if ($botaoVinculo.text() === 'Remover'){
        $botaoOutro = $botaoVinculo.closest('tr').find('.botao-vinculo');

        $botaoVinculo.attr('disabled', true);
        $botaoOutro.attr('disabled', false);
        ordem.val('');
        pontos.val('');
        pontos.attr('disabled', false);
        ordem.attr('disabled', false);
        
    } else {
        $botaoOutro = $botaoVinculo.closest('tr').find('.botao-remove-vinculo');

        $botaoVinculo.attr('disabled', true);
        $botaoOutro.attr('disabled', false);
        pontos.attr('disabled', true);
        ordem.attr('disabled', true);
    }
}