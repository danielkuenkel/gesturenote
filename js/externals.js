/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var PATH_EXTERNALS = 'externals/';
function loadExternals(externals) {
    var externalsLoaded = 0;

    for (var i = 0; i < externals.length; i++) {
        $(externals[i][0]).load(externals[i][1], function (responseTxt, statusTxt, xhr) {
            if (statusTxt === 'success') {
                checkAllExternalsLoaded();
            } else if (statusTxt === 'error') {
                console.log('error loading external content');
            }
        });
    }

    function checkAllExternalsLoaded() {
        externalsLoaded++;
        if (externalsLoaded >= externals.length) {
            onAllExternalsLoadedSuccessfully();
        }
    }
}

function loadHTMLintoModal(modalId, url, modalSize) {
    $.get(url, modalId, function (data) {
        $('#' + modalId).find('.modal-content').html(data);
    });
    $('#' + modalId).modal('show');
    $('#' + modalId).find('.modal-dialog').addClass(modalSize);
    $('#' + modalId).on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal');
        $(this).find('.modal-dialog').removeClass(modalSize);
    });
}