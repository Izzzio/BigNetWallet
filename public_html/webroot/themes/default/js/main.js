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

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "8000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});