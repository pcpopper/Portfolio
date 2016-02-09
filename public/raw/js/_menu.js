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