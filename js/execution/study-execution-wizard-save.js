var EVENT_STUDY_PHASE_SAVE_SUCCESSFULL = 'studyPhaseSaveSuccessfull';
var EVENT_STUDY_SAVE_SUCCESSFULL = 'studySaveSuccessfull';

function savePhaseStep(id, callback) {
    var phaseStep = getPhaseById(id);
    console.log('save phase step: ', phaseStep.format);
    var data = new Object();
    data.id = phaseStep.id;
    data.format = phaseStep.format;

    switch (phaseStep.format) {
//        case LETTER_OF_ACCEPTANCE:
//            data = getLetterOfAcceptanceFormData(data);
//            break;
//        case THANKS:
//            data = getThanksFormData(data);
//            break;
//        case QUESTIONNAIRE:
//        case GUS_SINGLE_GESTURES:
//        case GUS_MULTIPLE_GESTURES:
//        case SUS:
//        case UEQ:
//            data = getQuestionnaireFormData(data);
//            break;
//        case INTERVIEW:
//            data = getInterviewFormData(data);
//            break;
//        case GESTURE_TRAINING:
//            data = getGestureTrainingFormData(data);
//            break;
//        case SLIDESHOW_GESTURES:
//            data = getGestureSlideshowFormData(data);
//            break;
//        case SLIDESHOW_TRIGGER:
//            data = getTriggerSlideshowFormData(data);
//            break;
        case SCENARIO:
            data = getScenarioFormData(data);
            break;
//        case PHYSICAL_STRESS_TEST:
//            data = getPhysicalStressTestFormData(data);
//            break;
//        case IDENTIFICATION:
//            data = getIdentificationFormData(data);
//            break;
//        case EXPLORATION:
//            data = getExplorationFormData(data);
//            break;
    }

    console.log('save phase step data:', data);

    if (data.endTime) {
        setLocalItem(data.id + '.saveData', data);
        if (callback) {
            callback();
        }
    } else {
        getGMT(function (timestamp) {
            data.endTime = timestamp;
            setLocalItem(data.id + '.saveData', data);

            if (callback) {
                callback();
            }
        });
    }
}

//function getLetterOfAcceptanceFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//    }
//
//    return data;
//}
//
//function getThanksFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//    }
//    return data;
//}
//
//function getInterviewFormData(data) {
//    var questionnaire = $('#viewModerator #phase-content').find('.question-container').children();
//    data.answers = getQuestionnaireAnswers(questionnaire);
//
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.startRecordingTime = tempData.startRecordingTime;
//        data.endRecordingTime = tempData.endRecordingTime;
//        data.recordUrl = tempData.recordUrl;
//        data.answers = tempData.answers;
//        data.annotations = tempData.annotations;
//    }
//    console.log(data);
//    return data;
//}
//
//
//function getGestureTrainingFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.startRecordingTime = tempData.startRecordingTime;
//        data.endRecordingTime = tempData.endRecordingTime;
//        data.recordUrl = tempData.recordUrl;
//        data.startTrainingTime = tempData.startTrainingTime;
//        data.startScreenRecordingTime = tempData.startScreenRecordingTime;
//        data.endScreenRecordingTime = tempData.endScreenRecordingTime;
//        data.screenRecordUrl = tempData.screenRecordUrl;
//        data.annotations = tempData.annotations;
//    }
//    return data;
//}
//
//function getGestureSlideshowFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.startRecordingTime = tempData.startRecordingTime;
//        data.endRecordingTime = tempData.endRecordingTime;
//        data.restarts = tempData.restarts;
//        data.annotations = tempData.annotations;
////        removeLocalItem(data.id + '.tempSaveData');
//    }
//    return data;
//}
//
//function getTriggerSlideshowFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.selectedOptions = tempData.selectedOptions;
//        data.annotations = tempData.annotations;
////        removeLocalItem(data.id + '.tempSaveData');
//    }
//    return data;
//}

function getScenarioFormData(data) {
    var tempData = getLocalItem(data.id + '.tempSaveData');
    if (tempData) {
        data.startTime = tempData.startTime;
        data.startRecordingTime = tempData.startRecordingTime;
        data.endRecordingTime = tempData.endRecordingTime;
        data.recordUrl = tempData.recordUrl;
        data.annotations = tempData.annotations;
        data.startScreenRecordingTime = tempData.startScreenRecordingTime;
        data.endScreenRecordingTime = tempData.endScreenRecordingTime;
        data.screenRecordUrl = tempData.screenRecordUrl;
        data.recordedGestureSimulation = tempData.recordedGestureSimulation || null;
        data = attachSimulationRecording(data);
    }
    return data;
}

//function getPhysicalStressTestFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.startRecordingTime = tempData.startRecordingTime;
//        data.endRecordingTime = tempData.endRecordingTime;
//        data.startStressTestTime = tempData.startStressTestTime;
//        data.annotations = tempData.annotations;
//        data.answers = tempData.answers;
//    }
//    return data;
//}
//
//function getIdentificationFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.startRecordingTime = tempData.startRecordingTime;
//        data.endRecordingTime = tempData.endRecordingTime;
//        data.recordUrl = tempData.recordUrl;
//        data.annotations = tempData.annotations;
//
//        var phaseData = getLocalItem(data.id + '.data');
//        if (phaseData.identificationFor === 'gestures') {
//            data.gestures = tempData.gestures;
//        } else {
//            data.trigger = tempData.trigger;
//        }
//
//        data.startScreenRecordingTime = tempData.startScreenRecordingTime;
//        data.endScreenRecordingTime = tempData.endScreenRecordingTime;
//        data.screenRecordUrl = tempData.screenRecordUrl;
//
////        removeLocalItem(data.id + '.tempSaveData');
//    }
//    return data;
//}
//
//function getExplorationFormData(data) {
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//        data.startRecordingTime = tempData.startRecordingTime;
//        data.endRecordingTime = tempData.endRecordingTime;
//        data.recordUrl = tempData.recordUrl;
//        data.annotations = tempData.annotations;
////        data.transitions = tempData.transitions;
//        data.startScreenRecordingTime = tempData.startScreenRecordingTime;
//        data.endScreenRecordingTime = tempData.endScreenRecordingTime;
//        data.screenRecordUrl = tempData.screenRecordUrl;
//    }
//    return data;
//}
//
//function getQuestionnaireFormData(data) {
////    data.answers = getQuestionnaireAnswers(questionnaire);
//
//    var tempData = getLocalItem(data.id + '.tempSaveData');
//    if (tempData) {
//        data.startTime = tempData.startTime;
//    }
//
//    return data;
//}



function saveCurrentStatus(studyFinished, callback) {
//    console.log('save current wizard status');

    var currentPhaseStepId = getCurrentPhase().id;
    getGMT(function (timestamp) {
        getFinishedStudyPhases(currentPhaseStepId, studyFinished, function (phases) {
            var data = new Object();
            data.studySuccessfull = studyFinished === true ? 'yes' : 'no';
            data.phases = phases;
            data.aborted = getLocalItem(STUDY).aborted;

            if (studyFinished === true) {
                data.endTime = timestamp;
            }

            var study = getLocalItem(STUDY);
            saveExecutionWizard({studyId: study.id, testerId: study.testerId, data: data, evaluatorId: study.evaluatorId}, function (result) {
                console.log('save execution wizard', result, data);
                if (callback) {
                    callback(result);
                }
            });
        });
    });
}

function getFinishedStudyPhases(id, studyFinished, callback) {
    savePhaseStep(id, function () {
        var phaseSteps = getContextualPhaseSteps();
        var array = new Array();
        for (var i = 0; i < phaseSteps.length; i++) {
            if (studyFinished) {
                savePhaseStep(phaseSteps[i].id);
            }

            if (isPhaseStepSaved(phaseSteps[i].id)) {
                array.push(getLocalItem(phaseSteps[i].id + '.saveData'));
            }
        }

        callback(array);
    });
}

function isPhaseStepSaved(id) {
    return getLocalItem(id + '.saveData') !== null ? true : false;
}