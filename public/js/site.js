var qtdAtual = 0;

$(document).ready(function (){
    atualizaSelectOptions(0);

    $('#selecionavel').hide();

    $('.radio-questao').change(function(){
        if ($(this).val() == "selecionavel") {
            atualizaSelectOptions($('#quantidade-alternativas').val());
            $('#selecionavel').show();
        }
        else if ($(this).val() == "discursiva") {
            $('#selecionavel').hide();
            atualizaSelectOptions(0)
        }
    });

    $('#quantidade-alternativas').change(function(){
        atualizaSelectOptions(parseInt($(this).val()));
    });

    $('.cadastro-questao-form').submit(function(e){
        checks = $('input:checkbox:checked').length;

        if ($('.radio-questao:checked').val() == 'selecionavel'){
            if (checks == 0){
                e.preventDefault();
                alert('Selecione ao menos uma alternativa');
                //Swal.fire('Selecione ao menos uma alternativa');
                return false;
            }
            
            $('.texto-alternativa').each(function(){
                let str = $(this).val().trim()
                if (!str){
                    e.preventDefault();
                    alert('Preencha o texto de todas as alternativas');
                    //Swal.fire('Preencha o texto de todas as alternativas');
                    return false;
                }
            })
        }
    })
})

function atualizaSelectOptions(qtd){
    let qtdNova = qtd;
    let diferenca =  qtdNova - qtdAtual;
   
    if (qtdAtual < qtdNova){
        for (i = 0; i < diferenca; i++){
            let index = i + qtdAtual + 1;

            $('#selects').append(`
                <div class="input-group mb-3 select-container">
                    <div class="input-group-text">
                        <input type="hidden" id="checkbox_hidden" name="alternativa${index}" value="0">
                        <input type="checkbox" class="form-check-input mt-0" id="${index}" name="alternativa${index}" value="1">
                    </div>
                    <input class="form-control texto-alternativa" type="text" id="${index}" name="alternativaTexto[]" required>
                </div>
            `);
        };
    } else if (qtdAtual > qtdNova){
        $('#selects .select-container').slice(qtdNova).remove();
    }
    qtdAtual = qtdNova;

}

function valida(element){
   // element.prop('checked');

}