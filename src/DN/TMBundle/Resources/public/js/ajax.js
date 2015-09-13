$(function () {
    function refreshResults() {
        var data = $('form.course-search-form').serialize();
        $.get(window.location.pathname+'?'+data, function(response){
                $('.search-head .text').html($(response).find(".search-head .text").html());
                $('.search-result').each(function() {
                    $(this).remove();
                });
                if ($('.course-search').length) {
                    $('.course-search-form-wrapper').after($(response).find(".search-result").each(function() {
                        $(this).html();
                    }));
                } else {
                    $('.search-title').after($(response).find(".search-result").each(function() {
                        $(this).html();
                    }));
                }
                //$('.pagination').html($(response).find(".pagination").html());
        });
    }

    $('#subcategories a').click(function(e){
        e.preventDefault();
    });
    $('#subcategories label').click(function (a) {
        $(this).find('input').click();
    });

    $('form.course-search-form').change(function(){
        refreshResults();
    });
});