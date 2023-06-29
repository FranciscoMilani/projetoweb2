$(document).ready(function(){
    let limit = 5;    

    load_data(limit, 1);

    function load_data(limit, page, query = '')
    {
        $.ajax({
            url: "FetchOfertarQuestionario.php",
            method: "POST",
            data:
            {
                limit: limit,
                page: page, 
                query: query
            },
            success:function(response)
            {
                let html1 = response.html1;
                let html2 = response.html2;

                $('#dynamic_content').html(html1);
                atualiza_lista_questionario();
                $('#pagination_list').html(html2);
            }
        });
    }

    $(document).on('click', '#pagination_list .page-link', function() {
        let page = $(this).data('page_number');
        let query = $('#search_box').val();
        load_data(limit, page, query);
    });


    $('#search_box').keyup(function(){
        let query = $('#search_box').val();
        load_data(limit, 1, query);
    });
});