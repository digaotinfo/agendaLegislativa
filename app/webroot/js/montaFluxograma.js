function onLoad()
{
    // setMenu();
    resizeCanvas();
    initPageObjects();
}

/**
 * Resizes the main canvas to the maximum visible height.
 */
function resizeCanvas()
{
    var divElement = document.getElementById("mainCanvas");
    var screenHeight = window.innerHeight || document.body.offsetHeight;
    divElement.style.height = (screenHeight - 16) + "px";
}

/**
 * Strips the file extension and everything after from a url
 */
function stripExtension(url)
{
    var lastDotPos = url.lastIndexOf('.');
    if(lastDotPos > 0)
        return url.substring(0, lastDotPos - 1);
    else
        return url;
}

/**
 * this function opens a popup to show samples during explanations.
 */
function openSample(url)
{
    var popup = window.open(url, "sampleWindow", "width=400,height=300");
    popup.focus();
    return false;
}
