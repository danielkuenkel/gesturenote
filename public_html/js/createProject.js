/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentPhaseStepCount = 0;
var currentIdForModal;
var colors;
function checkSessionStorage() {
    createOriginGUS();
    renderSessionStorageData();
}

function createOriginGUS() {
    if (sessionStorage.getItem('project.originGUS') === null)
    {
        var gus = new Array();
        gus.push(new GUSItem("Ich denke, dass ich mir diese Geste sehr gut merken kann.", 5, false));
        gus.push(new GUSItem("Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dieser Geste umzugehen.", 5, false));
        gus.push(new GUSItem("Ich denke, dass sich diese Geste von anderen Gesten ausreichend unterscheidet.", 5, true));
        sessionStorage.setItem('project.originGUS', JSON.stringify(gus));
    }
}

function renderSessionStorageData() {
//    console.log(sessionStorage);
    var phaseSteps = sessionStorage.getItem('project.phaseSteps');
    if (phaseSteps !== null)
    {
        phaseSteps = JSON.parse(phaseSteps);
        for (var i = 0; i < phaseSteps.length; i++) {
            var item = phaseSteps[i];
            addPhaseStep(item.id, item.selectedId, item.itemText, item.color);
            var id = parseInt(item.id.charAt(item.id.length - 1));
            if (currentPhaseStepCount <= id) {
                currentPhaseStepCount = id + 1;
            }
        }
    }

    var project = sessionStorage.getItem('project');
    if (project !== null) {
        project = JSON.parse(project);
        $('#projectName').val(project.name);
        $('#projectDescription').val(project.description);
        if (project.phase !== 'unselected') {
            $('#phaseSelect .selected').attr('id', project.phase);
            $('#phaseSelect .selected').text($('#phaseSelect #' + project.phase + ' a').text());
        }
        if (project.surveyType !== 'unselected') {
            $('#surveyTypeSelect .selected').attr('id', project.surveyType);
            $('#surveyTypeSelect .selected').text($('#surveyTypeSelect #' + project.surveyType + ' a').text());
        }
        if (project.pidocoURL !== null)
        {
            $('#pidocoURLCheckbox').prop('checked', true);
            $('#pidocoURLInput').addClass('in');
            $('#pidocoURL').val(project.pidocoURL);
        }
    }
}


function saveGeneralData() {
    var project = new Project();
    project.name = $('#projectName').val();
    project.description = $('#projectDescription').val();
    project.phase = $('#phaseSelect .selected').attr('id');
    project.surveyType = $('#surveyTypeSelect .selected').attr('id');

    if ($('#pidocoURLInput').hasClass('in') && $('#pidocoURL').val().trim() !== "") {
        project.pidocoURL = $('#pidocoURL').val();
    } else
    {
        project.pidocoURL = null;
    }

    sessionStorage.setItem('project', JSON.stringify(project));
}

function Project() {
    this.name;
    this.description;
    this.phase;
    this.surveyType;
    this.pidocoURL;
}

function GUSItem(itemText, likertScale, reversed) {
    this.itemText = itemText;
    this.likertScale = likertScale;
    this.reversed = reversed;
}

function PhaseItem(id, selectedId, itemText, color) {
    this.id = id;
    this.selectedId = selectedId;
    this.itemText = itemText;
    this.color = color;
}

function createRandomColors() {
    colors = randomColor({hue: 'green', count: 25});
}

function clearSessionStorage() {
    sessionStorage.clear();
}

function deleteSessionDataById(id) {
    console.log("delete data for id: " + id);
    sessionStorage.removeItem(id);
}