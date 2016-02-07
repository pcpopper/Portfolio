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