var maxKey = 0;

$(document).ready(function() {
    initMenuTree();

    $('#menu-title').keyup(function() {
        menuTitleInputChange();
    });

    $('#menu-subtitle').keyup(function() {
        menuSubTitleInputChange();
    });

    $('#menu-url').keyup(function() {
        menuUrlInputChange();
    });

    $('#menu-external-url').keyup(function() {
        menuExternalUrlInputChange();
    });

    $('#menu-redirect-id').keyup(function() {
        menuRedirectIdInputChange();
    });

    $('#menu-overview-id').keyup(function() {
        menuOverviewIdInputChange();
    });

    $('#menu-custom-page').change(function() {
        menuCustomPageSelectChange();
    });

    $('#menu-built-in-page').change(function() {
        menuBuiltInPageSelectChange();
    });

    $('#menu-type').change(function() {
        menuTypeSelectChange();
    });

    $('#menu-show-in-menu').on('ifChanged', function(){
        menuShowInMenuCheckboxChange($(this).is(':checked'));
    });

    $('#button-menu-save').click(function() {
        submitForm();
    });

    $('#button-menu-add').click(function() {
        addNode();
    });

    $('#button-menu-remove').click(function() {
        removeNode();
    });

});


function getMaxKey(tree) {
    $(tree).each(function() {
        if (parseInt(this.key) > maxKey) {
            maxKey = parseInt(this.key);
        }
        if (this.children !== null) {
            getMaxKey(this.children);
        }
    });
}

function submitForm() {
    var tree = $("#menu-tree").fancytree("getTree").toDict();
    $('#menu-structure').val(JSON.stringify(tree));
    $('#menu-form').submit();
}

function addNode() {
    var rootNode = $("#menu-tree").fancytree("getRootNode");
    getMaxKey($("#menu-tree").fancytree("getTree").toDict());
    
    var childNode = rootNode.addChildren({
        key: parseInt(maxKey) + 1,
        title: "new menu",
        subtitle: "",
        type: "customPage",
        externalUrl: "http://",
        url: "new-menu",
        customPage: "-1",
        builtInPage: "-1",
        showInMenu: "true",
        redirect: "-1",
        overview: "-1",
        tooltip: "",
        folder: false
    });

    childNode.setActive();
}

function removeNode() {
    var node = $("#menu-tree").fancytree("getActiveNode");

    node.remove();

    $('.menu-custom-page-container').addClass('hidden');
    $('.menu-external-url-container').addClass('hidden');
    $('.menu-built-in-page-container').addClass('hidden');
    $('.menu-redirect-id-container').addClass('hidden');
    $('.menu-overview-id-container').addClass('hidden');
    $('#menu-title').val('');
    $('#menu-type').val('customPage');

}

function menuTitleInputChange() {
    if ($('#menu-title').val() !== '') {
        var node = $("#menu-tree").fancytree("getActiveNode");
        node.setTitle($('#menu-title').val());
    }
}

function menuSubTitleInputChange() {
    if ($('#menu-subtitle').val() !== '') {
        var node = $("#menu-tree").fancytree("getActiveNode");
        node.data.subtitle = $('#menu-subtitle').val();
    }
}

function menuUrlInputChange() {
    if ($('#menu-url').val() !== '') {
        var node = $("#menu-tree").fancytree("getActiveNode");
        node.data.url = $('#menu-url').val();
        node.render();
    }
}

function menuExternalUrlInputChange() {
    if ($('#menu-external-url').val() !== '') {
        var node = $("#menu-tree").fancytree("getActiveNode");
        node.data.externalUrl = $('#menu-external-url').val();
        node.render();
    }
}

function menuRedirectIdInputChange() {
    if ($('#menu-redirect-id').val() !== '') {
        var node = $("#menu-tree").fancytree("getActiveNode");
        node.data.redirect = $('#menu-redirect-id').val();
        node.render();
    }
}

function menuOverviewIdInputChange() {
    if ($('#menu-overview-id').val() !== '') {
        var node = $("#menu-tree").fancytree("getActiveNode");
        node.data.overview = $('#menu-overview-id').val();
        node.render();
    }
}

function menuShowInMenuCheckboxChange(val) {
    var node = $("#menu-tree").fancytree("getActiveNode");
    node.data.showInMenu = val;
    node.render();
}

function menuCustomPageSelectChange() {
    var node = $("#menu-tree").fancytree("getActiveNode");
    node.data.customPage = $('#menu-custom-page').val();
    node.render();
}

function menuBuiltInPageSelectChange() {
    var node = $("#menu-tree").fancytree("getActiveNode");
    node.data.builtInPage = $('#menu-built-in-page').val();
    
    if (typeof $('#menu-built-in-page').val() !== 'undefined' &&
        $('#menu-built-in-page').val() !== null &&
        $('#menu-built-in-page').val().toString().indexOf('Overview') > -1) {
        $('.menu-overview-id-container').removeClass('hidden');
    } else {
        $('.menu-overview-id-container').addClass('hidden');
    }
    node.render();
}

function menuTypeSelectChange() {
    var node = $("#menu-tree").fancytree("getActiveNode");
    node.data.type = $('#menu-type').val();
    node.render();

    showSelectedMenuType(node);
}

function showSelectedMenuType(node) {
    switch (node.data.type) {
        case 'customPage':
            $('.menu-custom-page-container').removeClass('hidden');
            $('.menu-external-url-container').addClass('hidden');
            $('.menu-built-in-page-container').addClass('hidden');
            $('.menu-redirect-id-container').addClass('hidden');
            $('.menu-overview-id-container').addClass('hidden');
            break;

        case 'externalUrl':
            $('.menu-external-url-container').removeClass('hidden');
            $('.menu-custom-page-container').addClass('hidden');
            $('.menu-built-in-page-container').addClass('hidden');
            $('.menu-redirect-id-container').addClass('hidden');
            $('.menu-overview-id-container').addClass('hidden');
            break;

        case 'builtInPage':
            $('.menu-built-in-page-container').removeClass('hidden');
            $('.menu-custom-page-container').addClass('hidden');
            $('.menu-external-url-container').addClass('hidden');
            $('.menu-overview-id-container').addClass('hidden');
            $('.menu-redirect-id-container').addClass('hidden');
            
            if (typeof node.data.builtInPage !== 'undefined' &&
                node.data.builtInPage !== null &&
                node.data.builtInPage.toString().indexOf('Overview') > -1) {
                $('.menu-overview-id-container').removeClass('hidden');
            }
            break;

        case 'redirect':
            $('.menu-built-in-page-container').addClass('hidden');
            $('.menu-custom-page-container').addClass('hidden');
            $('.menu-external-url-container').addClass('hidden');
            $('.menu-overview-id-container').addClass('hidden');
            $('.menu-redirect-id-container').removeClass('hidden');
            break;
    }
}

function nodeChange(node) {
    $('#menu-title').val(node.title);
    $('#menu-subtitle').val(node.data.subtitle);
    $('#menu-url').val(node.data.url);
    $('#menu-external-url').val(node.data.externalUrl);
    $('#menu-redirect-id').val(node.data.redirect);
    $('#menu-overview-id').val(node.data.overview);
    $('#menu-id').val(node.key);

    (node.data.showInMenu) ? $('#menu-show-in-menu').iCheck('check') : $('#menu-show-in-menu').iCheck('uncheck');

    $('#menu-custom-page').val(node.data.customPage).trigger("change");
    
    if (typeof node.data.builtInPage === 'undefined') {
        $('#menu-built-in-page').val("-1").trigger("change");
    } else {
        $('#menu-built-in-page').val(node.data.builtInPage).trigger("change");
    }

    $('#menu-type').val(node.data.type).trigger("change");

    showSelectedMenuType(node);
}

function initMenuTree() {
    var menuJSON = params['menuJSON'];

    $("#menu-tree").fancytree({
        extensions: ["dnd", "edit"],
        source: menuJSON,
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
                data.otherNode.moveTo(node, data.hitMode);
            }
        },
        activate: function(event, data) {
            $('.menu-type-container').removeClass('hidden');
            $('.menu-title-container').removeClass('hidden');
            $('.menu-url-container').removeClass('hidden');
            $('.menu-show-in-menu').removeClass('hidden');
            $('.menu-redirect-id-container').removeClass('hidden');
            $('.menu-overview-id-container').removeClass('hidden');
            $('.menu-id-container').removeClass('hidden');
            $('.button-menu-remove').removeClass('hidden');

            nodeChange(data.node);
        }
    });

//    $("#menu-tree").fancytree("getRootNode").visit(function(node) {
//        node.setExpanded(true);
//    });

}

