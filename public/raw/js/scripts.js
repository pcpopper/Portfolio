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
