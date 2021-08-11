require('./bootstrap');

import bsCustomFileInput from "bs-custom-file-input";
window.feather = require('feather-icons');
require('./sidebar');
import {Howl, Howler} from 'howler';

window.FroalaEditor = require('froala-editor')
require('froala-editor/js/plugins/align.min')
require('froala-editor/js/plugins/table.min')
require('froala-editor/js/plugins/colors.min')
require('froala-editor/js/plugins/lists.min')
require('froala-editor/js/plugins/code_view.min')

$(document).ready(function () {
    $('.clickable-row').click(function () {
        window.location = $(this).data("href");
    });

    bsCustomFileInput.init();

    $('[data-bs-toggle="tooltip"]').tooltip({
        delay: {"show": 500, "hide": 100}
    });

    $('a').filter(function () {
       return this.innerHTML.match('/Unlicensed*/');
    }).hide();

    $("a[innerHTML='Unlicensed']").hide();

    // feather.replace();

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
});
