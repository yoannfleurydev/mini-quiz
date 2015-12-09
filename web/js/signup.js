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
    if ($("#user_password").val() != $("#user_password2").val()) {
        $("#statePass, #statePass2").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
    } else {
        $("#statePass, #statePass2").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
    }
}