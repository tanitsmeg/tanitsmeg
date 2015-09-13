var
        emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
        signupUserDialog, signupUserForm,
        signupUserNameField = $("#signup-user-name"),
        signupUserEmailField = $("#signup-user-email"),
        signupUserPasswordField = $("#signup-user-password"),
        signupUserPassword2Field = $("#signup-user-password2"),
        signupUserFields = $([]).add(signupUserNameField).add(signupUserEmailField).add(signupUserPasswordField),
        signupUserTips = $(".signup-user-validateTips");

$(document).ready(function() {
    signupUserDialog = $("#signup-user-form").dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Create an account": signupUser,
            Cancel: function() {
                signupUserDialog.dialog("close");
            }
        },
        close: function() {
            signupUserForm[0].reset();
            signupUserFields.removeClass("ui-state-error");
        }
    });

    signupUserForm = signupUserDialog.find("form").on("submit", function(event) {
        event.preventDefault();
        signup();
    });

    $('.btn-signup').on('click', function() {
        signupClick();
    });
});

function signupClick() {
    console.log('signup', signupUserDialog);
    signupUserDialog.dialog('open');
}

function updateTips(t, tips) {
    $(tips)
            .text(t)
            .addClass("ui-state-highlight");
    setTimeout(function() {
        $(tips).removeClass("ui-state-highlight", 1500);
    }, 500);
}

function checkLength(o, n, min, max, tips) {
    console.log(o, o.val());
    if (o.val().length > max || o.val().length < min) {
        o.addClass("ui-state-error");
        updateTips("Length of " + n + " must be between " +
                min + " and " + max + ".", tips);
        return false;
    } else {
        return true;
    }
}

function checkRegexp(o, regexp, n, tips) {
    if (!(regexp.test(o.val()))) {
        o.addClass("ui-state-error");
        updateTips(n, tips);
        return false;
    } else {
        return true;
    }
}

function signupUser() {
    var valid = true;

    signupUserFields.removeClass("ui-state-error");
    valid = valid && checkLength(signupUserNameField, "username", 3, 16, $('.signup-user-validateTips'));
    valid = valid && checkLength(signupUserEmailField, "email", 6, 80, $('.signup-user-validateTips'));
    valid = valid && checkLength(signupUserPasswordField, "password", 5, 16, $('.signup-user-validateTips'));

    valid = valid && checkRegexp(signupUserNameField, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter.", $('.signup-user-validateTips'));
    valid = valid && checkRegexp(signupUserEmailField, emailRegex, "eg. ui@jquery.com", $('.signup-user-validateTips'));
    valid = valid && checkRegexp(signupUserPasswordField, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9", $('.signup-user-validateTips'));

    if (valid) {
        console.log('adding...');
        var url = $(signupUserForm).attr('action');
        console.log(url);
        $.ajax({
            type        : "POST",
            url         : url,
            dataType    : 'json',
            data        : {
                name : $(signupUserNameField).val(),
                email : $(signupUserEmailField).val(),
                password : $(signupUserPasswordField).val()
            },
            success: function(response) {
                $(response.messages).each(function() {
                    
                console.log(this);
                    $('.signup-user-messages').append(this.text);
                });
                var urlPath = 'abcdef';
    //            window.history.pushState({"html": response.html, "pageTitle": 'reloaded...'},"", urlPath);
            }
        });
        
//        signupUserDialog.dialog("close");
    }
    return valid;
}

