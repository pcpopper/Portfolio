$.fn.extend({
    next_css: function(css) {
        return $(this).queue(function(next) {
            $(this).css(css);
            next();
        });
    }
});
var TopMenu = function (options) {
    this.sectionsArr = [];
    this.sectionsIdx = [];

    this.init = function (options) {
        this.buildMenu();
        this.watchScrolling();
        this.bindMenu();
    };

    this.buildMenu = function () {
        var _self = this;
        var idx = '';

        $.each(sections, function (el, vars) {

            if (vars.menu) {
                var string = el.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
                var newItem = $('<span>').attr({'id': 'link-' + el, 'data-section': el, 'class': (vars.isDefault) ? 'link active' : 'link inactive'}).html(string);
                elements.divLinks.append(newItem);

                idx = el;
            }

            if (vars.show) {
                _self.sectionsIdx.push(idx);
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
        var sectionsIdx = this.sectionsIdx;
        var scrollTop = 0;

        nextTop = sections[this.sectionsArr[1]].top;

        $(window).scroll(function () {
            scrollTop = $(window).scrollTop();

            if (nextTop != null && scrollTop > nextTop) {
                nextIdx++;
            } else if (scrollTop < prevTop && prevTop > 0) {
                nextIdx--;
            }

            //console.log([prevTop, scrollTop, nextTop, '-', currIdx, nextIdx, '-',  _self.sectionsMenuArr[nextIdx], (_self.sectionsMenuArr[nextIdx] != '')?'true':'false']);
            if (nextIdx != currIdx) {
                $('#link-' + sectionsIdx[currIdx]).removeClass('active').addClass('inactive');
                $('#link-' + sectionsIdx[nextIdx]).removeClass('inactive').addClass('active');
                currIdx = nextIdx;

                prevTop = sections[sectionsArr[currIdx]].top;
                nextTop = ((currIdx + 1) < sectionsArr.length) ? sections[sectionsArr[currIdx + 1]].top : null;
            }
        });
    };

    this.bindMenu = function () {
        $('.link').on('click', this.scrollToSection);
    };

    this.scrollToSection = function (event) {
        var targetEl = $(event.target);

        if (targetEl.hasClass('inactive')) {
            var el = $('#' + targetEl.data('section'));

            $('html, body').animate({
                scrollTop: el.offset().top - (elements.navMenu.height() + 12)
            }, 'slow');
        }
    };

    return this.init(options);
};
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

var sections = {
    home: {
        isDefault: true,
        menu: true,
        show: true,
        top: 0
    },
    projects: {
        isDefault: false,
        menu: false,
        show: false,
        top: 0
    },
    about: {
        isDefault: false,
        menu: true,
        show: true,
        top: 0
    },
    usmc: {
        isDefault: false,
        menu: false,
        show: false,
        top: 0
    },
    mu: {
        isDefault: false,
        menu: false,
        show: false,
        top: 0
    },
    contact: {
        isDefault: false,
        menu: true,
        show: true,
        top: 0
    }
};
var elements = {
    blobAbout: '#about .blob',
    blobContact: '#contact .blob',
    blobHome: '#home .blob',

    divFooter: '#contact #footer',
    divLinks: '#links',
    divLoading: '#loading',
    divMe: '#about #me',

    navMenu: '#menu'
};
var initLoad = true;

var viewerHeight;
var viewerWidth;
// executes when all of the images are loaded
$(window).on('load', function () {
    setTimeout(function() {
        loadPage();
    }, 10);
});

// executes when the window gets resized
$(window).resize(function () {
    getDimensions();
    setDimensions();
    setTops();
});

function getDimensions () {
    viewerHeight = $(window).height() - (elements.navMenu.height() + 11);
    viewerWidth = $(window).width() - 25;
}
function setDimensions () {
    $.each(sections, function(el, vars) {
        if (vars.show) {
            $('#' + el).css({'min-height': viewerHeight + 'px'});
        }
    });

    elementsInfo = {
        blobAbout: {
            'width': {start: (viewerWidth - 300 - (viewerWidth * .1)) + 'px'},
            'margin-left': {start: (viewerWidth * .05) + 150 + 'px'}
        },
        blobContact: {
            'width': {start: (viewerWidth * .66)}
        },
        blobHome: {
            'margin-left': {init: -350, start: (viewerWidth * .15), mid: (viewerWidth * .15), end: -350},
            'top': {start: ((viewerHeight - elements.blobHome.height()) / 2) + 'px'}
        },
        divMe: {
            'margin-left': {start: (viewerWidth * .05) + 'px'}
        }
    };

    $.each(elementsInfo, function(el, vars) {
        var newCss = {};
        $.each(vars, function(css, vars) {
            newCss[css] = (initLoad && typeof vars.init !== "undefined") ? vars.init : vars.start;
        });
        elements[el].css(newCss);
    });

    if (initLoad) { initLoad = false; }
}

function setTops () {
    var tops = 0;
    $.each(sections, function(el, vars) {
        if (vars.show) {
            sections[el].top = tops;
            tops += $('#' + el).height();
        }
    });
}

function loadPage() {
    $(window).scrollTop(0);
    document.body.scrollTop = document.documentElement.scrollTop = 0;

    $.each(elements, function(el, selector) {
        elements[el] = $(selector);
    });

    sectionsArr = [];
    $.each(sections, function(el, vars) {
        sectionsArr.push(el);
    });

    getDimensions();
    setDimensions();

    $.each(sections, function(el, vars) {
        if (vars.show) {
            $('#' + el).removeClass('hide');
        }
    });

    setTops();

    var topMenu = TopMenu({});
    var sectionsLogic = Sections({});

    elements.navMenu.css({'margin-top': '-51px'});
    elements.divLoading.delay(500).fadeOut(500);
    elements.blobHome.removeClass('hide');
    elements.blobHome.delay(1500).next_css({'margin-left': (viewerWidth * .15)});
}
