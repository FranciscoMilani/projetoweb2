$(document).ready(function (){
    $('#selecionavel').hide();

    $('.radio-questao').change(function(){
        console.log('teste');
        if ($(this).val() == "selecionavel") {
            $('#selecionavel').show();
        }
        else if ($(this).val() == "discursiva") {
            $('#selecionavel').hide();
        }
    });


    // $('.cadastro-questao-form').submit(function () {
    //     return false;
    // });
})
