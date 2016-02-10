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