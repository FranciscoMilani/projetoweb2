function marcarLinhaResp(linha) {
    // Adiciona a classe 'marcada' à linha clicada
    linha.classList.add('linhaMarcada');
}

function marcarLinhaQuest(linha) {
    // Remove a classe 'marcada' de todas as linhas da tabela
    var linhas = document.getElementsByTagName('tr');
    for (var i = 0; i < linhas.length; i++) {
        linhas[i].classList.remove('linhaMarcada');
    }

    // Adiciona a classe 'marcada' à linha clicada
    linha.classList.add('linhaMarcada');
}