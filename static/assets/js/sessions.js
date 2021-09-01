function TimeoutAutoLogout(params) {
    event.preventDefault();
    params.button_submit.disabled = true;

    $.ajax({
        type: params.method,
        url: params.action,
        data: { password: params.password.value },
        success: function (result) {
            params.password.value = "";
            params.button_submit.disabled = false;

            if (result == 200) {
                resetTimer();
                $("#modal_timeout_auto_logout").modal("hide");
            } else {
                sessionErrorCount--;
                if (sessionErrorCount == 0) {
                    location = logout_url;
                } else {
                    new Noty({
                        text: result,
                        type: "error",
                    }).show();
                    document.querySelector("#sessionErrorCounts").innerHTML =
                        sessionErrorCount;
                }
            }
        },
    });
}

function startTimer() {
    // window.setTimeout returns an Id that can be used to start and stop a timer
    warningTimerID = window.setTimeout(warningInactive, warningTimeout);
}

function warningInactive() {
    window.clearTimeout(warningTimerID);
    timeoutTimerID = window.setTimeout(IdleTimeout, timoutNow);
    $.ajax({ url: timeout_mark });
    sessionErrorCount = 3;
    document.querySelector("#sessionErrorCounts").innerHTML = sessionErrorCount;

    $("#modal_timeout_auto_logout").modal({
        backdrop: "static",
        keyboard: false,
    });
}

function resetTimer() {
    window.clearTimeout(timeoutTimerID);
    window.clearTimeout(warningTimerID);
    startTimer();
}

// Logout the user.
function IdleTimeout() {
    location = logout_url;
}

function setupTimers() {
    document.addEventListener("mousemove", resetTimer, false);
    document.addEventListener("mousedown", resetTimer, false);
    document.addEventListener("keypress", resetTimer, false);
    document.addEventListener("touchmove", resetTimer, false);
    document.addEventListener("onscroll", resetTimer, false);
    startTimer();
}

$(document).ready(function () {
    if (typeof sessionActive !== "undefined" && sessionActive) {
        setupTimers();
    }
    warningInactive();
});
