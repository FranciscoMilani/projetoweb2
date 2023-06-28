let questionarioId;
let respondentesId = {};

// Atualiza a lista de questionários para mostrar os campos marcados quando a página for alterada
function atualiza_lista_questionario(){
    $("#dynamic_content table").find("tr[onclick]").each(function(){
        if (questionarioId == $(this).find("td:first").text()){
            marcarLinhaQuest(this);
        }
    });
}

// Atualiza a lista de respondentes para mostrar os campos marcados quando a página for alterada
function atualiza_lista_respondente(){
    $("#dynamic_content2 table").find("tr[onclick]").each(function(){
        if (respondentesId[$(this).find("td:first").text()] !== undefined){
            marcarLinhaResp(this);
        }
    });
}

function marcarLinhaResp(linha) {
    // Atribui os valores
    let id = $(linha).find("td:first").text();
    let nome = $(linha).find("td:eq(1)").text();

    // Marca/Desmarca as linhas e atualiza a estrutura de dados
    if (linha.classList.contains('linhaMarcada')) {
        delete respondentesId[id];
        linha.classList.remove('linhaMarcada');
    } else {
        respondentesId[id] = nome;
        linha.classList.add('linhaMarcada');
    }
}

function desmarcaLinhasEReseta() {
    questionarioId = undefined;
    respondentesId = {};
    $('.linhaMarcada').removeClass('linhaMarcada');
}

function marcarLinhaQuest(linha) {
    // Remove a classe 'marcada' de todas as linhas da tabela de questionários
    var linhas = document.querySelectorAll('#dynamic_content tr');
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
        if (questionarioId === undefined && Object.keys(respondentesId).length <= 0) {
            Swal.fire("Informe ao menos um questionário e um respondente");
            return;
        } else if (questionarioId === undefined) {
            Swal.fire("Informe ao menos um questionário");
            return;
        } else if (Object.keys(respondentesId).length <= 0) {
            Swal.fire("Informe ao menos um respondente");
            return;
        }

        let nomesRespondentes = Object.keys(respondentesId)
                            .sort()
                            .map(key => respondentesId[key])
                            .join(", ");

        Swal.fire({
            title: "Confirmar Oferta",
            text: "Enviar oferta do questionário " + questionarioId + " para " + nomesRespondentes + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "CadastraOferta.php",
                    method: "POST",
                    contentType: 'application/x-www-form-urlencoded', // enviando url encoded
                    dataType: 'json', // retornando json
                    data:
                    {
                        questionario: questionarioId,
                        respondentesid: Object.keys(respondentesId)
                    },
                    success: function (resposta) {
                        if (resposta.mensagem != null){
                            desmarcaLinhasEReseta();
                            Swal.fire(
                                'Oferta feita!',
                                resposta.mensagem,
                                'success'
                            )
                        }
                    },
                    error: function (xhr, status, erro) {
                        desmarcaLinhasEReseta();
                        Swal.fire(
                            'Ocorreu um erro',
                            '[' + erro + '] ' + xhr.responseJSON.mensagem,
                            'error'
                        )
                    }
                });
            }
        })
    });
});