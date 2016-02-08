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