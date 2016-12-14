(function ($) {
    $.toggleShowPassword = function (options) {
        var settings = $.extend({
            field: "#password",
            control: "#toggle_show_password",
        }, options);

        var control = $(settings.control);
        var field = $(settings.field)

        control.bind('click', function () {
            nextIcon = control.next().children('i');
            if (control.is(':checked')) {
                nextIcon.removeClass('fa-eye');
                nextIcon.addClass('fa-eye-slash');
                field.attr('type', 'text');
            } else {
                nextIcon.removeClass('fa-eye-slash');
                nextIcon.addClass('fa-eye');
                field.attr('type', 'password');
            }
        })
    };
}(jQuery));
