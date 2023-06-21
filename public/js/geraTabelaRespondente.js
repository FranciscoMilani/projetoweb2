$limit = 10;
$(document).ready(function(){
    
    load_data($limit, 1);

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
                var html3 = response.html3;
                var html4 = response.html4;

                $('#dynamic_content2').html(html3);
                $('#pagination_list2').html(html4);
            }
        });
    }

    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page_number_resp');
        var query = $('#search_box2').val();
        load_data($limit, page, query);
    });


    $('#search_box2').keyup(function(){
        var query = $('#search_box2').val();
        load_data($limit, 1, query);
    });
});