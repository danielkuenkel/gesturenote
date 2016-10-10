/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentIdForModal;
var colors;
var currentContainerList = null;
function checkSessionStorage() {
    checkAssembledGestures(getLocalItem(ASSEMBLED_GESTURE_SET), getLocalItem(GESTURE_CATALOG));
    createOriginPhases();
    createOriginGUS();
    createOriginSUS();
    createPredefinedObservationForm();
    createPredefinedGestureQuestionnaire();
    createPredefinedGestureFeedback();
    renderSessionStorageData();
}

function createOriginPhases() {
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    if (phaseSteps === null || phaseSteps === undefined || (phaseSteps && phaseSteps.length === 0))
    {
        var phases = new Array();
        phases.push(new PhaseItem(chance.natural(), LETTER_OF_ACCEPTANCE, colors.pop()));
        phases.push(new PhaseItem(chance.natural(), THANKS, colors.pop()));
        setLocalItem(STUDY_PHASE_STEPS, phases);
    }
}

function createOriginGUS() {
    var items = translation.singleGUS;
    setLocalItem(STUDY_ORIGIN_GUS, items);
}

function createOriginSUS() {
    var items = translation.sus;
    setLocalItem(STUDY_ORIGIN_SUS, items);
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
    var items = translation.multipleGUS;
    setLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE, items);
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
    renderPhaseSteps();
    renderAgeRanges();
    renderGenderSwitch();

    var study = getLocalItem(STUDY);
    if (study) {
        $('#panelSurveySwitch').find('#' + study.panelSurvey).click();

        $('#studyTitle').val(study.title);
        $('#studyDescription').val(study.description);
        if (study.phase !== 'unselected') {
            $('#phaseSelect').find('#' + study.phase).click();
        }
        if (study.surveyType !== 'unselected') {
            $('#surveyTypeSelect').find('#' + study.surveyType).click();
        }
        if (study.useScenes === true) {
            $('#useScenesSwitch #yes').click();
        }
        if (study.useGestures === true) {
            $('#useGesturesSwitch #yes').click();
        }
        if (study.useTrigger === true) {
            $('#useTriggerSwitch #yes').click();
        }
        if (study.useFeedback === true) {
            $('#useFeedbackSwitch #yes').click();
        }

        if (study.gender !== 'unselected') {
            $('#genderSwitch').find('#' + study.gender).click();
        }

//        if (study.recordType !== 'unselected') {
//            $('#recordSelect').find('#' + study.recordType).click();
//        }

        $('#from-To-datepicker .input-daterange input').each(function () {
            if ($(this).attr('id') === 'start' && study.dateFrom !== null && study.dateFrom !== "0" && study.dateFrom !== "") {
                var dateFrom = new Date(study.dateFrom * 1000);
                $(this).datepicker('setDate', dateFrom);
            } else if ($(this).attr('id') === 'end' && study.dateTo !== null && study.dateTo !== "0" && study.dateTo !== "") {
                var dateTo = new Date(study.dateTo * 1000);
                $(this).datepicker('setDate', dateTo);
            }
        });
    }
    updateCatalogButtons();
    checkPreviewAvailability();
}

function renderAgeRanges() {
    var study = getLocalItem(STUDY);
    var studyPanel = getLocalItem(STUDY_PANEL);

    if (study) {
        if (study.ageRange && study.ageRange !== '' && studyPanel) {
            var ranges = study.ageRange.split(',');
            $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, value: [Math.max(studyPanel.min, parseInt(ranges[0])), Math.min(studyPanel.max, parseInt(ranges[1]))]});
        } else {
            $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, value: [studyPanel.min, studyPanel.max]});
        }
    } else {
        $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, value: [studyPanel.min, studyPanel.max]});
    }

    $('#ageSlider .slider-from').text(translation[$('#ageSlider .slider-from').attr('name')] + " " + translation.of + " " + studyPanel.min);
    $('#ageSlider .slider-to').text(translation.to + " " + studyPanel.max);
}

function renderGenderSwitch() {
    var studyPanel = getLocalItem(STUDY_PANEL);
    if (studyPanel.availableGender && studyPanel.availableGender.length > 0) {
        $('#genderSwitch #identical').removeClass('disabled');
        for (var i = 0; i < studyPanel.availableGender.length; i++) {
            $('#genderSwitch #' + studyPanel.availableGender[i]).removeClass('disabled');
        }
    }

}

function renderPhaseSteps() {
    $('#phaseStepList').empty();
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    if (phaseSteps)
    {
        for (var i = 0; i < phaseSteps.length; i++) {
            var item = phaseSteps[i];
            addPhaseStep(item.id, item.format, item.color);
        }

        if (getLocalItem(STUDY) && getLocalItem(STUDY).phase) {
            if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
                $('#phaseStepList').find('.' + TYPE_PHASE_ELICITATION).removeClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_EVALUATION).addClass('hidden');
            } else if (getLocalItem(STUDY).phase === TYPE_PHASE_EVALUATION) {
                $('#phaseStepList').find('.' + TYPE_PHASE_EVALUATION).removeClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_ELICITATION).addClass('hidden');
            } else {
                $('#phaseStepList').find('.both').removeClass('hidden');
            }
        }
    }
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
    var study = new Study();
    study.title = $('#studyTitle').val();
    study.description = $('#studyDescription').val();
    study.phase = $('#phaseSelect .chosen').attr('id');
    study.surveyType = $('#surveyTypeSelect .chosen').attr('id');
//    study.recordType = $('#recordSelect .chosen').attr('id');
    study.panelSurvey = $('#panelSurveySwitch').find('.active').attr('id');
    if (study.panelSurvey === 'yes') {
        study.gender = $('#genderSwitch').find('.active').attr('id');
        study.ageRange = $('#ageSlider .custom-range-slider').attr('value');
    } else {
        study.gender = null;
        study.ageRange = null;
    }

    $('#from-To-datepicker .input-daterange input').each(function () {
        var formattedDate = $(this).datepicker('getDate');
        var saveDate;
        if (formattedDate !== null) {
            saveDate = new Date(formattedDate).getTime() / 1000;
        } else {
            saveDate = null;
        }

        if ($(this).attr('id') === 'start') {
            study.dateFrom = saveDate;
        } else {
            study.dateTo = saveDate;
        }
    });
    setLocalItem(STUDY, study);
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
//        var itemText = $(item).find('.btn-text-button').text().trim();
        var color = $(item).find('.glyphicon-tag').css('color');
        phases.push(new PhaseItem(id, format, color));
    }
    setLocalItem(STUDY_PHASE_STEPS, phases);
}

function Study() {
    this.title;
    this.description;
    this.phase;
    this.surveyType;
    this.panelSurvey;
    this.gender;
    this.ageRange;
    this.dateFrom;
    this.dateTo;
}

function UsabilityScaleItem(question, dimension, likertScale, reversed) {
    this.question = question;
    this.dimension = dimension;
    this.likertScale = likertScale;
    this.reversed = reversed;
}

function PhaseItem(id, format, color) {
    this.id = id;
    this.format = format;
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

function getAvailableGender(tester) {
    var gender = new Array();
    var oldGender = null;
    for (var i = 0; i < tester.length; i++) {
        var currentGender = tester[i].gender;
        if (currentGender !== oldGender) {
            oldGender = currentGender;
            gender.push(currentGender);
        }
    }
    return gender;
}