let questionarioId
let respondentesId = []

function marcarLinhaResp(linha) {
    // Adiciona a classe 'marcada' à linha clicada
    let celulaResp = linha.querySelector('td');
    respId = celulaResp.innerHTML;
    if (linha.classList.contains('linhaMarcada')) {
        linha.classList.remove('linhaMarcada');
        let indice = respondentesId.indexOf(respId);
        if (indice > -1) {
            respondentesId.splice(indice, 1);
        }
    } else {
        linha.classList.add('linhaMarcada');
        respondentesId.push(respId)
    }
}

function marcarLinhaQuest(linha) {
    // Remove a classe 'marcada' de todas as linhas da tabela
    var linhas = document.getElementsByTagName('tr');
    for (var i = 0; i < linhas.length; i++) {
        linhas[i].classList.remove('linhaMarcada');
    }
    // Adiciona a classe 'marcada' à linha clicada
    linha.classList.add('linhaMarcada');

    //busca id do questionario
    let celula = linha.querySelector('td');
    questionarioId = celula.innerHTML;
}

$(document).ready(function () {

    $('#btOfertar').click(function () {
        $.ajax({
            url: "CadastraOferta.php",
            method: "POST",
            data:
            {
                questionario: questionarioId,
                respondentesid: respondentesId
            },
            success: function (response) {
                alert('Oferta criada!')
            },
            error: function (xhs, status, erro) {
                console.log(erro)
                alert("Ocorreu um erro");
            }
        });
    });
});