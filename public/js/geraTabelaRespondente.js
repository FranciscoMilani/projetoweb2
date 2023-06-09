$(document).ready(function(){
    let limit = 5;
    
    load_data(limit, 1);

    function load_data(limit, page, query = '')
    {
        $.ajax({
            url: "FetchRespondente.php",
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

                $('#dynamic_content2').html(html1);
                $('#pagination_list2').html(html2);
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