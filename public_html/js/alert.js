/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// alert constants
var ALERT_NO_WEBSOCKETS = 'no-websockets';
var ALERT_NO_GESTURES_ASSEMBLED = 'no-gestures-assembled';
var ALERT_ASSEMBLED_GESTURE_REMOVED = 'assembled-gesture-removed';
var ALERT_NO_TRIGGER_ASSEMBLED = 'no-trigger-assembled';
var ALERT_ASSEMBLED_TRIGGER_REMOVED = 'assembled-trigger-removed';
var ALERT_NO_FEEDBACK_ASSEMBLED = 'no-feedback-assembled';
var ALERT_ASSEMBLED_FEEDBACK_REMOVED = 'assembled-feedback-removed';
var ALERT_NO_TITLE = 'no-title';
var ALERT_PIDOCO_EDIT_URL_INVALID = 'pidoco-edit-url-invalid';
var ALERT_PIDOCO_EMBED_URL_INVALID = 'pidoco-embed-url-invalid';
var ALERT_VIDEO_EMBED_URL_INVALID = 'video-embed-url-invalid';
var ALERT_ASSEMBLED_PROTOTYPE_REMOVED = 'assembled-prototype-removed';
var ALERT_NO_SEARCH_RESULTS = 'no-search-results';
var ALERT_NO_PHASE_DATA = 'no-phase-data';
var ALERT_WAITING_FOR_TRAINING_GESTURE = 'waiting-for-training-gesture';
var ALERT_WAITING_FOR_SLIDESHOW = 'waiting-for-slideshow';
var ALERT_WAITING_FOR_SCENARIO_START = 'waiting-for-scenario-start';

function appendAlert(target, alertType) {
    var children = $(target).find('.alert-' + alertType).find('#' + alertType);

    if (children.length === 0) {
        var alert = $('#alert-container').find('#' + alertType).clone();
        console.log('append alert: ' + $('#alert-container'));
        $(target).find('.alert-' + alert.attr('id')).append(alert);
    }
}

function removeAlert(target, alertType) {
    $(target).find('.alert-' + alertType).empty();
}