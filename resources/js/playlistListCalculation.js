function setMaxHeight() {
    let availableHeight = $("#video-container").height();

    availableHeight -= $("#header-container").height();
    availableHeight -= $("#controls").height();

    $("#video-list-container").css("max-height", availableHeight + "px");
}

$('#video-container').ready(function () {
    setMaxHeight();
});

$(window).resize(function () {
    setMaxHeight();
});

$('#video').on('loadeddata', setMaxHeight);
