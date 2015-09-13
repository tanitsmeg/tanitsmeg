$(document).ready(function() {
    initTree();

    $('#button-category-save').click(function() {
        submitForm();
    });

});

function submitForm() {
    var tree = $("#category-tree").fancytree("getTree").toDict();
    $('#category-structure').val(JSON.stringify(tree));
    $('#category-form').submit();
}

function initTree() {
    var dataJSON = params['dataJSON'];

    $("#category-tree").fancytree({
        extensions: ["dnd", "edit"],
        source: dataJSON,
        autoActivate: true,
        activeVisible: true,
        dnd: {
            autoExpandMS: 400,
            focusOnClick: true,
            preventVoidMoves: true,
            preventRecursiveMoves: true,
            dragStart: function(node, data) {
                return true;
            },
            dragEnter: function(node, data) {
                return true;
            },
            dragDrop: function(node, data) {
                if (node.parent.parent === null) {
                    data.otherNode.moveTo(node, data.hitMode);
                }
            },
            dragStop: function(node, data) {
            }
        },
        activate: function(event, data) {
        }
    });

//    $("#category-tree").fancytree("getRootNode").visit(function(node) {
//        node.setExpanded(true);
//    });

}

