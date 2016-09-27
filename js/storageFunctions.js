/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getGestureById(id) {
    var predefinedGestures = getLocalItem(GESTURE_CATALOG);
    if (predefinedGestures && predefinedGestures.length > 0) {
        for (var i = 0; i < predefinedGestures.length; i++) {
            if (parseInt(predefinedGestures[i].id) === parseInt(id)) {
                return predefinedGestures[i];
            }
        }
    }
    return null;
}

function assembledGestures() {
    var catalog = getLocalItem(GESTURE_CATALOG);

    if (catalog === null) {
        getGestureCatalog();
    }

    var gestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (gestures && gestures.length > 0) {
        var arrangedGestures = new Array();
        for (var i = 0; i < gestures.length; i++) {
            arrangedGestures.push(getGestureById(gestures[i]));
        }
        if (arrangedGestures.length > 0) {
            return arrangedGestures;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function assembleGesture(id) {
    var aGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (aGestures) {
        aGestures.push(id);
    } else {
        aGestures = new Array();
        aGestures.push(id);
    }
    setLocalItem(ASSEMBLED_GESTURE_SET, aGestures);
}

function isGestureAssembled(id) {
    var aGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (aGestures && aGestures.length > 0) {
        for (var i = 0; i < aGestures.length; i++) {
            if (parseInt(aGestures[i]) === parseInt(id)) {
                return true;
            }
        }
    }

    return false;
}

function reassembleGesture(id) {
    var aGestures = getLocalItem(ASSEMBLED_GESTURE_SET);
    if (aGestures && aGestures.length > 0) {
        for (var i = 0; i < aGestures.length; i++) {
            if (parseInt(aGestures[i]) === parseInt(id)) {
                aGestures.splice(i, 1);
            }
        }
    }
    setLocalItem(ASSEMBLED_GESTURE_SET, aGestures);
}

function removeAssembledGestures() {
    removeLocalItem(ASSEMBLED_GESTURE_SET);
}

function checkAssembledGestures(gestures, gestureCatalog) {
    if (gestures && gestures.length > 0 && gestureCatalog && gestureCatalog.length > 0) {
        var gesturesForReassembling = new Array();
        for (var i = 0; i < gestures.length; i++) {
            var gestureInDB = false;
            for (var j = 0; j < gestureCatalog.length; j++) {
                if (parseInt(gestures[i]) === parseInt(gestureCatalog[j].id)) {
                    gestureInDB = true;
                }
            }

            if (gestureInDB === false) {
                gesturesForReassembling.push(gestures[i]);
            }
        }

        for (var k = 0; k < gesturesForReassembling.length; k++) {
            reassembleGesture(gesturesForReassembling[k]);
        }
    }
}

function updateGestureById(id, parameters) {
    var gestureCatalog = getLocalItem(GESTURE_CATALOG);

    var gesture;
    var tempGestures = new Array();

    if (gestureCatalog && gestureCatalog.length > 0) {
        for (var i = 0; i < gestureCatalog.length; i++) {
            gesture = gestureCatalog[i];

            if (parseInt(gesture.id) === parseInt(id)) {
                for (var key in parameters) {
                    gesture[key] = parameters[key];
                }
                console.log(gesture);
            }

            tempGestures.push(gesture);
        }
        setLocalItem(GESTURE_CATALOG, tempGestures);
    }

//    var elicitedGestures = getLocalItem(ELICITED_GESTURES);
//    if (elicitedGestures && elicitedGestures.length > 0) {
//        tempGestures = new Array();
//        for (var i = 0; i < elicitedGestures.length; i++) {
//            gesture = elicitedGestures[i];
//            if (parseInt(gesture.id) === parseInt(id)) {
////                console.log(gesture);
//                for (var key in parameters) {
//                    gesture[key] = parameters[key];
////                    console.log(gesture);
//                }
//            }
//            tempGestures.push(gesture);
//        }
//        setLocalItem(ELICITED_GESTURES, tempGestures);
//    }
}




function getTriggerById(id) {
    var triggers = getLocalItem(ASSEMBLED_TRIGGER);
    if (triggers) {
        for (var i = 0; i < triggers.length; i++) {
            if (parseInt(triggers[i].id) === parseInt(id)) {
                return triggers[i];
            }
        }
    }
    return null;
}

function removeAssembledTrigger() {
    removeLocalItem(ASSEMBLED_TRIGGER);
}

function getSceneById(id) {
    var scenes = getLocalItem(ASSEMBLED_SCENES);
    if (scenes && scenes.length > 0) {
        for (var i = 0; i < scenes.length; i++) {
            if (parseInt(scenes[i].id) === parseInt(id)) {
                return scenes[i];
            }
        }
    }
    return null;
}

function removeAssembledScenes() {
    clearSceneImages();
    removeLocalItem(ASSEMBLED_SCENES);
}

function clearSceneImages() {
    var scenes = getLocalItem(ASSEMBLED_SCENES);
    if (scenes && scenes.length > 0) {
        var imageUrls = new Array();
        for (var i = 0; i < scenes.length; i++) {
            if (scenes[i].type === SCENE_IMAGE) {
                imageUrls.push("../" + scenes[i].data);
            }
        }
        deleteSceneImage({image: imageUrls});
    }
}

function getFeedbackById(id) {
    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    if (feedback !== null) {
        for (var i = 0; i < feedback.length; i++) {
            if (parseInt(feedback[i].id) === parseInt(id)) {
                return feedback[i];
            }
        }
    }
    return null;
}

function removeAssembledFeedback() {
    clearSounds();
    removeLocalItem(ASSEMBLED_FEEDBACK);
}

function clearSounds() {
    var feedback = getLocalItem(ASSEMBLED_FEEDBACK);
    if (feedback && feedback.length > 0) {
        var urls = new Array();
        for (var i = 0; i < feedback.length; i++) {
            if (feedback[i].type === TYPE_FEEDBACK_SOUND) {
                urls.push("../" + feedback[i].data);
            }
        }
        deleteSound({sound: urls});
    }
}

function getPhaseById(id) {
    var phaseSteps = getLocalItem(STUDY_PHASE_STEPS);
    for (var i = 0; i < phaseSteps.length; i++) {
        if (parseInt(phaseSteps[i].id) === parseInt(id)) {
            return phaseSteps[i];
        }
    }
    return null;
}

function getStudyData() {
    var data = new Object();
    data.generalData = getLocalItem(STUDY);

    var phases = getContextualPhaseSteps();
    if (phases && phases.length > 0) {
        data.phases = phases;
        for (var i = 0; i < phases.length; i++) {
            data[phases[i].id] = getLocalItem(phases[i].id + '.data');
        }
    }

    if (getLocalItem(ASSEMBLED_SCENES) && data.generalData.phase === TYPE_PHASE_EVALUATION) {
        data.assembledScenes = getLocalItem(ASSEMBLED_SCENES);
    }

    if (getLocalItem(ASSEMBLED_GESTURE_SET)) {
        data.assembledGestureSet = getLocalItem(ASSEMBLED_GESTURE_SET);
    }

    if (getLocalItem(ASSEMBLED_TRIGGER)) {
        data.assembledTrigger = getLocalItem(ASSEMBLED_TRIGGER);
    }

    if (getLocalItem(ASSEMBLED_FEEDBACK) && data.generalData.phase === TYPE_PHASE_EVALUATION) {
        data.assembledFeedback = getLocalItem(ASSEMBLED_FEEDBACK);
    }

    return {data: data};
}


function getContextualPhaseSteps() {
    var phases = getLocalItem(STUDY_PHASE_STEPS);
    if (phases && phases.length > 0) {
        var realPhases = new Array();
        var generalData = getLocalItem(STUDY);
        for (var i = 0; i < phases.length; i++) {
            var phaseFormat = phases[i].format;
            if (generalData.phase === translation.formats[phaseFormat].class || translation.formats[phaseFormat].class === 'both') {
                realPhases.push(phases[i]);
            }
        }
        return realPhases;
    }
    return null;
}

function setStudyData(data) {
    clearLocalItems();

    var setData;
    if (data.studyData) {
        setData = data.studyData;
        setData.generalData.studyOwner = data.userId;
        setData.generalData.id = data.id;
        setData.generalData.urlToken = data.urlToken;
        setLocalItem(STUDY, setData.generalData);

        if (setData.phases && setData.phases.length > 0) {
            setLocalItem(STUDY_PHASE_STEPS, setData.phases);
            for (var i = 0; i < setData.phases.length; i++) {

                var phaseStepId = setData.phases[i].id;
                setLocalItem(phaseStepId + '.data', setData[phaseStepId]);
            }
        }

        if (setData.assembledScenes) {
            setLocalItem(ASSEMBLED_SCENES, setData.assembledScenes);
        }

        if (setData.assembledGestureSet) {
            setLocalItem(ASSEMBLED_GESTURE_SET, setData.assembledGestureSet);
        }

        if (setData.assembledTrigger) {
            setLocalItem(ASSEMBLED_TRIGGER, setData.assembledTrigger);
        }

        if (setData.assembledFeedback) {
            setLocalItem(ASSEMBLED_FEEDBACK, setData.assembledFeedback);
        }
    }

    if (data.gestureCatalog) {
        setLocalItem(GESTURE_CATALOG, data.gestureCatalog);
    }

    if (data.resultData) {
//        console.log(data.resultData);

        setData = new Object();
        setData.id = data.resultData.id;
        setData.userId = data.resultData.userId;
        setData.created = data.resultData.created;
        setData.executionSuccess = data.resultData.results.studySuccessfull;
        setLocalItem(STUDY_RESULTS, setData);

        var phases = data.resultData.results.phases;
        if (phases && phases.length > 0) {
            for (var i = 0; i < phases.length; i++) {
                setLocalItem(phases[i].id + '.results', phases[i]);
            }
        }

        if (data.resultData.elicitedGestures && data.resultData.elicitedGestures.length > 0) {
            setLocalItem(GESTURE_CATALOG, data.resultData.elicitedGestures);
        }
    }

    if (data.evaluatorData) {
        setData = new Object();
        setData.id = data.evaluatorData.id;
        setData.evaluatorId = data.evaluatorData.evaluatorId;
        setData.testerId = data.evaluatorData.testerId;
        setData.created = data.evaluatorData.created;
        setLocalItem(STUDY_DATA_EVALUATOR, setData);

        if (data.evaluatorData.results && data.evaluatorData.phases) {
            var phases = data.evaluatorData.results.phases;
            if (phases && phases.length > 0) {
                for (var i = 0; i < phases.length; i++) {
                    setLocalItem(phases[i].id + '.evaluator', phases[i]);
                }
            }
        }

        var notes = data.evaluatorData.notes;
        if (notes && notes.length > 0) {
            for (var i = 0; i < notes.length; i++) {
                setLocalItem(notes[i].phaseId + '.notes', notes[i].note);
            }
        }
    }
}