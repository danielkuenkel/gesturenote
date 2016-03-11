/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentPhaseStepCount = 0;

function createSessionStorage() {
    createGUS();
}

function createGUS() {
    var gus = new Array();
    gus.push(new GUSItem("Ich denke, dass ich mir diese Geste sehr gut merken kann.", 5, false));
    gus.push(new GUSItem("Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dieser Geste umzugehen.", 5, false));
    gus.push(new GUSItem("Ich denke, dass sich diese Geste von anderen Gesten ausreichend unterscheidet.", 5, true));
    sessionStorage.setItem('gus', JSON.stringify(gus));
}


function GUSItem(itemText, likertScale, reversed) {
    this.itemText = itemText;
    this.likertScale = likertScale;
    this.reversed = reversed;
}