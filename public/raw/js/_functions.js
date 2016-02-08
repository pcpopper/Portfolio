$.fn.extend({
    next_css: function(css) {
        return $(this).queue(function(next) {
            $(this).css(css);
            next();
        });
    }
});