$(document).ready(function() {
    $('#btn-add-comment').on('click', function() {
        addCommentAjax();
    });

});

function addCommentAjax() {
    var content = $('#inp-add-comment').val();
    $.ajax({
        type        : "POST",
        url         : params['saveCommentAjaxUrl'],
        dataType    : 'json',
        data        : {
            c : content,
            et : params['entityType'],
            es : params['entitySlug']
        },
        success: function(response) {
            if (response.success == 'true') {
                $('ul.comments').append('<li>' + response.content + '</li>');
            }
        }
    });
}

