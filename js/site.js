$(document).ready(function (){
    $('#selecionavel').hide();

    // $('#radio_selecionavel').change(function(){
    //     $('#selecionavel').toggle();
    // })
})

function selectEsconde(radio){
    var selecionavel = document.getElementById("selecionavel");

    if (radio == 'selecionavel') {
        selecionavel.style.display = "block";
    } else {
        selecionavel.style.display = "none";
    }
}
