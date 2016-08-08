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
    removeLocalItem(ASSEMBLED_SCENES);
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
    removeLocalItem(ASSEMBLED_FEEDBACK);
}

function getPhaseById(id) {
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    for (var i = 0; i < phaseSteps.length; i++) {
        if (parseInt(phaseSteps[i].id) === parseInt(id)) {
            return phaseSteps[i];
        }
    }
    return null;
}