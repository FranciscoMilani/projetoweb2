$(document).ready(function(){
    var $limit = 5;
    load_data({limit: $limit, page:1});

    function load_data(object)
    {
        let currentScript = $('script').last();
        let tipo = currentScript.data('tipo_tabela');
        let url;

        if (typeof params !== 'undefined') {
            url = "Fetch" + tipo + ".php?" + params;
        } else {
            url = "Fetch" + tipo + ".php";
        }

        if (typeof newObj !== 'undefined'){
            object = Object.assign(object, newObj);
        }

        $.ajax({
            url: url,
            method: "POST",
            data: object,
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
        load_data({limit: $limit, page:page, query:query});
    });


    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data({limit:$limit, page:1, query:query});
    });
});