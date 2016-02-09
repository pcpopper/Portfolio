var Sections = function (options) {
    this.sectionsArr = [];

    this.init = function (options) {
        this.setupVars();
        this.watchScrolling();
    };

    this.setupVars = function () {
        var _self = this;

        $.each(sections, function (el, vars) {
            if (vars.show) {
                _self.sectionsArr.push(el);
            }
        });
    };

    this.watchScrolling = function () {
        var currIdx = 0;
        var nextIdx = 0;
        var nextTop = 0;
        var prevTop = 0;
        var sectionsArr = this.sectionsArr;
        var scrollTop = 0;
        var height = 0;

        nextTop = sections[this.sectionsArr[1]].top;

        $(window).scroll(function () {
            scrollTop = $(window).scrollTop();

            switch (sectionsArr[currIdx]) {
                case 'home':
                    height = $('#home').height();
                    points = {start: 0, mid: (height * .25), end: (height * .5)};

                    if (scrollTop >= points.mid && scrollTop <= points.end) {
                        //elements.blobHome.css({opacity})
                        console.log(((points.end - points.mid) / points.end));
                    }
                    //console.log([, scrollTop]);
                    //
                    //if (scrollTop < (height * .015)) {
                    //    elements.blobHome.css({'margin-left': elementsInfo.blobHome['margin-left'].mid});
                    //} else {
                    //    elements.blobHome.css({'margin-left': (elementsInfo.blobHome['margin-left'].end * (perLocation + .1)) + 'px'});
                    //}
                    break;
                case 1:
                    //if ()
                    break;
            }

            if (nextTop != null && scrollTop > nextTop) {
                nextIdx++;
            } else if (scrollTop < prevTop && prevTop > 0) {
                nextIdx--;
            }

            //console.log([prevTop, scrollTop, nextTop, '-', currIdx, nextIdx, '-',  _self.sectionsMenuArr[nextIdx], (_self.sectionsMenuArr[nextIdx] != '')?'true':'false']);
            if (nextIdx != currIdx) {
                currIdx = nextIdx;

                prevTop = sections[sectionsArr[currIdx]].top;
                nextTop = ((currIdx + 1) < sectionsArr.length) ? sections[sectionsArr[currIdx + 1]].top : null;
            }
        });
        //var viewerheightAdjusted = (viewerHeight * .5);
        //var currIdx = Math.floor(currLoc / viewerheightAdjusted);
        //var perLocation = ((currLoc - (currIdx * viewerheightAdjusted)) / viewerheightAdjusted);
        //
        //switch (currIdx) {
        //    case 0:
        //        if (isNaN(perLocation) || perLocation < 0.01) {
        //            elements.blobHome.css({'margin-left': elementsInfo.blobHome['margin-left'].mid});
        //        } else {
        //            elements.blobHome.css({'margin-left': (elementsInfo.blobHome['margin-left'].end * (perLocation + .1)) + 'px'});
        //        }
        //        break;
        //    case 1:
        //        //if ()
        //        break;
        //}
        //
        //if (currIdx > 0) {
        //    elements.blobHome.css({'margin-left': elementsInfo.blobHome['margin-left'].end + 'px'});
        //} else {
        //    //elements.
        //}
    };

    return this.init();
};
