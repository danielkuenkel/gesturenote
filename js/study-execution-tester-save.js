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
        data.accepted = tempData.accepted;
//        removeLocalItem(data.id + '.tempSaveData');
    }

    return data;
}

function getThanksFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
//        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getGestureTrainingFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startRecordingTime = tempData.startRecordingTime;
        data.startTrainingTime = tempData.startTrainingTime;
        data.training = tempData.training;
//        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getGestureSlideshowFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startRecordingTime = tempData.startRecordingTime;
        data.restarts = tempData.restarts;
        data.actions = tempData.actions;
//        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getTriggerSlideshowFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.selectedOptions = tempData.selectedOptions;
//        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getScenarioFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startRecordingTime = tempData.startRecordingTime;
        data.actions = tempData.actions;
        data.transitions = tempData.transitions;
//        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getPhysicalStressTestFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startRecordingTime = tempData.startRecordingTime;
        data.startStressTestTime = tempData.startStressTestTime;
        data.actions = tempData.actions;
        data.answers = tempData.answers;
//        removeLocalItem(data.id + '.tempSaveData');
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

//        removeLocalItem(data.id + '.tempSaveData');
    }
    return data;
}

function getQuestionnaireFormData(questionnaire, data) {
    data.answers = getQuestionnaireAnswers(questionnaire);

    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        removeLocalItem(data.id + '.tempSaveData');
    }

    return data;
}



function saveCurrentStatus(studyFinished, callback) {
    var data = new Object();
    data.studySuccessfull = studyFinished === true ? 'yes' : 'no';
    data.phases = getFinishedStudyPhases();
    data.aborted = getLocalItem(STUDY).aborted;

    if (studyFinished === true) {
        data.endTime = new Date().getTime();
        checkRTCUploads();
    }

    var study = getLocalItem(STUDY);
//    if (study.surveyType === TYPE_SURVEY_UNMODERATED) {
        saveExecutionTester({studyId: study.id, data: data}, function (result) {
            if (callback) {
                callback(result);
            }
        });
//    }
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

function checkRTCUploads() {

}