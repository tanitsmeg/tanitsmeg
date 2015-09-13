$(document).ready(function() {
    console.log('appaodpaopk');
    convertFormData();
});

function convertFormData() {
    var pt = $('.bfi-form-data').val();

    var s = JSON.parse(pt);
    var text = '';
    $.each(s, function(index, value) {
        if (value === null) {
            value = '-';
        }
        text += '<li>' + index + ': <span style="font-weight: bold;">' + value + '</span></li>';
    });

    $('.sonata-ba-collapsed-fields').append('<div class="sonata-ba-field sonata-ba-field-standard-natural"><ul>' + text + '</ul></div>');
//    $('.bfi-form-data').val(text);
}

