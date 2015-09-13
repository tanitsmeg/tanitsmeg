$(document).ready(function() {

    convertPageTypes();
    convertPageIds();

    pageTypeEdited($('.bfi-page-types'));

    $('.bfi-page-types').bind('keyup', function() {
        pageTypeEdited(this);
    });
});

function convertPageTypes() {
    var pt = $('.bfi-page-types').val();
    var s = '';
    if (pt !== '') {
        var arr = JSON.parse(pt);

        for (var i=0; i<arr.length; i++) {
            s += arr[i];
            if (i < arr.length - 1) {
                s += ', ';
            }
        }
    }

    $('.bfi-page-types').val(s);
}

function convertPageIds() {
    var pt = $('.bfi-page-ids').val();
    var s = '';
    if (pt !== '') {
        var arr = JSON.parse(pt);

        for (var i=0; i<arr.length; i++) {
            s += arr[i];
            if (i < arr.length - 1) {
                s += ', ';
            }
        }
    }

    $('.bfi-page-ids').val(s);
}

function pageTypeEdited(element) {
    var val = $(element).val();
    var arr = val.split(',');
    $.each(arr, function(key, value) {
        arr[key] = $.trim(value);
    });
    if (arr.length === 1) {
        $('.bfi-page-ids').removeAttr('disabled');
    } else {
        $('.bfi-page-ids').attr('disabled', 'disabled');
    }
}

