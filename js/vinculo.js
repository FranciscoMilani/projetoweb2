var questoesInseridas = [];

$(document).ready(function(){
    $('.table-row').each(function(index, el){
        let linha = $(this);
        let celula = $(el).find('td').eq(5);
        let botao = celula.find('>:first-child');

        botao.click(function(){
            console.log(linha.text());
            habilitaInputs(linha);
            switchBotao(botao, $(el).find('td').eq(6).find('>:first-child'));
        });
    })


    $('.botao-enviar-questao').click(function() {

        let celula = $(this).closest('tr').find('td:first');
        let texto = celula.text();
        
        let pontos = $(this).closest('tr').find('.ponto-input').val();
        let ordem = $(this).closest('tr').find('.ordem-input').val();

        
        if (pontos.trim() !== '' && ordem.trim() !== ''){
            $.ajax({
                url: 'CriaVinculo.php',
                type: 'POST',
                data: {
                    id: texto,
                },
                success: function() {
                    alert('Cadastrado questao ' + texto);
                },
                error: function() {
                    alert('Erro no cadastro ' + texto);
                },
                complete: function() {
                    
                } 
            });
            
            $(this).closest('tr').remove();
        } else {
            alert('Não pode inserir valores vazios');
            return;
        }

    });
});

function switchBotao($botao, $botaoEnviar){
    $botaoEnviar.prop('disabled',  !$botaoEnviar.prop('disabled'));
    if ($botao.text() == '+'){
        $botao.text("-");
    }
    else{
        $botao.text("+");
    }
}

function habilitaInputs(linha){
    ponto = linha[0].cells[3].querySelector('input');
    ordem = linha[0].cells[4].querySelector('input');
    ponto.disabled = !ponto.disabled;
    ordem.disabled = !ordem.disabled;
    ponto.value = "";
    ordem.value = "";
}

// function bloqueiaQuestao(questao){
    
// }