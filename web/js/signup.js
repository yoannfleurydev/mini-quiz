/**
 * Created by valentin on 11/23/15.
 */
$("#user_password").keyup(function () {
    verifPass();
});

$("#user_password2").keyup(function () {
    verifPass();
});

function verifPass() {
    if ($("#user_password").val() != $("#user_password2").val()) {
        $("#statePass").html('<i class="material-icons">error</i>');
        $("#statePass2").html('<i class="material-icons">error</i>');
    } else {
        $("#statePass").html('<i class="material-icons">done</i>');
        $("#statePass2").html('<i class="material-icons">done</i>');
    }
}