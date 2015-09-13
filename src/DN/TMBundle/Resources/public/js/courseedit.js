$(document).ready(function() {
    $('.date').datepicker({
        showOn: 'button',
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: "-0:+1"
    });
    
    prepareEmbeddedForm('location', 'locations', 'Add a location!');
    prepareEmbeddedForm('coursetime', 'course-times', 'időpont hozzáadása');
});

function prepareEmbeddedForm(type, cssClass, addMessage) {
    // setup an "add a tag" link
    var $addLink = $('<a href="#" class="add_' + type + '_link">' + addMessage + '</a>');
    var $newLinkLi = $('<li></li>').append($addLink);

    // Get the ul that holds the collection of tags
    var $collectionHolder = $('ul.' + cssClass);

    $collectionHolder.find('li').each(function() {
        addFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addForm($collectionHolder, $newLinkLi);
    });
}

function addForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier     
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);
// Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);

    addFormDeleteLink($newFormLi);

    $newLinkLi.before($newFormLi);
}

function addFormDeleteLink($formLi) {
    var $removeFormA = $('<a href="#">delete this</a>');
    $formLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $formLi.remove();
    });
}
