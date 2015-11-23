/**
 * Created by valentin on 11/23/15.
 */
$("#password").keyup(function () {
    verifPass();
});

$("#password2").keyup(function () {
    verifPass();
});

function verifPass() {
    if ($("#password").val() != $("#password2").val()) {
        $("#statePass").html('<i class="material-icons">error</i>');
        $("#statePass2").html('<i class="material-icons">error</i>');
    } else {
        $("#statePass").html('<i class="material-icons">done</i>');
        $("#statePass2").html('<i class="material-icons">done</i>');
    }
}