/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getGestureById(id) {
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id)) {
            return predefinedGestures[i];
        }
    }
    return null;
}

function getGestureThumbnailImagesForId(type, id) {
    var data = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < data.length; i++) {
        if (type === data[i].type && id === data[i].id) {
            return data[i].images;
        }
    }
}

function getGestureThumbnailPreviewForId(type, id) {
    var data = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < data.length; i++) {
        if (type === data[i].type && id === data[i].id) {
            return data[i].previewImage;
        }
    }
}

function assembledGestures() {
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
    if (predefinedGestures) {

        var arrangedGestures = new Array();
        for (var i = 0; i < predefinedGestures.length; i++) {
            if (predefinedGestures[i].used === true) {
                arrangedGestures.push(predefinedGestures[i]);
            }
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

function isGestureAssembled(id) {
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id) && predefinedGestures[i].used === true) {
            return true;
        }
    }
    return false;
}

function removeAssembledGestures() {
    console.log("remove assembled gestures");
    var phaseSteps = getLocalItem(PROJECT_PHASE_STEPS);
    if (phaseSteps && phaseSteps.length > 0) {
        for (var i = 0; i < phaseSteps.length; i++) {
            var data = getLocalItem(phaseSteps[i].id + ".data");
            if (data && (phaseSteps[i].selectedId === 'scenario' || phaseSteps[i].selectedId === 'gestureTraining')) {
                var scenario = new Scenario();
                scenario.title = data.title;
                scenario.description = data.description;
                scenario.help = data.help;
                scenario.observations = data.observations;
                setLocalItem(phaseSteps[i].id + ".data", scenario);
            }
        }
    }
    removeLocalItem(PREDEFINED_GESTURE_SET);
    createPredefinedGestures();
}

function getFeedbackById(id) {
    var feedback = getLocalItem(PREDEFINED_GESTURE_FEEDBACK);
    if (feedback !== null) {
        for (var i = 0; i < feedback.length; i++) {
            if (parseInt(feedback[i].id) === parseInt(id)) {
                return feedback[i];
            }
        }
    }
    return null;
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

function getPrototypeById(id) {
    var prototypes = getLocalItem(ASSEMBLED_PROTOTYPES);
    if (prototypes && prototypes.length > 0) {
        for (var i = 0; i < prototypes.length; i++) {
            if (parseInt(prototypes[i].id) === parseInt(id)) {
                return prototypes[i];
            }
        }
    }
    return null;
}

function removeAssembledPrototypes() {
    removeLocalItem(ASSEMBLED_PROTOTYPES);
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