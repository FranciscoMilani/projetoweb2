let respId;
let limit = 5;

function carregaDetalhe(linha){
    let query = $('#search_box').val();
    let id = $(linha).find(">:first-child").text();

    if ($(linha).find(">:first-child").text() !== null){
        respId = id;
    }

    pagina(limit, undefined, query, respId);
}

function pagina(limit, page = 1, query = '', respId){
    $.ajax({
        url: "FetchResultado.php",
        method: "POST",
        data:
        {
            limit: limit,
            page: page, 
            query: query,
            respId: respId
        },
        success:function(response)
        {
            let html3 = response.html3;
            let html4 = response.html4;

            $('#dynamic_content').html(html3);
            $('#pagination_list').html(html4);
        }
    });
}

$(document).on('click', '#pagination_list .page-link', function() {
    let page = $(this).data('page_number');
    let query = $('#search_box').val();
    pagina(limit, page, query, respId);
});


$(document).on('keyup', '#search_box', function(){
    let query = $('#search_box').val();
    pagina(limit, undefined, query, respId);
});
