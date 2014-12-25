(function($) {
    $.id_generator = function(options) {
        if (this.index == undefined) {
            this.index = 0;
        }
        return "id-" + this.index++;
    };
})(jQuery);
