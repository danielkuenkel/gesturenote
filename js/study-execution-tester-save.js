var EVENT_STUDY_PHASE_SAVE_SUCCESSFULL = 'studyPhaseSaveSuccessfull';
var EVENT_STUDY_SAVE_SUCCESSFULL = 'studySaveSuccessfull';

function savePhaseStep() {
    var currentPhase = getCurrentPhase();
//    console.log(currentPhase);
    var data = new Object();
    data.id = currentPhase.id;
    data.format = currentPhase.format;
    console.log('save ' + currentPhase.format);
    switch (currentPhase.format) {
        case LETTER_OF_ACCEPTANCE:
            data = getLetterOfAcceptanceFormData(data);
            break;
        case THANKS:
            data = getThanksFormData(data);
            break;
        case QUESTIONNAIRE:
            var questionnaire = $('#viewTester #phase-content').find('.question-container').children();
            data = getQuestionnaireFormData(questionnaire, data);
            break;
        case GUS_SINGLE_GESTURES:
            var questionnaire = $('#viewTester #phase-content').find('.question-container').children();
            data = getQuestionnaireFormData(questionnaire, data);
            break;
        case GUS_MULTIPLE_GESTURES:
            var questionnaire = $('#viewTester #phase-content').find('.question-container').children();
            data = getQuestionnaireFormData(questionnaire, data);
            break;
        case SUS:
            var questionnaire = $('#viewTester #phase-content').find('.question-container').children();
            data = getQuestionnaireFormData(questionnaire, data);
            break;
        case GESTURE_TRAINING:
            data = getGestureTrainingFormData(data);
            break;
        case SLIDESHOW_GESTURES:
            data = getGestureSlideshowFormData(data);
            break;
        case SLIDESHOW_TRIGGER:
            data = getTriggerSlideshowFormData(data);
            break;
        case SCENARIO:
            data = getScenarioFormData(data);
            break;
        case PHYSICAL_STRESS_TEST:
            data = getPhysicalStressTestFormData(data);
            break;
        case IDENTIFICATION:
            data = getIdentificationFormData(data);
            break;
    }

    data.endTime = new Date().getTime();
    setLocalItem(data.id + '.saveData', data);
}

function getLetterOfAcceptanceFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        removeLocalItem(data.id + '.tempSaveData');
    }
    data.accepted = 'yes';
    return data;
}

function getThanksFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getGestureTrainingFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startTrainingTime = tempData.startTrainingTime;
        data.training = tempData.training;
        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getGestureSlideshowFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.restarts = tempData.restarts;
        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getTriggerSlideshowFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.selectedOptions = tempData.selectedOptions;
        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getScenarioFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.actions = tempData.actions;
        data.transitions = tempData.transitions;
        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getPhysicalStressTestFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startStressTestTime = tempData.startStressTestTime;
        data.stressTest = tempData.stressTest;
        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getIdentificationFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');

    if (tempData) {
        data.startTime = tempData.startTime;
        var phaseData = getLocalItem(data.id + '.data');
        if (phaseData.identificationFor === 'gestures') {
            data.gestures = tempData.gestures;
        } else {
            data.trigger = tempData.trigger;
        }

        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}



function getQuestionnaireFormData(questionnaire, data) {
    var questionnaireAnswers = new Array();
    for (var i = 0; i < questionnaire.length; i++) {
        var format = $(questionnaire[i]).attr('id');
        console.log('getQuestionnaireFormData: ' + format);
        switch (format) {
            case COUNTER:
                questionnaireAnswers.push(getCounterFormData($(questionnaire[i])));
                break;
            case OPEN_QUESTION:
            case OPEN_QUESTION_GUS:
                questionnaireAnswers.push(getOpenQuestionFormData($(questionnaire[i])));
                break;
            case DICHOTOMOUS_QUESTION:
            case DICHOTOMOUS_QUESTION_GUS:
                questionnaireAnswers.push(getDichotomousQuestionFormData($(questionnaire[i])));
                break;
            case GROUPING_QUESTION:
                questionnaireAnswers.push(getGroupingQuestionFormData($(questionnaire[i])));
                break;
            case GROUPING_QUESTION_GUS:
                questionnaireAnswers.push(getGroupingQuestionGUSFormData($(questionnaire[i])));
                break;
            case RATING:
                questionnaireAnswers.push(getRatingFormData($(questionnaire[i])));
                break;
            case SUM_QUESTION:
                questionnaireAnswers.push(getSumQuestionFormData($(questionnaire[i])));
                break;
            case RANKING:
                questionnaireAnswers.push(getRankingFormData($(questionnaire[i])));
                break;
            case ALTERNATIVE_QUESTION:
                questionnaireAnswers.push(getAlternativeQuestionFormData($(questionnaire[i])));
                break;
            case GUS_SINGLE:
                questionnaireAnswers.push(getSingleGUSFormData($(questionnaire[i])));
                break;
            case SUS_ITEM:
                questionnaireAnswers.push(getSingleGUSFormData($(questionnaire[i])));
                break;
            case 'human-body-selection-rating':
                console.log('human-body-selection-rating');
                break;
            case 'hand-selection-rating':
                console.log('hand-selection-rating');
                break;
        }
    }
    data.answers = questionnaireAnswers;

    console.log(questionnaireAnswers);

    var tempData = getLocalItem(data.id + '.tempSaveData');
    console.log(tempData);
    if (tempData) {
        data.startTime = tempData.startTime;
        removeLocalItem(data.id + '.tempSaveData');
    }

    return data;
}

function getCounterFormData(source) {
    return {count: $(source).find('.stepper-text').val()};
}

function getOpenQuestionFormData(source) {
    return {openAnswer: $(source).find('#openQuestionInput').val()};
}

function getDichotomousQuestionFormData(source) {
    var data = new Object();
    data.selectedSwitch = $(source).find('.switch .active').attr('id') === undefined ? 'none' : $(source).find('.switch .active').attr('id');
    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }
    return data;
}

function getGroupingQuestionFormData(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push(i);
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();
    return data;
}

function getGroupingQuestionGUSFormData(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push($(selectedOptions[i]).find('.option-text').attr('id'));
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();

    var justificationInput = $(source).find('#justificationInput');
    if (justificationInput && justificationInput.length > 0) {
        data.justification = $(source).find('#justificationInput').val();
    } else {
        data.justification = '';
    }

    return data;
}

function getRatingFormData(source) {
    var data = new Object();
    var array = new Array();
    var scalesContainer = $(source).find('.scales-container');
    for (var i = 0; i < scalesContainer.length; i++) {
        array.push($(scalesContainer[i]).find('.btn-option-checked').closest('.btn-group').index() >> 1);
    }
    data.scales = array;
    return data;
}

function getSumQuestionFormData(source) {
    var data = new Object();
    var array = new Array();
    var sumOptions = $(source).find('.option-container').children();
    for (var i = 0; i < sumOptions.length; i++) {
        array.push($(sumOptions[i]).find('.stepper-text').val());
    }
    data.sumCounts = array;
    return data;
}

function getRankingFormData(source) {
    var data = new Object();
    var items = $(source).find('.option-container').children();
    var array = new Array();
    for (var i = 0; i < items.length; i++) {
        array.push($(items[i]).attr('id'));
    }
    data.arrangement = array;
    return data;
}

function getAlternativeQuestionFormData(source) {
    var data = new Object();
    var selectedOptions = $(source).find('.option-container .btn-option-checked');
    var array = new Array();
    for (var i = 0; i < selectedOptions.length; i++) {
        if ($(selectedOptions[i]).parent().attr('id') !== 'checkbox-optionalanswer') {
            array.push($(selectedOptions[i]).find('.option-text').attr('id'));
        }
    }
    data.selectedOptions = array;
    data.optionalAnswer = $(source).find('.optionalInput').val();
    data.justification = $(source).find('#justificationInput').val();
    return data;
}

function getSingleGUSFormData(source) {
    return {selectedOption: $(source).find('.option-container .btn-option-checked').closest('.btn-group').index() >> 1};
}



function saveCurrentStatus(studyFinished, callback) {
    var data = new Object();
    data.studySuccessfull = studyFinished === true ? 'yes' : 'no';
    data.phases = getFinishedStudyPhases();

    var study = getLocalItem(STUDY);
    if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
        saveExecutionTester({studyId: study.id, data: data}, function (result) {
            if (callback) {
                callback(result);
            }
        });
    }
}

function getFinishedStudyPhases() {
    savePhaseStep();

    var phaseSteps = getContextualPhaseSteps();
    var array = new Array();
    for (var i = 0; i < phaseSteps.length; i++) {
        if (isPhaseStepSaved(phaseSteps[i].id)) {
            array.push(getLocalItem(phaseSteps[i].id + '.saveData'));
        }
    }
    return array;
}

function isPhaseStepSaved(id) {
    return getLocalItem(id + '.saveData') !== null ? true : false;
}