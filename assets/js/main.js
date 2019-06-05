if(!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
    };
}

$(function () {
    'use strict';

    $('#create').on('click', function () {
        $('.wallet').hide();
        $('.file').show();
    });

    $('#continue').on('click', function () {
        $('.file').hide();
        $('.key').show();
    });

    $('[data-toggle="popover"]').popover();
});