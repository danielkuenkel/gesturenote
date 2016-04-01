/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentPhaseStepCount = 0;
var currentIdForModal;
var colors;
var currentContainerList = null;

function setLocalItem(id, data) {
    sessionStorage.setItem(id, JSON.stringify(data));
}

function getLocalItem(id) {
    if (sessionStorage.getItem(id) !== null) {
        return JSON.parse(sessionStorage.getItem(id));
    } else {
        return null;
    }
}

function removeLocalItem(id) {
    sessionStorage.removeItem(id);
}

function clearLocalItems() {
    sessionStorage.clear();
}

function checkSessionStorage() {
    createOriginGUS();
    createOriginSUS();
    createPredefinedGestures();
    createPredefinedObservationForm();
    renderSessionStorageData();
}

function createOriginGUS() {
    if (getLocalItem(PROJECT_ORIGIN_GUS) === null)
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
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste andere Personen im Umfeld beeinträchtigt oder stört.", 5, true));
        gus.push(new UsabilityScaleItem("Die Geste ist peinlich.", 5, true));
        gus.push(new UsabilityScaleItem("Ich fühle mich beim Ausführen der Geste wohl.", 5, false));
        setLocalItem(PROJECT_ORIGIN_GUS, gus);
    }
}

function createOriginSUS() {
    if (getLocalItem(PROJECT_ORIGIN_SUS) === null)
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
        setLocalItem(PROJECT_ORIGIN_SUS, sus);
    }
}

function createPredefinedGestures() {
    if (getLocalItem(PREDEFINED_GESTURE_SET) === null) {
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

        setLocalItem(PREDEFINED_GESTURE_SET, gestures);
    }
}

function createPredefinedObservationForm() {
    if (getLocalItem(PREDEFINED_OBSERVATIONS) === null) {
        var form = new Array();
        form.push(new QuestionnaireItem('counter', 'Wie oft wurde die Geste falsch ausgeführt?', null, null));
        form.push(new QuestionnaireItem('openQuestion', 'Was wurde sonst beobachtet?', null, null));
        form.push(new QuestionnaireItem('dichotomousQuestion', 'Wurde die Hilfe genutzt?', [false, false], null));
        form.push(new QuestionnaireItem('groupingQuestion', 'Wurde Hilfe benötigt?', [false, false], ['ja', 'nein', 'ein wenig']));
        setLocalItem(PREDEFINED_OBSERVATIONS, form);
    }
}

function getGestureThumbnailImagesForId(type, id) {
    var data = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < data.length; i++) {
        if (type === data[i].type && id === data[i].id) {
            return data[i].images;
        }
    }
}

function getGestureThumbnailPreviewForId(type, id) {
    var data = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < data.length; i++) {
        if (type === data[i].type && id === data[i].id) {
            return data[i].previewImage;
        }
    }
}

function assembledGestures() {
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
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
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id)) {
            return predefinedGestures[i];
        }
    }
    return null;
}

function isGestureAssembled(id) {
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id) && predefinedGestures[i].used === true) {
            return true;
        }
    }
    return false;
}

function removeAssembledGestures() {
    console.log("remove assembled gestures");
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            var data = getLocalItem(phaseSteps[i].id + ".data");
            if (data && (phaseSteps[i].selectedId === 'scenario' || phaseSteps[i].selectedId === 'gestureTraining')) {
                var scenario = new Scenario();
                scenario.title = data.title;
                scenario.description = data.description;
                scenario.help = data.help;
                scenario.observations = data.observations;
                setLocalItem(phaseSteps[i].id + ".data", scenario);
            }
        }
    }
    removeLocalItem(PREDEFINED_GESTURE_SET);
    createPredefinedGestures();
}

function renderSessionStorageData() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps)
    {
        for (var i = 0; i < phaseSteps.length; i++) {
            var item = phaseSteps[i];
            addPhaseStep(item.id, item.selectedId, item.itemText, item.color);
            var id = parseInt(item.id.charAt(item.id.length - 1));
            if (currentPhaseStepCount <= id) {
                currentPhaseStepCount = id + 1;
            }
        }
    }

    var project = getLocalItem('project');
    if (project) {
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
    setLocalItem('project', project);
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











//function onCloseClick() {
//    saveData();
//    currentIdForModal = null;
//}
//
//$('body').on('click','#addFormat', function (event) {
//    event.preventDefault();
//
//    var brotherID = $(this).parent().prevAll(".select:first").attr('id');
//    var selectedID = $('#' + brotherID + ' .selected').attr('id');
//
//    if (selectedID !== 'unselected') {
//        var clone = $('#form-item-container').find('#' + selectedID).clone(true);
//        $('#list-container').append(clone);
//        checkCurrentListState($('#list-container'));
//    }
//    updateBadges($('#list-container'), selectedID);
//});
//
//$('.btn-add-groupingQuestionOption').unbind('click').bind('click', function (event) {
//    event.preventDefault();
//    var clone = $('#groupingQuestionItem').clone().removeClass('hidden');
//    $(this).prev().find('.panel-body').append(clone);
//    checkCurrentListState($(this).prev().find('.panel-body'));
//});
//
//$('.btn-add-ratingOption').unbind('click').bind('click', function (event) {
//    event.preventDefault();
//    var clone = $('#ratingItem').clone().removeClass('hidden');
//    clone.removeAttr('id');
//    $(this).prev().find('.panel-body').append(clone);
//    checkCurrentListState($(this).prev().find('.panel-body'));
//    renderScaleItems($(clone).find('.ratingScaleItemContainer'), 3);
//    return false;
//});
//
//$('.btn-add-sumQuestionOption').unbind('click').bind('click', function (event) {
//    event.preventDefault();
//    var clone = $('#sumQuestionItem').clone().removeClass('hidden');
//    $(this).prev().find('.panel-body').append(clone);
//    checkCurrentListState($(this).prev().find('.panel-body'));
//});
//
//$('.btn-add-rankingOption').unbind('click').bind('click', function (event) {
//    event.preventDefault();
//    var clone = $('#rankingItem').clone().removeClass('hidden');
//    $(this).prev().find('.panel-body').append(clone);
//    checkCurrentListState($(this).prev().find('.panel-body'));
//});
//
//$('body').on('click', '.select .option li', function () {
//    var parent = $(this).closest('.select');
//    if ($(parent).hasClass('scaleSelect')) {
//        var scaleItemContainer = $(this).parents('.root').first().find('.ratingScaleItemContainer');
//        var scaleSelectCount = $(this).children().text().trim();
//        renderScaleItems(scaleItemContainer, scaleSelectCount, undefined);
//    }
//});
//
//function renderScaleItems(container, count, text)
//{
//    $(container).empty();
//    for (var i = 0; i < count; i++)
//    {
//        var scaleItem = $('#ratingScaleItem').clone();
//        scaleItem.removeClass('hidden');
//        $(container).append(scaleItem);
//
//        if (i === 0) {
//            $(scaleItem).find('.input-group-addon').text("von " + (i + 1));
//            $(scaleItem).find('.item-input-text').attr('placeholder', 'z.B. trifft zu');
//        } else if (i === count - 1) {
//            $(scaleItem).find('.input-group-addon').text("bis " + (i + 1));
//            $(scaleItem).find('.item-input-text').attr('placeholder', 'z.B. trifft nicht zu');
//        } else {
//            $(scaleItem).find('.input-group-addon').text(i + 1);
//        }
//        if (text !== undefined) {
//            $(scaleItem).find('.item-input-text').val(text[i]);
//        }
//    }
//}
//$(document).ready(function () {
//    function updateBadges(container, formatId) {
//        if (formatId === null) {
//            console.log('update all badges');
//        } else {
//            var children = container.children('#' + formatId);
//            for (var i = 0; i < children.length; i++) {
//                $(children[i]).find('.badgeId').text(i + 1);
//                $(children[i]).find('.badgeQuantity').text(children.length);
//            }
//        }
//    }
//});
//
//
//$('body').on('click', '.btn-up', function () {
//    updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
//});
//
//$('body').on('click', '.btn-down', function () {
//    updateBadges($(this).closest('.container-root'), $(this).closest('.root').attr('id'));
//});
//
//$('body').on('click', '.btn-delete', function () {
//    updateBadges(currentContainerList, $(this).closest('.root').attr('id'));
//});
//
//$('.checkAssembledGestures').on('click', function (event) {
//    console.log('checkAssembledGestures');
//    var aGestures = assembledGestures();
//    if (!aGestures || aGestures.length === 0) {
//        if ($(this).attr('id') === 'success') {
//            $(this).prevAll('.switchButtonAddon').first().click();
//            $(this).closest('.panel-body').find('#no-gestures-assembled').removeClass('hidden');
//        } else if ($(this).hasClass('switchButtonAddon')) {
//            var activeButton = $(this).nextAll().filter('.active');
//            var inactiveButton = $(this).nextAll().filter('.inactive');
//            $(this).closest('.panel-body').find('#no-gestures-assembled').removeClass('hidden');
//            toggleSwitch(activeButton, inactiveButton);
//        }
//    }
//});