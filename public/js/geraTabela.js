$limit = 10;

$(document).ready(function(){

    load_data($limit, 1);

    function load_data(limit, page, query = '')
    {
        let currentScript = $('script').last();
        let tipo = currentScript.data('tipo_tabela');
        let url;
        
        if (params){
            url = "Fetch" + tipo + ".php?" + params;
        } else {
            url = "Fetch" + tipo + ".php";
        }

        $.ajax({
            url: url,
            method: "POST",
            data:
            {
                limit: limit,
                page: page, 
                query: query
            },
            success:function(response)
            {
                var html1 = response.html1;
                var html2 = response.html2;

                $('#dynamic_content').html(html1);
                $('#pagination_list').html(html2);
            }
        });
    }

    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data($limit, page, query);
    });


    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data($limit, 1, query);
    });
});