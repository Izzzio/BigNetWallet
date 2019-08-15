if(!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
    };
}

if (!Date.now) {
    Date.now = function() { return new Date().getTime(); }
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

    var popOverSettings = {
        container: 'body',
        selector: '[data-toggle="popover"]',
        trigger: 'hover',
        template: '<div class="popover"><div class="popover-content popover-custom"></div><div class="arrow"></div></div>'
    };
    let body = $('body');
    body.popover(popOverSettings);

    body.on('inserted.bs.popover', '.mini', function(){
        body.find('.popover').addClass('popover-mini');
    });
});