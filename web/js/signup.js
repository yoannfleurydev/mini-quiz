$("document").ready(function() {
    $('#statePass, #statePass2').hide();
});

$("#user_login").keyup(function () {
    $.post("/mini-quiz/web/signup_check_username", {
            user_login: $("#user_login").val()
        },
        function (data, status) {
            if (data) {
                $("#stateUsername").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
            } else {
                $("#stateUsername").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
            }
        }
    )
});


$("#user_password, #user_password2").keyup(function () {
    verifyPass();
});

function verifyPass() {
    var userPassword = $("#user_password");
    var userPassword2 = $("#user_password2");
    var userPasswordLength = userPassword.val().length;
    var userPassword2Length = userPassword2.val().length;

    if (userPasswordLength > 0 && userPassword2Length > 0 && userPasswordLength === userPassword2Length) {
        $('#statePass, #statePass2').toggle();
    } else if (userPasswordLength <= 0 && userPassword2Length <= 0) {
        $('#statePass, #statePass2').hide();
    }

    if (userPassword.val() != userPassword2.val()) {
        $("#statePass, #statePass2").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
    } else {
        $("#statePass, #statePass2").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
    }
}