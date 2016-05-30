/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function setLocalItem(id, data) {
    localStorage.setItem(id, JSON.stringify(data));
}

function getLocalItem(id) {
    if (localStorage.getItem(id) !== null) {
        return JSON.parse(localStorage.getItem(id));
    } else {
        return null;
    }
}

function removeLocalItem(id) {
    localStorage.removeItem(id);
}

function clearLocalItems() {
    localStorage.clear();
}

function LocalStorageAlternative() {

    var structureLocalStorage = {};

    this.setItem = function (key, value) {
        structureLocalStorage[key] = value;
    };

    this.getItem = function (key) {
        if (typeof structureLocalStorage[key] !== 'undefined') {
            return structureLocalStorage[key];
        } else {
            return null;
        }
    };

    this.removeItem = function (key) {
        structureLocalStorage[key] = undefined;
    };

    this.clear = function () {
        structureLocalStorage = {};
    };
}

function getGestureById(id) {
    var predefinedGestures = getLocalItem(PREDEFINED_GESTURE_SET);
    for (var i = 0; i < predefinedGestures.length; i++) {
        if (parseInt(predefinedGestures[i].id) === parseInt(id)) {
            return predefinedGestures[i];
        }
    }
    return null;
}

function getSceneById(id) {
    var prototypes = getLocalItem(ASSEMBLED_PROTOTYPES);
    for (var i = 0; i < prototypes.length; i++) {
        if (parseInt(prototypes[i].id) === parseInt(id)) {
            return prototypes[i];
        }
    }
    return null;
}