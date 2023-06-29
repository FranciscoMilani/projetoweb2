$(document).ready(function(){
    let limit = 5;

    load_data(limit, 1);

    function load_data(limit, page, query = '')
    {
        $.ajax({
            url: "FetchOfertarRespondente.php",
            method: "POST",
            data:
            {
                limit: limit,
                page: page, 
                query: query
            },
            success:function(response)
            {
                let html3 = response.html3;
                let html4 = response.html4;

                $('#dynamic_content2').html(html3);
                $('#pagination_list2').html(html4);
                atualiza_lista_respondente();
            }
        });
    }

    $(document).on('click', '#pagination_list2 .page-link', function() {
        let page = $(this).data('page_number2');
        let query = $('#search_box2').val();
        load_data(limit, page, query);
    });


    $('#search_box2').keyup(function(){
        let query = $('#search_box2').val();
        load_data(limit, 1, query);
    });
});