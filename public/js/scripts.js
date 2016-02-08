$.fn.extend({
    next_css: function(css) {
        return $(this).queue(function(next) {
            $(this).css(css);
            next();
        });
    }
});
var TopMenu = function () {
    this.init = function () {
        this.buildMenu();
        this.watchScrolling();
        this.bindMenu();
    };

    this.buildMenu = function () {
        var lastIdx = 0;
        $.each(sections, function (idx, section) {
            if (section != '') {
                var sectionInfo = sectionsInfo[section];
                var newItem = $('<span>').attr({'id': section, 'class': (sectionInfo.isDefault) ? 'link active' : 'link inactive'}).html(section);
                elements.divLinks.append(newItem);
                lastIdx = idx;
            }
            sectionIndexes.push(lastIdx);
        });
    };

    this.watchScrolling = function () {
        $(window).scroll(function () {
            var scrollTop = $(window).scrollTop();
            var currLoc = Math.floor(scrollTop / (viewerHeight * .60));
            if (currLoc != currIdx && currLoc < sectionIndexes.length) {
                $('#' + sections[sectionIndexes[currIdx]]).removeClass('active').addClass('inactive');
                $('#' + sections[sectionIndexes[currLoc]]).removeClass('inactive').addClass('active');
                currIdx = currLoc;
            }
        });
    };

    this.bindMenu = function () {
        $('.link').on('click', this.scrollToSection);
    };

    this.scrollToSection = function (event) {
        var targetEl = $(event.target);

        if (targetEl.hasClass('inactive')) {
            var el = $('#' + targetEl.attr('id').toLowerCase());

            $('html, body').animate({
                scrollTop: el.offset().top - (elements.navMenu.height() + 12)
            }, 'slow');
        }
    };

    return this.init();
};
var sections = ['Home', 'About'];
var sectionsInfo = {
    Home: [true, false, []],
    About: [false, true, []],
    Contact: [false, false, []]
};
var elements = {
    blobAbout: '#about .blob',
    blobHome: '#home .blob',

    divLinks: '#links',
    divLoading: '#loading',
    divMe: '#about #me',

    navMenu: '#menu',

    sectionHome: '#home'
};
var elementsInfo = {};

var viewerHeight;
var viewerWidth;

var currIdx = 0;
var sectionIndexes = [];

var gotoSection = 'about';
var gotoTime = 0;

// executes when the DOM is loaded
$(function () {
    $.each(elements, function(el, selector) {
        elements[el] = $(selector);
    });

    makeObjects();

    var topMenu = TopMenu();

    //$('#loading').hide();
});

// executes when all of the images are loaded
$(window).on('load', function () {
    getDimensions();
    setDimensions();

    loadPage();
    //if (gotoSection != '') {
    //    setTimeout(function() {
    //        $('html, body').animate({
    //            scrollTop: $('#' + gotoSection).offset().top - (elements.navMenu.height() + 12)
    //        }, (1000 * gotoTime));
    //    }, 2000);
    //}
});

// executes when the window gets resized
$(window).resize(function () {
    getDimensions();
    setDimensions();
});

function getDimensions () {
    viewerHeight = $(window).height() - (elements.navMenu.height() + 11);
    viewerWidth = $(window).width() - 25;
}
function setDimensions () {
    $.each($('section'), function(idx, el) {
        $(el).css({'min-height': viewerHeight + 'px'});
    });

    elementsInfo = {
        blobHome: {
            'margin-left': {start: -350, mid: (viewerWidth * .15), end: -350},
            'top': {start: ((viewerHeight - elements.blobHome.height()) / 2) + 'px'}
        },
        blobAbout: {
            'width': {start: (viewerWidth - 300 - (viewerWidth * .1)) + 'px'},
            'margin-left': {start: (viewerWidth * .05) + 150 + 'px'}
            //'max-height': {start: (viewerHeight - 149) + 'px'}
        },
        divMe: {
            'margin-left': {start: (viewerWidth * .05) + 'px'}
        }
    };


    $.each(elementsInfo, function(el, vars) {
        var newCss = {};
        $.each(vars, function(css, vars) {
            newCss[css] = vars.start;
        });
        elements[el].css(newCss);
    });
}

function makeObjects () {
    $.each(sectionsInfo, function(val, arr) {
        sectionsInfo[val] = {
            isDefault: arr[0],
            isParent: arr[1],
            children: arr[3]
        };
    });
}

function loadPage() {
    setTimeout(function() {
        $(window).scrollTop(0);
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    }, 10);
    elements.navMenu.css({'margin-top': '-51px'});
    elements.divLoading.delay(500).fadeOut(500);
    elements.blobHome.delay(1500).next_css({'margin-left': (viewerWidth * .15)});
}

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