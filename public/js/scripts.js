var TopMenu = function () {
    this.init = function () {
        this.buildMenu();
    };

    this.buildMenu = function () {
        $.each(sections, function (id, section) {
            var newItem = $('<span>').attr({'id': section, 'class': (id == 0) ? 'active' : 'inactive'}).html(section);
            console.dir(newItem);
            elements.divLinks.append(newItem);
        });
    };

    return this.init();
};
var sections = ['Home'];//, 'About', 'Contact'];
var elements = {
    blobHome: '#home .blob',

    divLinks: '#links',
    divLoading: '#loading',

    navMenu: '#menu',

    sectionHome: '#home'
};
var viewerHeight;
var viewerWidth;

$.fn.extend({
    next_css: function(css) {
        return $(this).queue(function(next) {
            $(this).css(css);
            next();
        });
    }
});

// executes when the DOM is loaded
$(function () {
    $.each(elements, function(el, selector) {
        elements[el] = $(selector);
    });

    getDimensions();
    setDimensions();

    var topMenu = TopMenu();
});

// executes when all of the images are loaded
$(window).on('load', function () {
    //loadPage();
    window.setTimeout(loadPage, 1000);
});

// executes when the window gets resized
$(window).resize(function () {
    getDimensions();
    setDimensions();
});

function getDimensions () {
    viewerHeight = $(window).height() - elements.navMenu.height();
    viewerWidth = $(window).width();
}

function setDimensions () {
    elements.sectionHome.css({'height': viewerHeight + 'px'});
    elements.blobHome.css({'left': '0px'});
}

function loadPage() {
    elements.navMenu.css({'margin-top': '-51px'});
    elements.divLoading.delay(500).fadeOut(500);
    elements.blobHome.delay(1500).next_css({'margin-left': '0', 'left': '15%'});
}