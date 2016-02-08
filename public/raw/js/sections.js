$(window).scroll(function () {
    if (elements.blobHome.hasClass('ease')) { elements.blobHome.removeClass('ease'); }

    var currLoc = $(window).scrollTop();
    var viewerheightAdjusted = (viewerHeight * .5);
    var currIdx = Math.floor(currLoc / viewerheightAdjusted);
    var perLocation = ((currLoc - (currIdx * viewerheightAdjusted)) / viewerheightAdjusted);

    switch (currIdx) {
        case 0:
            if (isNaN(perLocation) || perLocation < 0.01) {
                elements.blobHome.css({'margin-left': elementsInfo.blobHome['margin-left'].mid});
            } else {
                elements.blobHome.css({'margin-left': (elementsInfo.blobHome['margin-left'].end * (perLocation + .1)) + 'px'});
            }
            break;
        case 1:

            break;
    }

    if (currIdx > 0) {
        elements.blobHome.css({'margin-left': elementsInfo.blobHome['margin-left'].end + 'px'});
    }
});