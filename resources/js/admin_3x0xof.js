require('./bootstrap');

import bsCustomFileInput from "bs-custom-file-input";
// window.feather = require('feather-icons');
require('bootstrap-confirmation2');
require('./sidebar');

$(document).ready(function () {
    $('.clickable-row').click(function () {
        window.location = $(this).data("href");
    });

    bsCustomFileInput.init();

    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 500, "hide": 100}
    });

    // feather.replace();

    $(document).keydown(function (e) {
        let focused = document.activeElement;
        if (focused.tagName.toLowerCase() === 'input')
            return;

        switch (e.key) {
            case 'Left':
            case 'ArrowLeft':
                let previous = $('#previous');
                if (previous)
                    previous.click();
                break;
            case 'Right':
            case 'ArrowRight':
                let next = $('#next');
                if (next)
                    next.click();
                break;
            default :
                return;
        }
        e.preventDefault();
    });

    $("#sortable").sortable({
        delay: 100,
        axis: 'y',
        scroll: true,
        update: function (event, ui) {
            axios.post($(this).data('route'), {
                _method: 'patch',
                id: ui.item.attr('data-id'),
                index: ui.item.index() + 1,
            });
        },
        helper: function (e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        }
    });
});
