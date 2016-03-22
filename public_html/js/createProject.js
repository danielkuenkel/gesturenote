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
    createOriginSUS();
    renderSessionStorageData();
}

function createOriginGUS() {
    if (sessionStorage.getItem('project.originGUS') === null)
    {
        var gus = new Array();
        gus.push(new UsabilityScaleItem("Ich denke, dass ich mir diese Geste sehr gut merken kann.", 5, false));
        gus.push(new UsabilityScaleItem("Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dieser Geste umzugehen.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass sich diese Geste von anderen Gesten ausreichend unterscheidet.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass sich die Geste von alltäglichen Bewegungen ausreichend unterscheidet.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste zur Funktion passt.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste zu lang ist.", 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste zu komplex ist.", 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste prägnant ist.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste bequem ist.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Bewegung der Geste komisch ist.", 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste ermüdend ist.", 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass mich die Geste körperlich zu sehr fordert.", 5, true));
        gus.push(new UsabilityScaleItem("Ich würde diese Geste gerne regelmäßig nutzen.", 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste andere Personen im Umfeld nicht beeinträchtigt oder stört.", 5, true));
        gus.push(new UsabilityScaleItem("Die Geste ist peinlich.", 5, true));
        gus.push(new UsabilityScaleItem("Ich fühle mich beim Ausführen der Geste wohl.", 5, false));
        sessionStorage.setItem('project.originGUS', JSON.stringify(gus));
    }
}

function createOriginSUS() {
    if (sessionStorage.getItem('project.originSUS') === null)
    {
        var sus = new Array();
        sus.push(new UsabilityScaleItem("Ich denke, dass ich dieses System gerne regelmäßig nutzen würde.", 5, false));
        sus.push(new UsabilityScaleItem("Ich fand das System unnötig komplex.", 5, true));
        sus.push(new UsabilityScaleItem("Ich denke, das System war leicht zu benutzen.", 5, false));
        sus.push(new UsabilityScaleItem("Ich denke, ich würde die  Unterstützung einer fachkundigen Person benötigen, um das System benutzen zu können.", 5, true));
        sus.push(new UsabilityScaleItem("Ich fand, die verschiedenen Funktionen des Systems waren gut integriert.", 5, false));
        sus.push(new UsabilityScaleItem("Ich halte das System für zu inkonsistent.", 5, true));
        sus.push(new UsabilityScaleItem("Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dem System umzugehen.", 5, false));
        sus.push(new UsabilityScaleItem("Ich fand das System sehr umständlich zu benutzen.", 5, true));
        sus.push(new UsabilityScaleItem("Ich fühlte mich bei der Nutzung des Systems sehr sicher.", 5, false));
        sus.push(new UsabilityScaleItem("Ich musste viele Dinge lernen, bevor ich  mit dem System arbeiten konnte.", 5, true));
        sessionStorage.setItem('project.originSUS', JSON.stringify(sus));
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

function UsabilityScaleItem(itemText, likertScale, reversed) {
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

function QuestionnaireItem(id, question, parameters, options) {
    this.id = id;
    this.question = question;
    this.parameters = parameters;
    this.options = options;
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