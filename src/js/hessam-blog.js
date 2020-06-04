var bar_bg = document.getElementById("scrollbar-bg"),
    body = document.body,
    html = document.documentElement;

bar_bg.style.minWidth = document.width + "px";

document.getElementsByTagName("body")[0].onresize = function() {
    // Update the gradient width
    bar_bg.style.minWidth = document.width + "px";
};

window.onscroll = function() {
    // Change the width of the progress bar
    var bar = document.getElementById("scrollbar"),
        dw  = document.documentElement.clientWidth,
        dh  = Math.max( body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight ),
        wh  = window.innerHeight,
        pos = pageYOffset || (document.documentElement.clientHeight ?
            document.documentElement.scrollTop : document.body.scrollTop),
        bw  = ((pos / (dh - wh)) * 100);

    bar.style.width = bw + "%";
};
