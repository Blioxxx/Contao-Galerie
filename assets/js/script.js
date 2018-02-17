function setMinHeight() {
    const images = document.getElementsByClassName('images');

    var minHeight;

    for (let item of images) {
        if(item.clientHeight > minHeight) {
            minHeight = item.clientHeight;
        }
    }

    for (let item of images) {
        item.style.minHeight = minHeight;
    }

}

setMinHeight()