/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentIdForModal;
var colors;
function checkSessionStorage() {
    checkAssembledGestures(getLocalItem(ASSEMBLED_GESTURE_SET), getLocalItem(GESTURE_CATALOG));
    createOriginPhases();
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

function createPredefinedGestureFeedback() {
    if (getLocalItem(ASSEMBLED_FEEDBACK) === null) {
        var feedback = new Array();
        feedback.push({id: chance.natural(), type: TYPE_FEEDBACK_TEXT, title: 'Geste wurde erkannt', parameters: {negative: 'no'}, data: null});
        feedback.push({id: chance.natural(), type: TYPE_FEEDBACK_TEXT, title: 'Geste wurde nicht erkannt', parameters: {negative: 'yes'}, data: null});
        setLocalItem(ASSEMBLED_FEEDBACK, feedback);
    }
}

function renderSessionStorageData() {
    renderPhaseSteps();
    renderGenderSwitch();
    renderAgeRanges();

    var study = getLocalItem(STUDY);
    if (study) {
        $('#panelSurveySwitch').find('#' + study.panelSurvey).click();

        $('#studyTitle').val(study.title);
        $('#studyDescription').val(study.description);
        if (study.phase !== 'unselected') {
            firstInit = false;
            $('#phaseSelect').find('#' + study.phase).click();
        }
        if (study.surveyType !== 'unselected') {
            firstInit = false;
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

        var studyPanel = getLocalItem(STUDY_PANEL);
        var ranges = [studyPanel.min, studyPanel.max];
        if (study.ageRange && study.ageRange !== '' && studyPanel) {
            ranges = study.ageRange.split(',');
        }
        updateSelectionText(ranges, $('#genderSwitch').find('.active').attr('id'));

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

//var currentSelectedAgeRange = null;
function renderAgeRanges() {
    var study = getLocalItem(STUDY);
    var studyPanel = getLocalItem(STUDY_PANEL);
    var ranges = calculateAgeRangeForGender(studyPanel.raw, $('#genderSwitch').find('.active').attr('id'));



//    var value = slider.getValue();
//    console.log(value)

    if (study) {
        if (study.ageRange && study.ageRange !== '' && studyPanel) {
            ranges.min = parseInt(study.ageRange.split(',')[0]);
            ranges.max = parseInt(study.ageRange.split(',')[1]);
//            $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, range: true, value: [Math.max(studyPanel.min, parseInt(ranges[0])), Math.min(studyPanel.max, parseInt(ranges[1]))], tooltip: 'hide'});
        } else {
//            $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, range: true, value: [parseInt(ranges[0]), parseInt(ranges[1])], tooltip: 'hide'});
        }
    } else {
//        $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, range: true, value: [parseInt(ranges[0]), parseInt(ranges[1])], tooltip: 'hide'});
    }
    console.log(studyPanel.min, ranges.min, studyPanel.max, ranges.max);
    var slider = new Slider('#ageSlider .custom-range-slider', {
        formatter: function (value) {
            return 'Current value: ' + value;
        },
        tooltip: 'hide',
        min: studyPanel.min,
        max: studyPanel.max,
        range: true,
        value: [Math.max(studyPanel.min, ranges.min || studyPanel.min), Math.min(studyPanel.max, ranges.max || studyPanel.max)]
    });

    $('#ageSlider .slider-from').text(translation[$('#ageSlider .slider-from').attr('name')] + " " + translation.of + ' ' + translation.atLeast + " " + studyPanel.min);
    $('#ageSlider .slider-to').text(translation.to + " " + ' ' + translation.maximal + ' ' + studyPanel.max);

    $('#ageSlider').unbind('slide').bind('slide', function (slideEvt) {
        currentSelectedAgeRange = slideEvt.value;
        updateSelectionText(slideEvt.value, $('#genderSwitch').find('.active').attr('id'));
    });

    $('#genderSwitch').on('change', function () {
        var selectedGender = $('#genderSwitch').find('.active').attr('id');
        var ageRange = calculateAgeRangeForGender(studyPanel.raw, selectedGender);
        slider.setAttribute('min', ageRange.min);
        slider.setAttribute('max', ageRange.max);

        $('#ageSlider .slider-from').text(translation[$('#ageSlider .slider-from').attr('name')] + " " + translation.of + ' ' + translation.atLeast + " " + ageRange.min);
        $('#ageSlider .slider-to').text(translation.to + " " + ' ' + translation.maximal + ' ' + ageRange.max);
        currentSelectedAgeRange = [Math.max(ageRange.min, parseInt(currentSelectedAgeRange[0])), Math.min(ageRange.max, parseInt(currentSelectedAgeRange[1]))]
        slider.setValue(currentSelectedAgeRange);
        slider.refresh();
//                $("#ageSlider .custom-range-slider").attr('value', Math.max(ageRange.min, parseInt(currentSelectedAgeRange[0])) + ',' + Math.min(ageRange.max, parseInt(currentSelectedAgeRange[1])));//({min: ageRange.min, max: ageRange.max, range: true, value: [, ], tooltip: 'hide'});
//        $("#ageSlider .custom-range-slider").attr('data-value', ageRange.min + ',' + ageRange.max);//({min: ageRange.min, max: ageRange.max, range: true, value: [Math.max(ageRange.min, parseInt(currentSelectedAgeRange[0])), Math.min(ageRange.max, parseInt(currentSelectedAgeRange[1]))], tooltip: 'hide'});
        updateSelectionText(currentSelectedAgeRange, selectedGender);
    });

    currentSelectedAgeRange = ranges;
    updateSelectionText(currentSelectedAgeRange, $('#genderSwitch').find('.active').attr('id'));
}

function updateSelectionText(range, gender) {
    var sampleSize = calculateSampleSize(range, gender);
    $('#selectedAgeRange').text(translation.selection + ': ' + translation.of + ' ' + range[0] + ' ' + translation.to + ' ' + range[1] + ' ' + translation.years + ', ' + translation.sampleSize + ': ' + sampleSize);
}

function calculateSampleSize(range, gender) {
    if (gender !== undefined) {
//        console.log(range, gender);
        var count = 0;
        var rawData = getLocalItem(STUDY_PANEL).raw;
        if (rawData && rawData.length > 0) {
            for (var i = 0; i < rawData.length; i++) {
                var age = calculateAge(new Date(parseInt(rawData[i].birthday) * 1000));
//                console.log(age);
                if (age >= range[0] && age <= range[1] && (gender === rawData[i].gender || gender === 'identical')) {
//                    console.log(age + ' age fit', rawData[i].gender);
                    count++;
                }
            }
        }
        return count;
    } else {
        return 'Kein Geschlecht ausgewählt';
    }
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
    study.gender = 'unselected';
    study.ageRange = null;

    if (study.panelSurvey === 'yes') {
        study.gender = $('#genderSwitch').find('.active').attr('id');
        study.ageRange = $('#ageSlider .custom-range-slider').attr('value');
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
        var color = $(item).find('.glyphicon-tag').css('color');
        phases.push({id: id, format: format, color: color});
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
            $(listContainer).append(clone);
            checkCurrentListState(listContainer);
            updateBadges(listContainer, format);
            TweenMax.from(clone, .3, {y: -20, opacity: 0, clearProps: 'all'});
            $(listContainer).trigger('listItemAdded');
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
        $(this).trigger('listItemAdded');
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