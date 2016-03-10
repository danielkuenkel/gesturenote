/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentPhaseStepCount = 0;

function onInfoClick(whichInfo) {
    var modalBodyText;
    switch (whichInfo) {
        case "description":
            modalBodyText = "test test test";
            break;
        default:
            modalBodyText = "default text";
            break;
    }
    
    // only for testing
    modalBodyText = whichInfo;

    document.getElementById("modal-body").innerHTML = modalBodyText;
}