$(function () {
    function ajaxCall (theObject) {
        $.ajax({
            type: 'GET',
            url: '//bfi.local/app_dev.php/suche/',
            data: {
                text: theObject.text,
                page: theObject.pageId,
                isProduct: theObject.isProduct,
                isContent: theObject.isContent,
                isInfoEvent: theObject.isInfoEvent,
                productType: theObject.productType,
                dayTime: theObject.dayTime,
                category: theObject.category
            },
            success: function(data) {
                $('.search-head .text').html($(data).find(".search-head .text").html());
                $('.search-result').each(function() {
                    $(this).remove();
                });
                $('.search-title').after($(data).find(".search-result").each(function() {
                    $(this).html();
                }));
                $('.pagination').html($(data).find(".pagination").html());
            }
        });
    }

    var searchResult = {
        text: "",
        pageId: "1",
        isProduct: "",
        isContent: "",
        isInfoEvent: "",
        productType: "",
        dayTime: "",
        category: ""
    }
    var keyPressTimeout;

    // Pagination
    $('.pagination').on("click", 'a', function ( event ) {
        event.preventDefault();
        searchResult.pageId = $(this).html();
        ajaxCall(searchResult);
    });

    //Checkboxes
    $('.course-search-form input[type=checkbox]').change(function () {
        if ($(this).is(':checked')) {
            searchResult[$(this).attr('id')] = $(this).val();
            ajaxCall(searchResult);
        }
        else {
            searchResult[$(this).attr('id')] = '';
            ajaxCall(searchResult);
        }
    });

    //Selects
    $('.course-search-form select').change(function() {
        searchResult[$(this).attr('id')] = $(this).val();
        ajaxCall(searchResult);
    });

    //Search Field
    $('#text').keyup(function() {
        clearTimeout(keyPressTimeout);
        var search = this.value;
        keyPressTimeout = setTimeout( function() {
            searchResult.text = search;
            ajaxCall(searchResult);
        },500);
    });
});