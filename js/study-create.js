/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentIdForModal;
var colors;
function checkSessionStorage() {
    if (typeof (Storage) !== "undefined") {
        checkAssembledGestures(getLocalItem(ASSEMBLED_GESTURE_SET), getLocalItem(GESTURE_CATALOG));
        createOriginPhases();
        createPredefinedGestureFeedback();
        renderSessionStorageData();
    } else {
        appendAlert($('#mainContent'), ALERT_NO_STORAGE_API);
    }
}

function createOriginPhases() {
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    if (phaseSteps === null || phaseSteps === undefined || (phaseSteps && phaseSteps.length === 0))
    {
        var phases = new Array();
        phases.push({id: chance.natural(), format: LETTER_OF_ACCEPTANCE});//new PhaseItem(chance.natural(), LETTER_OF_ACCEPTANCE, colors.pop()));
        phases.push({id: chance.natural(), format: THANKS});//new PhaseItem(chance.natural(), THANKS, colors.pop()));
        setLocalItem(STUDY_PHASE_STEPS, phases);
        
        setLocalItem(phases[0].id + '.data', translation.placeholderLetterOfAcceptance);
        setLocalItem(phases[1].id + '.data', translation.placeholderThanks);
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
//    renderGenderSwitch();
//    renderAgeRanges();

    var study = getLocalItem(STUDY);
    if (study) {
        $('#panelSurveySwitch').find('#' + study.panelSurvey).click();

        $('#studyTitle').val(study.title);
        $('#studyDescription').val(study.description);
        if (study.phase !== 'unselected') {
            firstInit = false;
            $('#phaseSelect').find('#' + study.phase).click();
        }
//        if (study.surveyMethod !== 'unselected') {
//            firstInit = false;
//            $('#surveyMethodSelect').find('#' + study.surveyMethod).click();
//        }
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

//        if (study.gender !== 'unselected') {
//            $('#genderSwitch').find('#' + study.gender).click();
//        }

//        var studyPanel = getLocalItem(STUDY_PANEL);
//        var ranges = {min: studyPanel.min, max: studyPanel.max};
//        if (study.ageRange && study.ageRange !== '' && studyPanel) {
//            ranges = study.ageRange;
//        }
//        updateSelectionText(ranges, $('#genderSwitch').find('.btn-option-checked').attr('id'));

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
    renderCatalogOverview();
    checkPreviewAvailability();
}

//var currentSelectedAgeRange = null;
function renderAgeRanges() {
    var study = getLocalItem(STUDY);
    var studyPanel = getLocalItem(STUDY_PANEL);
    var selectedGender = $('#genderSwitch').find('.btn-option-checked').attr('id');
    var ranges = calculateAgeRangeForGender(studyPanel.raw, selectedGender);

    if (study) {
        if (study.ageRange && study.ageRange !== undefined && studyPanel) {
            ranges.min = parseInt(study.ageRange.min);
            ranges.max = parseInt(study.ageRange.max);
//            $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, range: true, value: [Math.max(studyPanel.min, parseInt(ranges[0])), Math.min(studyPanel.max, parseInt(ranges[1]))], tooltip: 'hide'});
        } else {

//            $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, range: true, value: [parseInt(ranges[0]), parseInt(ranges[1])], tooltip: 'hide'});
        }
    } else if (studyPanel) {
        ranges.min = parseInt(studyPanel.min);
        ranges.max = parseInt(studyPanel.max);
//        $("#ageSlider .custom-range-slider").slider({min: studyPanel.min, max: studyPanel.max, range: true, value: [parseInt(ranges[0]), parseInt(ranges[1])], tooltip: 'hide'});
    }
    
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
    $('#ageSlider #age-label .age-text').text('(' + translation.atLeastShort + " " + studyPanel.min + ' / ' + translation.maximalShort + ' ' + studyPanel.max + ' ' + translation.years + ')');

//    $('#ageSlider .slider-to').text(translation.to + " " + ' ' + translation.maximal + ' ' + studyPanel.max);

    $('#ageSlider').unbind('slide').bind('slide', function (slideEvt) {
        currentSelectedAgeRange = {min: parseInt(slideEvt.value[0]), max: parseInt(slideEvt.value[1])};
        updateSelectionText(currentSelectedAgeRange, $('#genderSwitch').find('.btn-option-checked').attr('id'));
    });
    $('#ageSlider').on('mouseup', function (event) {
        console.log('age slider clicked');
    });

    $('#genderSwitch').on('change', function () {
        var selectedGender = $('#genderSwitch').find('.btn-option-checked').attr('id');
        var ageRange = calculateAgeRangeForGender(studyPanel.raw, selectedGender);
        slider.setAttribute('min', ageRange.min);
        slider.setAttribute('max', ageRange.max);
        slider.refresh();
        $('#ageSlider #age-label .age-text').text('(' + translation.atLeastShort + " " + ageRange.min + ' / ' + translation.maximalShort + ' ' + ageRange.max + ' ' + translation.years + ')');

        var savedRange = getLocalItem(STUDY).ageRange;
//        console.log(slider.getAttribute('min'), slider.getAttribute('max'));

//        $('#ageSlider .slider-from').text(translation.of + ' ' + translation.atLeast + " " + ageRange.min);
//        $('#ageSlider .slider-to').text(translation.to + " " + ' ' + translation.maximal + ' ' + ageRange.max);
        currentSelectedAgeRange = {min: Math.max(ageRange.min, savedRange.min), max: Math.min(ageRange.max, savedRange.max)};
//        currentSelectedAgeRange = {min: ageRange.min, max: ageRange.max};
        slider.setAttribute('value', [currentSelectedAgeRange.min, currentSelectedAgeRange.max]);
        slider.refresh();
        updateSelectionText(currentSelectedAgeRange, selectedGender);
        saveGeneralData();
    });

    currentSelectedAgeRange = ranges;
    updateSelectionText(currentSelectedAgeRange, $('#genderSwitch').find('.btn-option-checked').attr('id'));
}

function updateSelectionText(range, gender) {
//    console.log(range, gender);
    var sampleSize = calculateSampleSize(range, gender);
    $('#ageSlider .slider-from').text(range.min);
    $('#ageSlider .slider-to').text(range.max);
    $('#selectedAgeRange .text').text(translation.of + ' ' + range.min + ' ' + translation.to + ' ' + range.max + ' ' + translation.years + ', ' + translation.sampleSize + ': ' + sampleSize);
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
                if (age >= parseInt(range.min) && age <= parseInt(range.max) && (gender === rawData[i].gender || gender === 'identical')) {
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
            addPhaseStep(item.id, item.format, item.title);
        }

        if (getLocalItem(STUDY) && getLocalItem(STUDY).phase) {
            if (getLocalItem(STUDY).phase === TYPE_PHASE_ELICITATION) {
                $('#phaseStepList').find('.' + TYPE_PHASE_ELICITATION).removeClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_EVALUATION).addClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_EXTRACTION).addClass('hidden');
            } else if (getLocalItem(STUDY).phase === TYPE_PHASE_EVALUATION) {
                $('#phaseStepList').find('.' + TYPE_PHASE_EVALUATION).removeClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_ELICITATION).addClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_EXTRACTION).addClass('hidden');
            } else if (getLocalItem(STUDY).phase === TYPE_PHASE_EXTRACTION) {
                $('#phaseStepList').find('.' + TYPE_PHASE_EXTRACTION).removeClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_ELICITATION).addClass('hidden');
                $('#phaseStepList').find('.' + TYPE_PHASE_EVALUATION).addClass('hidden');
            } else {
                $('#phaseStepList').find('.both').removeClass('hidden');
            }
        }
    }
}

function renderCatalogOverview() {
    updateCatalogButtons();

    var studyGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    $('#gestures-catalog').find('#gestures-list-container').empty();
    if (studyGestures && studyGestures.length > 0) {
        clearAlerts($('#gestures-catalog'));
        renderStudyGestures(studyGestures, true);
    } else {
        appendAlert($('#gestures-catalog'), ALERT_NO_PHASE_DATA);
    }

    var studyTrigger = getLocalItem(ASSEMBLED_TRIGGER);
    $('#trigger-catalog').find('.list-container').empty();
    if (studyTrigger && studyTrigger.length > 0) {
        clearAlerts($('#trigger-catalog'));
        renderStudyTrigger(studyTrigger);
    } else {
        appendAlert($('#trigger-catalog'), ALERT_NO_PHASE_DATA);
    }

    var studyFeedback = getLocalItem(ASSEMBLED_FEEDBACK);
    $('#feedback-catalog').find('.list-container').empty();
    if (studyFeedback && studyFeedback.length > 0) {
        clearAlerts($('#feedback-catalog'));
        renderStudyFeedback(studyFeedback);
    } else {
        appendAlert($('#feedback-catalog'), ALERT_NO_PHASE_DATA);
    }

    var studyScenes = getLocalItem(ASSEMBLED_SCENES);
    $('#scenes-catalog').find('.list-container').empty();
    if (studyScenes && studyScenes.length > 0) {
        clearAlerts($('#scenes-catalog'));
        renderStudyScenes(studyScenes);
    } else {
        appendAlert($('#scenes-catalog'), ALERT_NO_PHASE_DATA);
    }
}

function renderStudyGestures(gestures, animate) {
    $('#gestures-catalog').find('#gestures-list-container').empty();
    if (gestures && gestures.length > 0) {
        $('#gestures-catalog').find('#btn-download-as-json').removeClass('disabled');
        for (var i = 0; i < gestures.length; i++) {
            var gesture = getGestureById(gestures[i]);
            var clone = getCreateStudyGestureListThumbnail(gesture, 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-sm-4 col-md-4 col-lg-3');
            
            $('#gestures-catalog').find('#gestures-list-container').append(clone);
            if (animate && animate === true) {
                TweenMax.from(clone, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
            }
        }
    } else {
        appendAlert($('#gestures-catalog'), ALERT_NO_PHASE_DATA);
        $('#gestures-catalog').find('#btn-download-as-json').addClass('disabled');
    }

    $('#gestures-catalog').find('#gestures-list-container').unbind('change').bind('change', function (event, gestureId, assemble) {
        TweenMax.to($(event.target).closest('.root'), .2, {scale: 0, opacity: 0, clearProps: 'all', ease: Quad.easeIn, onComplete: function () {
                reassembleGesture(gestureId);
                updateCatalogButtons();
                renderStudyGestures(getLocalItem(ASSEMBLED_GESTURE_SET), false);
            }
        });
    });
    
    initPopover();
    initTooltips();
}

function renderStudyTrigger(trigger) {
    for (var i = 0; i < trigger.length; i++) {
        var item = $('#template-study-container').find('#trigger-catalog-thumbnail').clone().removeAttr('id');
        item.text(trigger[i].title);
        $('#trigger-catalog').find('.list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}

function renderStudyFeedback(feedback) {
    for (var i = 0; i < feedback.length; i++) {
        var item = $('#template-study-container').find('#feedback-catalog-thumbnail').clone().removeAttr('id');
        item.find('.text').text(feedback[i].title);
        item.find('#' + feedback[i].type).removeClass('hidden');
        if (feedback[i].type === TYPE_FEEDBACK_SOUND && feedback[i].parameters && feedback[i].parameters.url) {
            item.find('.audio-holder').attr('src', feedback[i].parameters.url);
        }
        $('#feedback-catalog').find('.list-container').append(item);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
    }
}

function renderStudyScenes(scenes) {
    for (var i = 0; i < scenes.length; i++) {
        var item = $('#template-study-container').find('#scenes-catalog-thumbnail').clone().removeAttr('id');
        item.find('.text').text(scenes[i].title);
        item.find('.label-text').text(translation.sceneTypes[scenes[i].type]);
        item.find('#' + scenes[i].type).removeClass('hidden');
        $('#scenes-catalog').find('.list-container').append(item);
//        console.log(scenes[i]);
        TweenMax.from(item, .2, {delay: i * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
        $(item).find('#btn-preview-scene').click({sceneId: scenes[i].id}, function (event) {
            event.preventDefault();
            currentSceneId = event.data.sceneId;
            loadHTMLintoModal('custom-modal', 'modal-scene.php', 'modal-lg');
        });
    }
}

function renderOverlayTitle(id, target, input) {
    var currentPhaseData = getPhaseById(id);
    if (currentPhaseData.title) {
        $(target).find('#phase-step-title').text(currentPhaseData.title);
    } else {
        $(target).find('#phase-step-title').text(translation.formats[currentPhaseData.format].text);
    }

    $(target).unbind('click').bind('click', function (event) {
        $(target).addClass('hidden');
        $(input).find('#phase-step-title-input').val($(target).find('#phase-step-title').text());
        $(input).removeClass('hidden');
    });

    $(input).find('#btn-save-phase-step-title').unbind('click').bind('click', function (event) {
        $(input).addClass('hidden');
        $(target).removeClass('hidden');
        updatePhaseStepTitle(id, input);
        var currentPhaseData = getPhaseById(id);
        $(target).find('#phase-step-title').text(currentPhaseData.title);
    });
}

function updatePhaseStepTitle(phaseStepId, inputContainer, target) {
    var title = $(inputContainer).find('#phase-step-title-input').val();
    if (title && title.trim().length > 0) {
        var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
        for (var i = 0; i < phaseSteps.length; i++) {
            if (parseInt(phaseStepId) === parseInt(phaseSteps[i].id)) {
                phaseSteps[i].title = title.trim();
                break;
            }
        }
        setLocalItem(STUDY_PHASE_STEPS, phaseSteps);
        renderPhaseSteps();
    } else {

    }
}

function updateCatalogButtons() {
//    console.log('update catalog buttons', $('#gestures-catalog .btn-open-overlay .btn-text'));
    var gestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (gestures && gestures.length > 0) {
        $('#gestures-catalog .btn-open-overlay .btn-text').text(translation.openSet);
        $('#gestures-catalog .btn-open-overlay .fa').removeClass('fa-pencil').addClass('fa-folder-open');
//        $('#btn-clear-study-gestures').removeClass('hidden');
    } else {
        $('#gestures-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
        $('#gestures-catalog .btn-open-overlay .fa').removeClass('fa-folder-open').addClass('fa-pencil');
//        $('#btn-clear-study-gestures').addClass('hidden');
    }

    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    if (feedback && feedback.length > 0) {
//        $('#btn-clear-feedback').removeClass('hidden');
        $('#feedback-catalog .btn-open-overlay .btn-text').text(translation.openSet);
        $('#feedback-catalog .btn-open-overlay .fa').removeClass('fa-pencil').addClass('fa-folder-open');
    } else {
//        $('#btn-clear-feedback').addClass('hidden');
        $('#feedback-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
        $('#feedback-catalog .btn-open-overlay .fa').removeClass('fa-folder-open').addClass('fa-pencil');
    }

    var trigger = getLocalItem(ASSEMBLED_TRIGGER);
    if (trigger && trigger.length > 0) {
//        $('#btn-clear-trigger').removeClass('hidden');
        $('#trigger-catalog .btn-open-overlay .btn-text').text(translation.openSet);
        $('#trigger-catalog .btn-open-overlay .fa').removeClass('fa-pencil').addClass('fa-folder-open');
    } else {
//        $('#btn-clear-trigger').addClass('hidden');
        $('#trigger-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
        $('#trigger-catalog .btn-open-overlay .fa').removeClass('fa-folder-open').addClass('fa-pencil');
    }

    var scenes = getLocalItem(ASSEMBLED_SCENES);
    if (scenes && scenes.length > 0) {
//        $('#btn-clear-scenes').removeClass('hidden');
        $('#scenes-catalog .btn-open-overlay .btn-open-overlay .btn-text').text(translation.openSet);
        $('#scenes-catalog .btn-open-overlay .fa').removeClass('fa-pencil').addClass('fa-folder-open');
    } else {
//        $('#btn-clear-scenes').addClass('hidden');
        $('#scenes-catalog .btn-open-overlay .btn-text').text(translation.arrangeSet);
        $('#scenes-catalog .btn-open-overlay .fa').removeClass('fa-folder-open').addClass('fa-pencil');
    }
}

function saveGeneralData() {
    var study = new Object();
    study.title = $('#studyTitle').val();
    study.description = $('#studyDescription').val();
    study.phase = $('#phaseSelect .btn-option-checked').attr('id');
//    study.surveyMethod = $('#surveyMethodSelect .btn-option-checked').attr('id');
    study.surveyType = $('#surveyTypeSelect .btn-option-checked').attr('id');
//    study.recordType = $('#recordSelect .chosen').attr('id');
//    study.panelSurvey = $('#panelSurveySwitch').find('.btn-option-checked').attr('id');
//    study.gender = 'unselected';
//    study.ageRange = null;

//    console.log('save general data', study);

////    if (study.panelSurvey === 'yes') {
////        study.gender = $('#genderSwitch').find('.btn-option-checked').attr('id');
////        var ageRange = $('#ageSlider .custom-range-slider').attr('value');
////        study.ageRange = {min: ageRange.split(',')[0], max: ageRange.split(',')[1]};
////    }
//
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
        var format = $(item).find('.btn-open-overlay').attr('id');
        var title = $(item).find('.phase-step-format').text();
        phases.push({id: id, format: format, title: title});
    }
    setLocalItem(STUDY_PHASE_STEPS, phases);
}

function getPhaseById(id) {
    var phases = getLocalItem(STUDY_PHASE_STEPS);
    if (phases && phases.length > 0) {
        for (var i = 0; i < phases.length; i++) {
            if (parseInt(id) === parseInt(phases[i].id)) {
                return phases[i];
            }
        }
    }
    return null;
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
            clone.attr('name', chance.natural());
            var listContainer = $(this).closest('.root').find('#list-container');
            $(listContainer).append(clone);
            checkCurrentListState(listContainer);
            updateBadges(listContainer, format);
            TweenMax.from(clone, .3, {y: -20, opacity: 0, clearProps: 'all'});
            $(listContainer).trigger('listItemAdded');
        }
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