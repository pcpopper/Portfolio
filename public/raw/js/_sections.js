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
        var currIdx = nextIdx = nextTop = prevTop = scrollTop = height = c = y = 0;
        var sectionsArr = this.sectionsArr;

        nextTop = sections[this.sectionsArr[1]].top;

        $(window).scroll(function () {
            scrollTop = $(window).scrollTop();

            var els = {
                home: $('#home'),
                projects: $('#projects'),
                about: $('#about'),
                contact: $('#contact')
            };

            var vars = {
                home: {
                    blob: {
                        start: {start: 0, end: 0},
                        end: {start: (viewerHeight * .15), end: (viewerHeight * .5)}
                    }
                },
                projects: {
                    me: {
                        start: {start: 0, end: 0},
                        end: {start: 0, end: 0}
                    }
                },
                about: {
                    me: {
                        start: {start: (els.about.offset().top - (viewerHeight - (viewerHeight * .01))), end: (els.about.offset().top - (viewerHeight - (viewerHeight * .15)))},
                        end: {start: (els.about.offset().top - (viewerHeight - (viewerHeight * .75))), end: (els.about.offset().top - (viewerHeight - (viewerHeight * .944)))}
                    }
                },
                contact: {
                    me: {
                        start: {start: 0, end: 0},
                        end: {start: 0, end: 0}
                    }
                }
            };

            // home blog
            points = vars.home.blob;
            if (points.end.start > 0) {
                end = points.end;
                if (scrollTop >= end.start && scrollTop <= end.end) {
                    c = (end.end - end.start);
                    y = 1 - ((((-1 / c) * scrollTop) + (end.start / c)) * -1);

                    elements.blobHome.css({'opacity': y});
                } else if (scrollTop < end.start) {
                    elements.blobHome.css({'opacity': '1'});
                } else {
                    elements.blobHome.css({'opacity': '0'});
                }
            }

             //about me
            points = vars.about.me;
            if (points.start.start > 0) {
                start = points.start;
                end = points.end;
                if (scrollTop >= start.start && scrollTop <= start.end) {
                    c = (start.end - start.start);
                    y = ((((-1 / c) * scrollTop) + (start.start / c)) * -1);

                    elements.divMe.css({'margin-top': (y * -50) + 'px'});
                } else if (scrollTop >= end.start && scrollTop <= end.end) {
                    c = (end.end - end.start);
                    y = 1 - ((((-1 / c) * scrollTop) + (end.start / c)) * -1);

                    elements.divMe.css({'margin-top': (y * -50) + 'px'});
                } else if (scrollTop > start.end && scrollTop < end.start) {
                    elements.divMe.css({'margin-top': '-50px'});
                } else {
                    elements.divMe.css({'margin-top': '0px'});
                }
            }

            if (nextTop != null && scrollTop > nextTop) {
                nextIdx++;
            } else if (scrollTop < prevTop && prevTop > 0) {
                nextIdx--;
            }

            if (nextIdx != currIdx) {
                currIdx = nextIdx;

                prevTop = sections[sectionsArr[currIdx]].top;
                nextTop = ((currIdx + 1) < sectionsArr.length) ? sections[sectionsArr[currIdx + 1]].top : null;
            }
        });
    };

    return this.init();
};
