require('./bootstrap');

import bsCustomFileInput from "bs-custom-file-input";
window.feather = require('feather-icons');
require('bootstrap-confirmation2');
require('./sidebar');

$(function () {
    bsCustomFileInput.init();

    $(`.clickable-row`).click(function (e) {
        window.location = $(this).data("href");
    });

    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 500, "hide": 100}
    });

    feather.replace();

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
});
