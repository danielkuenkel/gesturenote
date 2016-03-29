/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentPhaseStepCount = 0;
var currentIdForModal;
var colors;
var currentContainerList = null;

function checkSessionStorage() {
    createOriginGUS();
    createOriginSUS();
    createPredefinedGestures();
    createPredefinedObservationForm();
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

function createPredefinedGestures() {
    if (sessionStorage.getItem('predefinedGestureSet') === null) {
        var images = new Array();
        images.push("http://placehold.it/200x150?text=1");
        images.push("http://placehold.it/200x150?text=2");
        images.push("http://placehold.it/200x150?text=3");
        images.push("http://placehold.it/200x150?text=4");
        images.push("http://placehold.it/200x150?text=5");

        var gestures = new Array();
        gestures.push(new Gesture("ownProject", 1, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung fg fdg. asdfkaölsdfaj sdö fasd föasd faös kdalökds föla sdöklasdf lökasdf ladf ölk gjsögi bjsföi vjadölfiadöli gsöldfjva ödifgsdöli a öldgöald f völadföl gasö ldfgaödf öladf ölgaöldfglösfg sfg löad lf alödg ölsfg bjl", images, 2, null, false));
        gestures.push(new Gesture("ownProject", 2, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung hgdh d.", images, 1, null, false));
        gestures.push(new Gesture("ownProject", 3, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung hdhhsr.", images, 2, null, false));
        gestures.push(new Gesture("ownProject", 4, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung  wzhwsbf b.", images, 0, null, false));
        gestures.push(new Gesture("ownProject", 5, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung rhsfgnsgk s dgh sfg.", images, 2, null, false));
        gestures.push(new Gesture("gestureCatalog", 6, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Haha.", images, 1, null, false));
        gestures.push(new Gesture("gestureCatalog", 7, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung.", images, 2, null, false));
        gestures.push(new Gesture("gestureCatalog", 8, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung.", images, 2, null, false));
        gestures.push(new Gesture("gestureCatalog", 9, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist eine lange lange Beschreibung.", images, 0, null, false));

        sessionStorage.setItem('predefinedGestureSet', JSON.stringify(gestures));
    }
}

function createPredefinedObservationForm() {
    if (sessionStorage.getItem('predefinedObversation') === null) {
        var form = new Array();
        form.push(new QuestionnaireItem('counter', 'Wie oft wurde die Geste falsch ausgeführt?', null, null));
        form.push(new QuestionnaireItem('openQuestion', 'Was wurde sonst beobachtet?', null, null));
        form.push(new QuestionnaireItem('dichotomousQuestion', 'Wurde die Hilfe genutzt?', null, null));
        form.push(new QuestionnaireItem('groupingQuestion', 'Wurde Hilfe benötigt?', [false, false], ['ja', 'nein', 'ein wenig']));
        sessionStorage.setItem('predefinedObversation', JSON.stringify(form));
    }
}

function getGestureThumbnailImagesForId(type, id) {
    var data = JSON.parse(sessionStorage.getItem('predefinedGestureSet'));
    for (var i = 0; i < data.length; i++) {
        if (type === data[i].type && id === data[i].id) {
            return data[i].images;
        }
    }
}

function getGestureThumbnailPreviewForId(type, id) {
    var data = JSON.parse(sessionStorage.getItem('predefinedGestureSet'));
    for (var i = 0; i < data.length; i++) {
        if (type === data[i].type && id === data[i].id) {
            return data[i].previewImage;
        }
    }
}

function assembledGestures() {
    var predefinedGestures = JSON.parse(sessionStorage.getItem('predefinedGestureSet'));
    if (predefinedGestures) {
        var arrangedGestures = new Array();
        for (var i = 0; i < predefinedGestures.length; i++) {
            if (predefinedGestures[i].used === true) {
                arrangedGestures.push(predefinedGestures[i]);
            }
        }
        return arrangedGestures;
    }
    return null;
}

function getGestureById(id) {
    var predefinedGestures = JSON.parse(sessionStorage.getItem('predefinedGestureSet'));
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id)) {
            return predefinedGestures[i];
        }
    }
    return null;
}

function isGestureAssembled(id) {
    var predefinedGestures = JSON.parse(sessionStorage.getItem('predefinedGestureSet'));
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id) && predefinedGestures[i].used === true) {
            return true;
        }
    }
    return false;
}

function removeAssembledGestures() {
    console.log("remove assembled gestures");
    var phaseSteps = JSON.parse(sessionStorage.getItem('project.phaseSteps'));
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            if (phaseSteps[i].selectedId === 'scenario' || phaseSteps[i].selectedId === 'gestureTraining') {
                var data = JSON.parse(sessionStorage.getItem(phaseSteps[i].id + ".data"));
                var scenario = new Scenario();
                scenario.title = data.title;
                scenario.description = data.description;
                scenario.help = data.help;
                scenario.observations = data.observations;
                sessionStorage.setItem(phaseSteps[i].id + ".data", JSON.stringify(scenario));
            }
        }
    }
    sessionStorage.removeItem('predefinedGestureSet');
    createPredefinedGestures();
}

function renderSessionStorageData() {
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
            toggleSwitch($('#pidocoURLSwitch').find('.active'), $('#pidocoURLSwitch').find('.inactive'));
            $('#pidocoURLInput').removeClass('hidden');
            $('#pidocoURL').val(project.pidocoURL);
        }
        if (project.useGestures === true) {
            $('#useGesturesSwitch #assemble-gesture-set').removeClass('hidden');
            toggleSwitch($('#useGesturesSwitch #warning'), $('#useGesturesSwitch #success'));
        }
    }
}


function saveGeneralData() {
    var project = new Project();
    project.name = $('#projectName').val();
    project.description = $('#projectDescription').val();
    project.phase = $('#phaseSelect .selected').attr('id');
    project.surveyType = $('#surveyTypeSelect .selected').attr('id');

    if (!$('#pidocoURLInput').hasClass('hidden') && $('#pidocoURL').val().trim() !== "") {
        project.pidocoURL = $('#pidocoURL').val();
    } else
    {
        project.pidocoURL = null;
    }

    project.useGestures = !$('#useGesturesSwitch #assemble-gesture-set').hasClass('hidden');

    sessionStorage.setItem('project', JSON.stringify(project));
}

function Project() {
    this.name;
    this.description;
    this.phase;
    this.surveyType;
    this.pidocoURL;
    this.useGestures;
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

function Scenario() {
    this.title;
    this.description;
    this.woz;
    this.help;
    this.observations;
}

function Gesture(type, id, title, description, images, previewImage, videoUrl, used) {
    this.type = type;
    this.id = id;
    this.title = title;
    this.description = description;
    this.images = images;
    this.previewImage = previewImage;
    this.videoUrl = videoUrl;
    this.used = used;
}

function createRandomColors() {
    colors = randomColor({hue: 'green', count: 25});
}

function clearSessionStorage() {
    sessionStorage.clear();
}

function deleteSessionDataById(id) {
    sessionStorage.removeItem(id);
}

//function loadjscssfile(filename, filetype) {
//    if (filetype === "js") { //if filename is a external JavaScript file
//        var fileref = document.createElement('script');
//        fileref.setAttribute("type", "text/javascript");
//        fileref.setAttribute("src", filename);
//        console.log("load js: " + filename + ", type: " + filetype);
//    } else if (filetype === "css") { //if filename is an external CSS file
//        var fileref = document.createElement("link");
//        fileref.setAttribute("rel", "stylesheet");
//        fileref.setAttribute("type", "text/css");
//        fileref.setAttribute("href", filename);
//    }
//    if (typeof fileref !== "undefined")
//        document.getElementsByTagName("head")[0].appendChild(fileref);
//}
//
//function removejscssfile(filename, filetype) {
//    console.log("unload: " + filename + ", type: " + filetype);
//    var targetelement = (filetype === "js") ? "script" : (filetype === "css") ? "link" : "none"; //determine element type to create nodelist from
//    var targetattr = (filetype === "js") ? "src" : (filetype === "css") ? "href" : "none"; //determine corresponding attribute to test for
//    var allsuspects = document.getElementsByTagName(targetelement);
//    for (var i = allsuspects.length; i >= 0; i--) { //search backwards within nodelist for matching elements to remove
//        if (allsuspects[i] &&
//                allsuspects[i].getAttribute(targetattr) !== null &&
//                allsuspects[i].getAttribute(targetattr).indexOf(filename) !== -1)
//        {
//            allsuspects[i].parentNode.removeChild(allsuspects[i]); //remove element by calling parentNode.removeChild() 
//        }
//
//    }
//}