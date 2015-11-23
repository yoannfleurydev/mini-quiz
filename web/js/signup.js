/**
 * Created by valentin on 11/23/15.
 */

$("#user_login").keyup(function () {
    $.post("/mini-quiz/web/signup_check_username",{
            user_login : $("#user_login").val()
        },
        function (data, status) {
            if (data) {
                $("#stateUsername").html('<i class="material-icons">done</i>');
            } else {
                $("#stateUsername").html('<i class="material-icons">error</i>');
            }
        }
    )
});


$("#user_password, #user_password2").keyup(function () {
    verifyPass();
});

function verifyPass() {
    if ($("#user_password").val() != $("#user_password2").val()) {
        $("#statePass, #statePass2").html('<i class="material-icons">error</i>');
    } else {
        $("#statePass, #statePass2").html('<i class="material-icons">done</i>');
    }
}