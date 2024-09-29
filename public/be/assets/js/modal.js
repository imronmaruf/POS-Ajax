function modalOpen(event) {
    event.show().removeClass("fade");
    $("body").addClass("modal-open");
}

function modalClose(event) {
    event.addClass("modal-open");
    setTimeout(function () {
        event.hide();
        $("body").removeClass("modal-open");
    }, 100);
}
