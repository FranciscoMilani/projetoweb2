$limit = 10;
$(document).ready(function(){
    
    load_data($limit, 1);

    function load_data(limit, page, query = '')
    {
        $.ajax({
            url: "OfertarQuestionario.php",
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
        var query = $('#pesquisaQuest').val();
        load_data($limit, page, query);
    });


    $('#pesquisaQuest').keyup(function(){
        var query = $('#pesquisaQuest').val();
        load_data($limit, 1, query);
    });
});