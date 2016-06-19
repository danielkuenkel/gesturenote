/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentIdForModal;
var colors;
var currentContainerList = null;

function checkSessionStorage() {
    createOriginGUS();
    createOriginSUS();
    createPredefinedGestures();
    createPredefinedObservationForm();
    createPredefinedGestureQuestionnaire();
    createPredefinedGestureFeedback();
    renderSessionStorageData();
}

function createOriginGUS() {
    if (getLocalItem(PROJECT_ORIGIN_GUS) === null) {
        var gus = new Array();
        gus.push(new UsabilityScaleItem("Ich denke, dass ich mir diese Geste sehr gut merken kann.", DIMENSION_LERNABILITY, 5, false));
        gus.push(new UsabilityScaleItem("Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dieser Geste umzugehen.", DIMENSION_LERNABILITY, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass sich diese Geste von anderen Gesten ausreichend unterscheidet.", DIMENSION_MENTAL_MODEL, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass sich die Geste von alltäglichen Bewegungen ausreichend unterscheidet.", DIMENSION_FEASIBILITY, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste zur Funktion passt.", DIMENSION_MENTAL_MODEL, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste zu lang ist.", DIMENSION_ERGONOMICS, 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste zu komplex ist.", DIMENSION_ERGONOMICS, 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste prägnant ist.", DIMENSION_ERGONOMICS, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste bequem ist.", DIMENSION_ERGONOMICS, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Bewegung der Geste komisch ist.", DIMENSION_ERGONOMICS, 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste ermüdend ist.", DIMENSION_ERGONOMICS, 5, true));
        gus.push(new UsabilityScaleItem("Ich denke, dass mich die Geste körperlich zu sehr fordert.", DIMENSION_ERGONOMICS, 5, true));
        gus.push(new UsabilityScaleItem("Ich würde diese Geste gerne regelmäßig nutzen.", DIMENSION_ACCEPTABILITY, 5, false));
        gus.push(new UsabilityScaleItem("Ich denke, dass die Geste andere Personen im Umfeld beeinträchtigt oder stört.", DIMENSION_ACCEPTABILITY, 5, true));
        gus.push(new UsabilityScaleItem("Die Geste ist peinlich.", DIMENSION_ACCEPTABILITY, 5, true));
        gus.push(new UsabilityScaleItem("Ich fühle mich beim Ausführen der Geste wohl.", DIMENSION_ACCEPTABILITY, 5, false));
        setLocalItem(PROJECT_ORIGIN_GUS, gus);
    }
}

function createOriginSUS() {
    if (getLocalItem(PROJECT_ORIGIN_SUS) === null) {
        var sus = new Array();
        sus.push(new UsabilityScaleItem("Ich denke, dass ich dieses System gerne regelmäßig nutzen würde.", DIMENSION_ANY, 5, false));
        sus.push(new UsabilityScaleItem("Ich fand das System unnötig komplex.", DIMENSION_ANY, 5, true));
        sus.push(new UsabilityScaleItem("Ich denke, das System war leicht zu benutzen.", DIMENSION_ANY, 5, false));
        sus.push(new UsabilityScaleItem("Ich denke, ich würde die  Unterstützung einer fachkundigen Person benötigen, um das System benutzen zu können.", DIMENSION_ANY, 5, true));
        sus.push(new UsabilityScaleItem("Ich fand, die verschiedenen Funktionen des Systems waren gut integriert.", DIMENSION_ANY, 5, false));
        sus.push(new UsabilityScaleItem("Ich halte das System für zu inkonsistent.", DIMENSION_ANY, 5, true));
        sus.push(new UsabilityScaleItem("Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dem System umzugehen.", DIMENSION_ANY, 5, false));
        sus.push(new UsabilityScaleItem("Ich fand das System sehr umständlich zu benutzen.", DIMENSION_ANY, 5, true));
        sus.push(new UsabilityScaleItem("Ich fühlte mich bei der Nutzung des Systems sehr sicher.", DIMENSION_ANY, 5, false));
        sus.push(new UsabilityScaleItem("Ich musste viele Dinge lernen, bevor ich  mit dem System arbeiten konnte.", DIMENSION_ANY, 5, true));
        setLocalItem(PROJECT_ORIGIN_SUS, sus);
    }
}

function createPredefinedGestures() {
    if (getLocalItem(PREDEFINED_GESTURE_SET) === null)
    {
        var images = new Array();
        images.push("http://placehold.it/200x150?text=1");
        images.push("http://placehold.it/200x150?text=2");
        images.push("http://placehold.it/200x150?text=3");
        images.push("http://placehold.it/200x150?text=4");
        images.push("http://placehold.it/200x150?text=5");

        var gestures = new Array();
        gestures.push(new Gesture(GESTURE_OWN_PROJECT, chance.natural(), 1451606400, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies ist .", TYPE_GESTURE_DISCRETE, TYPE_BODY_FULL, images, 2, null, false));
        gestures.push(new Gesture(GESTURE_OWN_PROJECT, chance.natural(), 1451692800, "Dies ist ein Gestentitel " + (gestures.length + 1), "Dies .", TYPE_GESTURE_POSE, TYPE_BODY_HAND, images, 1, null, false));
        gestures.push(new Gesture(GESTURE_OWN_PROJECT, chance.natural(), 1451779200, "Geste Hand Kreisen ", "Beschreibung hdhhsr.", TYPE_GESTURE_DISCRETE, TYPE_BODY_UPPER, images, 2, null, false));
        gestures.push(new Gesture(GESTURE_OWN_PROJECT, chance.natural(), 1451865600, "Fuß nach hinten ziehen", "wzhwsbf b.", TYPE_GESTURE_DISCRETE, TYPE_BODY_FULL, images, 0, null, false));
        gestures.push(new Gesture(GESTURE_OWN_PROJECT, chance.natural(), 1451952000, "Dies ist ein Gestentitel " + (gestures.length + 1), "Beschreibung rhsfgnsgk s dgh sfg.", TYPE_GESTURE_DISCRETE, TYPE_BODY_HAND, images, 2, null, false));
        gestures.push(new Gesture(GESTURE_CATALOG, chance.natural(), 1451606400, "Dies ist ein Gestentitel " + (gestures.length + 1), "lange Haha.", TYPE_GESTURE_POSE, TYPE_BODY_FULL, images, 1, null, false));
        gestures.push(new Gesture(GESTURE_CATALOG, chance.natural(), 1451692800, "Dies ist ein Gestentitel " + (gestures.length + 1), "Beschreibung.", TYPE_GESTURE_POSE, TYPE_BODY_HAND, images, 2, null, false));
        gestures.push(new Gesture(GESTURE_CATALOG, chance.natural(), 1451779200, "Dies ist ein Gestentitel " + (gestures.length + 1), "Beschreibung.", TYPE_GESTURE_DISCRETE, TYPE_BODY_UPPER, images, 2, null, false));
        gestures.push(new Gesture(GESTURE_CATALOG, chance.natural(), 1451865600, "Dies ist ein Gestentitel " + (gestures.length + 1), "Beschreibung.", TYPE_GESTURE_DISCRETE, TYPE_BODY_HAND, images, 0, null, false));

        setLocalItem(PREDEFINED_GESTURE_SET, gestures);
    }
}

function createPredefinedObservationForm() {
    if (getLocalItem(PREDEFINED_OBSERVATIONS) === null)
    {
        var form = new Array();
        form.push(new QuestionnaireItem('counter', DIMENSION_MENTAL_MODEL, 'Wie oft wurde die Geste falsch ausgeführt?', null, null));
        form.push(new QuestionnaireItem('openQuestion', DIMENSION_ANY, 'Was wurde sonst beobachtet?', null, null));
        form.push(new QuestionnaireItem('dichotomousQuestion', DIMENSION_MENTAL_MODEL, 'Wurde die Hilfe genutzt?', [false, false], null));
        form.push(new QuestionnaireItem('groupingQuestion', DIMENSION_MENTAL_MODEL, 'Wurde Hilfe benötigt?', [false, false], ['ja', 'nein', 'ein wenig']));
        setLocalItem(PREDEFINED_OBSERVATIONS, form);
    }
}

function createPredefinedGestureQuestionnaire() {
    if (getLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE) === null) {
        var form = new Array();
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_LERNABILITY, 'Ich denke, dass ich mir eine oder mehrere Gesten nicht gut merken kann.', [true, false], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_ERGONOMICS, 'Ich denke, dass eine oder mehrere Gesten nicht ergonomisch sind', [true, true], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_MENTAL_MODEL, 'Ich glaube, dass die meisten Menschen mit einer oder mehreren Gesten nicht lernen können damit umzugehen.', [true, false], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_ERGONOMICS, 'Ich glaube, dass die meisten Menschen eine oder mehrere Gesten nicht einfach ausführen können.', [true, true], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_USABILITY, 'Ich denke, dass eine oder mehrere Gesten nicht zu den anderen Gesten passen', [true, true], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_FEASIBILITY, 'Ich denke, dass sich eine oder mehrere Gesten nicht ausreichend von alltäglichen Bewegungen unterscheiden.', [true, false], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_USABILITY, 'Ich denke, dass eine oder mehrere Gesten nicht zu ihren Funktionen passen. ', [true, false], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_LERNABILITY, 'Ich denke, dass eine oder mehrere Gesten zu lang sind.', [true, false], null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_COGNITIVE_STRESS, 'Ich denke, dass eine oder mehrere Gesten zu komplex sind.', [true, false], null));
        setLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE, form);
    }
}

function createPredefinedGestureFeedback() {
    if (getLocalItem(PREDEFINED_GESTURE_FEEDBACK) === null) {
        var feedback = new Array();
        feedback.push(new Feedback(0, FEEDBACK_PREDEFINED, "wurde erkannt"));
        feedback.push(new Feedback(1, FEEDBACK_PREDEFINED, "wurde nicht erkannt"));
        setLocalItem(PREDEFINED_GESTURE_FEEDBACK, feedback);
    }
}

function renderSessionStorageData() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps)
    {
        for (var i = 0; i < phaseSteps.length; i++) {
            var item = phaseSteps[i];
            addPhaseStep(item.id, item.selectedId, item.itemText, item.color);
        }
    }

    var project = getLocalItem(PROJECT);
//    console.log(project);
    if (project) {
        $('#projectName').val(project.name);
        $('#projectDescription').val(project.description);
        if (project.phase !== 'unselected') {
            $('#phaseSelect').find('#' + project.phase).click();
//            $('#phaseSelect .selected').text($('#phaseSelect #' + project.phase + ' a').text());
        }
        if (project.surveyType !== 'unselected') {
            $('#surveyTypeSelect').find('#' + project.surveyType).click();
//            $('#surveyTypeSelect .selected').attr('id', project.surveyType);
//            $('#surveyTypeSelect .selected').text($('#surveyTypeSelect #' + project.surveyType + ' a').text());
        }

        if (project.usePrototypes === true)
        {
            $('#usePrototypesSwitch .switchButtonAddon').click();
        }
        if (project.useGestures === true) {
            $('#useGesturesSwitch .switchButtonAddon').click();
        }
        if (project.useTrigger === true) {
            $('#useTriggerSwitch .switchButtonAddon').click();
        }

        if (project.recordType !== 'unselected') {
            $('#recordSelect').find('#' + project.recordType).click();
        }
    }
}

function saveGeneralData() {
    var project = new Project();
    project.name = $('#projectName').val();
    project.description = $('#projectDescription').val();
    project.phase = $('#phaseSelect .chosen').attr('id');
    project.surveyType = $('#surveyTypeSelect .chosen').attr('id');
    project.usePrototypes = !$('#assemble-prototypes-set').hasClass('hidden');
    project.useGestures = !$('#assemble-gesture-set').hasClass('hidden');
    project.useTrigger = !$('#assemble-trigger-set').hasClass('hidden');
    project.recordType = $('#recordSelect .chosen').attr('id');
    setLocalItem(PROJECT, project);
    savePhases();
}

function savePhases() {
    var phases = new Array();
    var phaseSteps = $('#phaseStepList').children();

    for (var i = 0; i < phaseSteps.length; i++) {
        var item = phaseSteps[i];
        var id = $(item).attr('id');
        var selectedId = $(item).find('.btn-modify').attr('id');
        var itemText = $(item).find('.btn-text-button').text().trim();
        var color = $(item).find('.glyphicon-tag').css('color');
        phases.push(new PhaseItem(id, selectedId, itemText, color));
    }
    setLocalItem(PROJECT_PHASE_STEPS, phases);
}

function Project() {
    this.name;
    this.description;
    this.phase;
    this.surveyType;
    this.usePrototypes;
    this.useGestures;
    this.useTrigger;
}

function UsabilityScaleItem(question, dimension, likertScale, reversed) {
    this.question = question;
    this.dimension = dimension;
    this.likertScale = likertScale;
    this.reversed = reversed;
}

function PhaseItem(id, selectedId, itemText, color) {
    this.id = id;
    this.selectedId = selectedId;
    this.itemText = itemText;
    this.color = color;
}

function QuestionnaireItem(type, dimension, question, parameters, options) {
    this.type = type;
    this.dimension = dimension;
    this.question = question;
    this.parameters = parameters;
    this.options = options;
}

function Scenario() {
    this.title;
    this.description;
    this.scene;
    this.elicitationTrigger;
    this.woz;
    this.help;
    this.observations;
}

function Training() {
    this.title;
    this.description;
    this.useSingleTraining;
    this.training;
    this.observations;
}

function TrainingItem(gesture, trigger, feedback, repeats) {
    this.gesture = gesture;
    this.trigger = trigger;
    this.feedback = feedback;
    this.repeats = repeats;
}

function WOZ(gesture, trigger, feedback, recognitionTime) {
    this.gesture = gesture;
    this.trigger = trigger;
    this.feedback = feedback;
    this.recognitionTime = recognitionTime;
}

function Help() {
    this.option;
    this.useGestureHelp;
    this.gestureId;
}

function Slideshow() {
    this.title;
    this.description;
    this.slideshowFor;
    this.answerTime;
    this.slideshow;
    this.observations;
}

function SlideshowItem(gesture, trigger) {
    this.gesture = gesture;
    this.trigger = trigger;
}

function Gesture(type, id, timestamp, title, description, gestureType, bodyType, images, previewImage, videoUrl, used) {
    this.type = type;
    this.id = id;
    this.timestamp = timestamp;
    this.title = title;
    this.description = description;
    this.gestureType = gestureType;
    this.bodyType = bodyType;
    this.images = images;
    this.previewImage = previewImage;
    this.videoUrl = videoUrl;
    this.used = used;
}

function Feedback(id, type, title) {
    this.id = id;
    this.type = type;
    this.title = title;
}

function Trigger(id, type, title) {
    this.id = id;
    this.type = type;
    this.title = title;
}

function Prototype(id, type, title, options, data) {
    this.id = id;
    this.type = type;
    this.title = title;
    this.options = options;
    this.data = data;
}

function getDimensionByElement(element) {
    var dimensions = new Array();
    dimensions.push(DIMENSION_ACCEPTABILITY);
    dimensions.push(DIMENSION_COGNITIVE_STRESS);
    dimensions.push(DIMENSION_ERGONOMICS);
    dimensions.push(DIMENSION_FEASIBILITY);
    dimensions.push(DIMENSION_LERNABILITY);
    dimensions.push(DIMENSION_MENTAL_MODEL);
    dimensions.push(DIMENSION_RELIABILITY);
    dimensions.push(DIMENSION_USABILITY);

    for (var i = 0; i < dimensions.length; i++) {
        if ($(element).hasClass(dimensions[i]) === true) {
            return dimensions[i];
        }
    }
    return DIMENSION_ANY;
}