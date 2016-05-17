/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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