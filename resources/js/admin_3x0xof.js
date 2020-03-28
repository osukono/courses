require('./bootstrap');

import bsCustomFileInput from "bs-custom-file-input";
window.feather = require('feather-icons');
require('bootstrap-confirmation2');
require('./sidebar');

$(document).ready(function () {
    bsCustomFileInput.init();

    $(`.clickable-row`).click(function (e) {
        window.location = $(this).data("href");
    });

    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 500, "hide": 100}
    });

    feather.replace();
});
