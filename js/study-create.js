/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentIdForModal;
var colors;
//var currentContainerList = null;
function checkSessionStorage() {
    checkAssembledGestures(getLocalItem(ASSEMBLED_GESTURE_SET), getLocalItem(GESTURE_CATALOG));
    createOriginPhases();
//    createOriginGUS();
//    createOriginSUS();
//    createPredefinedObservationForm();
//    createPredefinedGestureQuestionnaire();
    createPredefinedGestureFeedback();
    renderSessionStorageData();
}

function createOriginPhases() {
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    if (phaseSteps === null || phaseSteps === undefined || (phaseSteps && phaseSteps.length === 0))
    {
        var phases = new Array();
        phases.push({id: chance.natural(), format: LETTER_OF_ACCEPTANCE, color: colors.pop()});//new PhaseItem(chance.natural(), LETTER_OF_ACCEPTANCE, colors.pop()));
        phases.push({id: chance.natural(), format: THANKS, color: colors.pop()});//new PhaseItem(chance.natural(), THANKS, colors.pop()));
        setLocalItem(STUDY_PHASE_STEPS, phases);
    }
    
}

//function createOriginGUS() {
//    var items = translation.singleGUS;
//    setLocalItem(STUDY_ORIGIN_GUS, items);
//}

//function createOriginSUS() {
//    var items = translation.sus;
//    setLocalItem(STUDY_ORIGIN_SUS, items);
//}

//function createPredefinedObservationForm() {
//    if (getLocalItem(PREDEFINED_OBSERVATIONS) === null)
//    {
//        var form = new Array();
//        form.push({format: COUNTER, dimension: DIMENSION_ANY, question: 'Wie oft wurde die Geste falsch ausgeführt?', parameters: {countFrom: 0, countTo: 10}, options: null});
//        form.push({format: DICHOTOMOUS_QUESTION, dimension: DIMENSION_ANY, question: 'Wurde die Hilfe genutzt?', parameters: {justification: 'no', justificationFor: 'yes'}, options: null});
//        form.push({format: GROUPING_QUESTION, dimension: DIMENSION_ANY, question: 'Wurde Hilfe benötigt?', parameters: {multiselect: 'no', optionalanswer: 'no'}, options: [{id: chance.natural(), title: 'ja'}, {id: chance.natural(), title: 'nein'}, {id: chance.natural(), title: 'ein wenig'}]});
//        form.push({format: OPEN_QUESTION, dimension: DIMENSION_ANY, question: 'Was wurde sonst beobachtet?', parameters: null, options: null});
//        setLocalItem(PREDEFINED_OBSERVATIONS, form);
//    }
//}

//function createPredefinedGestureQuestionnaire() {
//    var items = translation.multipleGUS;
//    setLocalItem(PREDEFINED_GESTURE_QUESTIONNAIRE, items);
//}

function createPredefinedGestureFeedback() {
    if (getLocalItem(ASSEMBLED_FEEDBACK) === null) {
        var feedback = new Array();
        feedback.push({id: chance.natural(), type: TYPE_FEEDBACK_TEXT, title: 'Geste wurde erkannt', parameters: {negative: 'no'}, data: null});
        feedback.push({id: chance.natural(), type: TYPE_FEEDBACK_TEXT, title: 'Geste wurde nicht erkannt', parameters: {negative: 'yes'}, data: null});
//        new Feedback(0, TYPE_FEEDBACK_TEXT, "Geste wurde erkannt", [false], null));
//        feedback.push(new Feedback(1, TYPE_FEEDBACK_TEXT, "Geste wurde nicht erkannt", [true], null));
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
    var study = new Object();
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
        phases.push({id: id, format: format, color: color});//new PhaseItem(id, format, color));
    }
    setLocalItem(STUDY_PHASE_STEPS, phases);
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

var closeClicked = false;
function onCloseClick() {
    closeClicked = true;
    saveData();
    currentIdForModal = null;
}


/* 
 * common form format functions 
 */

$(document).on('click', '#addFormat', function (event) {
    event.preventDefault();
    if (event.handled !== true && !$(this).hasClass('disabled'))
    {
        event.handled = true;
        var format = $(this).parent().find('.chosen').attr('id');
        if (format !== 'unselected') {
            var clone = $('#form-item-container').find('#' + format).clone(true);
            var listContainer = $(this).closest('.root').find('#list-container');
            $(listContainer).prepend(clone);
            checkCurrentListState(listContainer);
            updateBadges(listContainer, format);
            TweenMax.from(clone, .3, {y: -20, opacity: 0, clearProps: 'all'});
        }
    }
});

$(document).on('click', '.btn-add-groupingQuestionOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#groupingQuestionItem').clone().removeAttr('id');
        item.attr('id', chance.natural());
        $(this).prev().find('.panel-body').append(item);
        checkCurrentListState($(this).prev().find('.panel-body'));
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-ratingOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#ratingItem').clone().removeAttr('id');
        $(this).prev().find('.panel-body').append(item);
        checkCurrentListState($(this).prev().find('.panel-body'));
        $(item).find('.chosen').attr('id', 3);
        $(item).find('.show-dropdown').val(3);
        $(item).find('#scale_3').addClass('selected');
        renderScaleItems($(item).find('.ratingScaleItemContainer'), 3, translation.defaultScales);
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-sumQuestionOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#sumQuestionItem').clone().removeAttr('id');
        $(this).prev().find('.panel-body').append(item);
        checkCurrentListState($(this).prev().find('.panel-body'));
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-rankingOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var item = $('#form-item-container').find('#rankingItem').clone().removeAttr('id');
        $(item).attr('id', chance.natural());
        $(this).prev().find('.panel-body').append(item);
        checkCurrentListState($(this).prev().find('.panel-body'));
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-woz-experimentOption', function (event) {
    event.preventDefault();
    if (event.handled !== true)
    {
        event.handled = true;
        var wozItem = $('#form-item-container').find('#wozExperimentItem').clone().removeAttr('id');
        if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
            $(wozItem).find('.evaluation').addClass('hidden');
        }
        $(this).prev().append(wozItem);
        checkCurrentListState($(this).prev());
        TweenMax.from(wozItem, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-helpOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var item = $('#form-item-container').find('#helpItem').clone().removeAttr('id');
        $(this).prev().append(item);
        checkCurrentListState($(this).prev());
//        updateHelpItemCounter($(this).prev());
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-triggerOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var item = $('#form-item-container').find('#triggerItem').clone().removeAttr('id');
        $(this).parent().prev().append(item);
        checkCurrentListState($(this).parent().prev());
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-gestureTrainingOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var item = $('#form-item-container').find('#gestureTrainingItem').clone().removeAttr('id');
        $(this).prev().append(item);
        checkCurrentListState($(this).prev());
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});

$(document).on('click', '.btn-add-identificationOption', function (event) {
    if (event.handled !== true)
    {
        event.handled = true;
        event.preventDefault();
        var item = $('#form-item-container').find('#identificationItem').clone().removeAttr('id');
        $(this).prev().append(item);
        var identificationFor = $('#identificationTypeSwitch').find('.active').attr('id');
        if (identificationFor === 'gestures') {
            $(item).find('#group-gestures').remove();
//            $(item).find('#group-trigger').removeClass('hidden');
        } else {
            $(item).find('#group-trigger').remove();
//            $(item).find('#group-gestures').removeClass('hidden');
        }
        checkCurrentListState($(this).prev());
        TweenMax.from(item, .2, {y: -10, opacity: 0, clearProps: 'all'});
    }
});





/*
 * Specific alternative switch functionalities
 */

//$('body').on('click', '.alternativeSwitch .check', function (event) {
//    event.preventDefault();
//    console.log('check alternativeSwitch');
//    if (event.handled !== true)
//    {
//        event.handled = true;
//        $(this).closest('.root').find('.alternativeGestureSelect').addClass('hidden');
//        $(this).closest('.root').find('.alternativeTriggerSelect').addClass('hidden');
//        if ($(this).hasClass(ALERT_NO_GESTURES_ASSEMBLED)) {
//            if (assembledGestures() !== null) {
//                $(this).closest('.root').find('.alternativeGestureSelect').removeClass('hidden');
//            }
//        } else if ($(this).hasClass(ALERT_NO_TRIGGER_ASSEMBLED)) {
//            if (getLocalItem(ASSEMBLED_TRIGGER) !== null) {
//
//
//            }
//        }
//    }
//});