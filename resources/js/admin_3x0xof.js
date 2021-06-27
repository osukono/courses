require('./bootstrap');

import bsCustomFileInput from "bs-custom-file-input";
window.feather = require('feather-icons');
require('bootstrap-confirmation2');
require('./sidebar');
import {Howl, Howler} from 'howler';
window.FroalaEditor = require('froala-editor')
require('froala-editor/js/plugins/align.min')
require('froala-editor/js/plugins/table.min')
require('froala-editor/js/plugins/emoticons.min')
require('froala-editor/js/plugins/colors.min')

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
                id: ui.item.attr('data-sortable'),
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

    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle^=confirmation]',
        singleton: true,
        popout: true,
        btnOkClass: 'btn btn-info btn-sm',
        btnCancelLabel: 'Cancel',
        btnCancelClass: 'btn btn-outline-info btn-sm',
        onConfirm: function () {
            let form = $(this)[0].getAttribute('data-form');
            document.getElementById(form).submit();
        }
    });
});
