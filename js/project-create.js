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
    createPredefinedObservationForm();
    createPredefinedGestureQuestionnaire();
    createPredefinedGestureFeedback();
    renderSessionStorageData();
}

var gusOptions = ['Trifft gar nicht zu', 'Trifft eher nicht zu', 'Teils-teils', 'Trifft eher zu', 'Trifft voll und ganz zu'];
function createOriginGUS() {
//    if (getLocalItem(PROJECT_ORIGIN_GUS) === null) {
    var items = translation.singleGUS;
    setLocalItem(PROJECT_ORIGIN_GUS, items);
//        for (var i = 0; i < items.length; i++){
//            console.log(items[i]);
//        } 
//        var gus = new Array();
//        gus.push(new QuestionnaireItem(ALTERNATIVE_QUESTION, DIMENSION_COGNITIVE_STRESS, 'Ich denke, dass es zu dieser Geste alternative Gesten gibt.', [true, true, false, 'gestures', 'gesture'], null));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_LERNABILITY, 'Ich denke, dass ich mir diese Geste sehr gut merken kann.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_LERNABILITY, 'Ich glaube, dass die meisten Menschen sehr schnell lernen würden, mit dieser Geste umzugehen.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_MENTAL_MODEL, 'Ich denke, dass sich diese Geste von anderen Gesten ausreichend unterscheidet.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_FEASIBILITY, 'Ich denke, dass sich die Geste von alltäglichen Bewegungen ausreichend unterscheidet.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_MENTAL_MODEL, 'Ich denke, dass die Geste zur Funktion passt.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass die Geste zu lang ist.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass die Geste zu komplex ist.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass die Geste prägnant ist.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass die Geste bequem ist.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass die Bewegung der Geste komisch ist.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass die Geste ermüdend ist.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ERGONOMICS, 'Ich denke, dass mich die Geste körperlich zu sehr fordert.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ACCEPTABILITY, 'Ich würde diese Geste gerne regelmäßig nutzen.', [true, false], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ACCEPTABILITY, 'Ich denke, dass die Geste andere Personen im Umfeld beeinträchtigt oder stört.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ACCEPTABILITY, 'Die Geste ist peinlich.', [true, true], gusOptions));
//        gus.push(new QuestionnaireItem(GUS_SINGLE, DIMENSION_ACCEPTABILITY, 'Ich fühle mich beim Ausführen der Geste wohl.', [true, false], gusOptions));

//    }
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

function createPredefinedObservationForm() {
    if (getLocalItem(PREDEFINED_OBSERVATIONS) === null)
    {
        var form = new Array();
        form.push(new QuestionnaireItem(COUNTER, DIMENSION_MENTAL_MODEL, 'Wie oft wurde die Geste falsch ausgeführt?', null, null));
        form.push(new QuestionnaireItem(DICHOTOMOUS_QUESTION, DIMENSION_MENTAL_MODEL, 'Wurde die Hilfe genutzt?', [false, false], null));
        form.push(new QuestionnaireItem(GROUPING_QUESTION, DIMENSION_MENTAL_MODEL, 'Wurde Hilfe benötigt?', [false, false], ['ja', 'nein', 'ein wenig']));
        form.push(new QuestionnaireItem(OPEN_QUESTION, DIMENSION_ANY, 'Was wurde sonst beobachtet?', null, null));
        setLocalItem(PREDEFINED_OBSERVATIONS, form);
    }
}

function createPredefinedGestureQuestionnaire() {
    var items = translation.singleMultiple;
    setLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE, items);
//    if (getLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE) === null) {
//        var form = new Array();
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_LERNABILITY, 'Ich denke, dass ich mir eine oder mehrere Gesten nicht gut merken kann.', [true, false, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_ERGONOMICS, 'Ich denke, dass eine oder mehrere Gesten nicht ergonomisch sind.', [true, true, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_MENTAL_MODEL, 'Ich glaube, dass die meisten Menschen mit einer oder mehreren Gesten nicht lernen können damit umzugehen.', [true, false, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_ERGONOMICS, 'Ich glaube, dass die meisten Menschen eine oder mehrere Gesten nicht einfach ausführen können.', [true, true, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_USABILITY, 'Ich denke, dass eine oder mehrere Gesten nicht zu den anderen Gesten passen', [true, true, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_FEASIBILITY, 'Ich denke, dass sich eine oder mehrere Gesten nicht ausreichend von alltäglichen Bewegungen unterscheiden.', [true, false, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_USABILITY, 'Ich denke, dass eine oder mehrere Gesten nicht zu ihren Funktionen passen. ', [true, false, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_LERNABILITY, 'Ich denke, dass eine oder mehrere Gesten zu lang sind.', [true, false, 'gestures'], null));
//        form.push(new QuestionnaireItem(GROUPING_QUESTION_GUS, DIMENSION_COGNITIVE_STRESS, 'Ich denke, dass eine oder mehrere Gesten zu komplex sind.', [true, false, 'gestures'], null));
//        setLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE, form);
//    }
}

function createPredefinedGestureFeedback() {
    if (getLocalItem(ASSEMBLED_FEEDBACK) === null) {
        var feedback = new Array();
        feedback.push(new Feedback(0, TYPE_FEEDBACK_TEXT, "Geste wurde erkannt", [false], null));
        feedback.push(new Feedback(1, TYPE_FEEDBACK_TEXT, "Geste wurde nicht erkannt", [true], null));
        setLocalItem(ASSEMBLED_FEEDBACK, feedback);
    }
}

function renderSessionStorageData() {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps)
    {
        for (var i = 0; i < phaseSteps.length; i++) {
            var item = phaseSteps[i];
            addPhaseStep(item.id, item.format, item.itemText, item.color);
        }
    }

    var project = getLocalItem(PROJECT);
    if (project) {
        $('#projectName').val(project.name);
        $('#projectDescription').val(project.description);
        if (project.ageRange) {
            var ranges = project.ageRange.split(',');
            var ageMin = 18;
            var ageMax = 100;
            $("#ageSlider .custom-range-slider").slider({min: ageMin, max: ageMax, value: [parseInt(ranges[0]), parseInt(ranges[1])]});
        }

        if (project.phase !== 'unselected') {
            $('#phaseSelect').find('#' + project.phase).click();
        }
        if (project.surveyType !== 'unselected') {
            $('#surveyTypeSelect').find('#' + project.surveyType).click();
        }
        if (project.useScenes === true) {
            $('#useScenesSwitch #yes').click();
        }
        if (project.useGestures === true) {
            $('#useGesturesSwitch #yes').click();
        }
        if (project.useTrigger === true) {
            $('#useTriggerSwitch #yes').click();
        }
        if (project.useFeedback === true) {
            $('#useFeedbackSwitch #yes').click();
        }
        if (project.recordType !== 'unselected') {
            $('#recordSelect').find('#' + project.recordType).click();
        }
        if (project.gender !== 'unselected') {
            $('#genderSwitch').find('#' + project.gender).click();
        }

        $('#from-To-datepicker .input-daterange input').each(function () {
            if ($(this).attr('id') === 'start' && project.dateFrom !== null) {
                var dateFrom = new Date(project.dateFrom * 1000);
                $(this).datepicker('setDate', dateFrom);
            } else if ($(this).attr('id') === 'end' && project.dateTo !== null) {
                var dateTo = new Date(project.dateTo * 1000);
                $(this).datepicker('setDate', dateTo);
            }
        });
    }
    updateCatalogButtons();
}

function updateCatalogButtons() {
    var gestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (gestures && gestures.length > 0) {
        $('#btn-study-gestures, #btn-clear-study-gestures').removeClass('hidden');
    } else {
        $('#btn-study-gestures, #btn-clear-study-gestures').addClass('hidden');
    }

    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    if (feedback && feedback.length > 0) {
        $('#btn-clear-feedback').removeClass('hidden');
        $('#btn-assemble-feedback .btn-text').text(translation.openSet);
        $('#btn-assemble-feedback .fa').removeClass('fa-pencil').addClass('fa-folder-open');
    } else {
        $('#btn-clear-feedback').addClass('hidden');
        $('#btn-assemble-feedback .btn-text').text(translation.arrangeSet);
        $('#btn-assemble-feedback .fa').removeClass('fa-folder-open').addClass('fa-pencil');
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
        $('#btn-clear-trigger').removeClass('hidden');
        $('#btn-assemble-trigger .btn-text').text(translation.openSet);
        $('#btn-assemble-trigger .fa').removeClass('fa-pencil').addClass('fa-folder-open');
    } else {
        $('#btn-clear-trigger').addClass('hidden');
        $('#btn-assemble-trigger .btn-text').text(translation.arrangeSet);
        $('#btn-assemble-trigger .fa').removeClass('fa-folder-open').addClass('fa-pencil');
    }

    var scenes = getLocalItem(ASSEMBLED_SCENES);
    if (scenes && scenes.length > 0) {
        $('#btn-clear-scenes').removeClass('hidden');
        $('#btn-assemble-scenes .btn-text').text(translation.openSet);
        $('#btn-assemble-scenes .fa').removeClass('fa-pencil').addClass('fa-folder-open');
    } else {
        $('#btn-clear-scenes').addClass('hidden');
        $('#btn-assemble-scenes .btn-text').text(translation.arrangeSet);
        $('#btn-assemble-scenes .fa').removeClass('fa-folder-open').addClass('fa-pencil');
    }
}

function saveGeneralData() {
    var project = new Project();
    project.name = $('#projectName').val();
    project.description = $('#projectDescription').val();
    project.phase = $('#phaseSelect .chosen').attr('id');
    project.surveyType = $('#surveyTypeSelect .chosen').attr('id');
//    project.useScenes = !$('#assemble-scenes-set').hasClass('hidden');
//    project.useGestures = !$('#assemble-gesture-set').hasClass('hidden');
//    project.useTrigger = !$('#assemble-trigger-set').hasClass('hidden');
//    project.useFeedback = !$('#assemble-feedback-set').hasClass('hidden');
    project.recordType = $('#recordSelect .chosen').attr('id');
    project.gender = $('#genderSwitch').find('.active').attr('id');
    project.ageRange = $('#ageSlider .custom-range-slider').attr('value');
//    console.log($('#ageSlider .custom-range-slider').attr('value'));
    $('#from-To-datepicker .input-daterange input').each(function () {
        var formattedDate = $(this).datepicker('getDate');

        var saveDate;
        if (formattedDate !== null) {
            saveDate = new Date(formattedDate).getTime() / 1000;
        } else {
            saveDate = null;
        }

        if ($(this).attr('id') === 'start') {
            project.dateFrom = saveDate;
        } else {
            project.dateTo = saveDate;
        }
    });

    setLocalItem(PROJECT, project);
    savePhases();
    updateCatalogButtons();
}

function savePhases() {
    var phases = new Array();
    var phaseSteps = $('#phaseStepList').children();

    for (var i = 0; i < phaseSteps.length; i++) {
        var item = phaseSteps[i];
        var id = $(item).attr('id');
        var format = $(item).find('.btn-modify').attr('id');
        var itemText = $(item).find('.btn-text-button').text().trim();
        var color = $(item).find('.glyphicon-tag').css('color');
        phases.push(new PhaseItem(id, format, itemText, color));
    }
    setLocalItem(PROJECT_PHASE_STEPS, phases);
}

function Project() {
    this.name;
    this.description;
    this.phase;
    this.surveyType;
    this.dateFrom;
    this.dateTo;
    this.gender;
    this.ageRange;
}

function UsabilityScaleItem(question, dimension, likertScale, reversed) {
    this.question = question;
    this.dimension = dimension;
    this.likertScale = likertScale;
    this.reversed = reversed;
}

function PhaseItem(id, format, itemText, color) {
    this.id = id;
    this.format = format;
    this.itemText = itemText;
    this.color = color;
}

function QuestionnaireItem(format, dimension, question, parameters, options) {
    this.format = format;
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

function TrainingItem(gestureId, triggerId, feedbackId, repeats, recognitionTime) {
    this.gestureId = gestureId;
    this.triggerId = triggerId;
    this.feedbackId = feedbackId;
    this.repeats = repeats;
    this.recognitionTime = recognitionTime;
}

function WOZ(sceneId, triggerId, gestureId, feedbackId, transitionId) {
    this.sceneId = sceneId;
    this.triggerId = triggerId;
    this.gestureId = gestureId;
    this.feedbackId = feedbackId;
    this.transitionId = transitionId;
}

function Help() {
    this.sceneId;
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
    this.identification;
    this.observations;
}

function SlideshowItem(gestureId, triggerId) {
    this.gestureId = gestureId;
    this.triggerId = triggerId;
}

function PhysicalStressTest() {
    this.title;
    this.description;
    this.randomized;
    this.stressAmount;
    this.stressTestItems;
    this.singleStressQuestions;
    this.singleStressGraphicsRating;
    this.sequenceStressQuestions;
    this.sequenceStressGraphicsRating;
    this.observations;
}

function PhysicalStressTestItem(gestureId) {
    this.gestureId = gestureId;
}

function Identification() {
    this.title;
    this.description;
    this.identificationFor;
    this.identification;
    this.observations;
}

function Feedback(id, type, title, parameters, data) {
    this.id = id;
    this.type = type;
    this.title = title;
    this.parameters = parameters;
    this.data = data;
}

function Trigger(id, type, title) {
    this.id = id;
    this.type = type;
    this.title = title;
}

function Scene(id, type, title, options, data) {
    this.id = id;
    this.type = type;
    this.title = title;
    this.options = options;
    this.data = data;
}

function getProjectSubmitData() {
    saveGeneralData();
    savePhases();

    var generalData = getLocalItem(PROJECT);

    var phases = getLocalItem(PROJECT_PHASE_STEPS);
    if (phases && phases.length > 0) {
        generalData.phases = phases;
        for (var i = 0; i < phases.length; i++) {
            generalData[phases[i].id] = getLocalItem(phases[i].id + '.data');
        }
    }

    if (getLocalItem(ASSEMBLED_SCENES)) {
        generalData.assembledScenes = getLocalItem(ASSEMBLED_SCENES);
    }

    if (getLocalItem(ASSEMBLED_GESTURE_SET)) {
        generalData.assembledGestureSet = getLocalItem(ASSEMBLED_GESTURE_SET);
    }

    if (getLocalItem(ASSEMBLED_TRIGGER)) {
        generalData.assembledTrigger = getLocalItem(ASSEMBLED_TRIGGER);
    }

    if (getLocalItem(ASSEMBLED_FEEDBACK)) {
        generalData.assembledFeedback = getLocalItem(ASSEMBLED_FEEDBACK);
    }

    return {generalData: generalData};
}