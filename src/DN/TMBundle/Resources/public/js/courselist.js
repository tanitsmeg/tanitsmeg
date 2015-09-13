$(document).ready(function() {
    $('#search-button').on('click', function() {
        searchTextEntered($('#search-text').val());
    });
    $('li.tag').on('click', function() {
        tagCheckClick(this);
    });
    $('.param-check').on('click', function() {
        paramCheckClick(this);
    });
});

function tagCheckClick(element) {
    var key = $(element).attr('data-slug');
    if ($(element).hasClass('selected')) {
        value = false;
        $(element).removeClass('selected');
    } else {
        value = true;
        $(element).addClass('selected');
    }
    
    var index = -1;
    if (params['filters']['tags'] != null) {
        index = params['filters']['tags'].indexOf(key);
    } else {
        params['filters']['tags'] = [];
    }
    
    if (value) {
        if (index == -1) {
            params['filters']['tags'].push(key);
        }
    } else {
        if (index != -1) {
            params['filters']['tags'].splice(index);
        }
    }

    callCourseListAjax();
}

function paramCheckClick(element) {
    var key = $(element).attr('name');
    var value = $(element).prop('checked');
    
    var index = -1;
    if (params['filters']['params'] != null) {
        index = params['filters']['params'].indexOf(key);
    } else {
        params['filters']['params'] = [];
    }
    
    if (value) {
        if (index == -1) {
            params['filters']['params'].push(key);
        }
    } else {
        if (index != -1) {
            params['filters']['params'].splice(index);
        }
    }

    callCourseListAjax();
}

function callCourseListAjax() {
    $.ajax({
        type        : "POST",
        url         : params['courseListAjaxPath'],
        dataType    : 'html',
        data        : {
            filters : params['filters']
        },
        success: function(response) {
            $('.course-list-results').html(response);
//            var urlPath = 'abcdef';
//            window.history.pushState({"html": response.html, "pageTitle": 'reloaded...'},"", urlPath);
        }
    });
}

function searchTextEntered(text) {
    if (!text) return false;
    params['filters']['text'] = text;
    callCourseListAjax();
}
