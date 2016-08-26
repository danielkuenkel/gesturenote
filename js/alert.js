/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// login/register alerts
var ALERT_GENERAL_ERROR = 'general-error';
var ALERT_MISSING_FIELDS = 'missing-fields';
var ALERT_LOGIN_FAILED = 'login-failed';
var ALERT_ACCOUNT_LOGGED = 'account-logged';
var ALERT_INVALID_EMAIL = 'invalid-email';
var ALERT_WRONG_PASSWORD = 'wrong-password';
var ALERT_PASSWORD_SHORT = 'password-short';
var ALERT_PASSWORD_INVALID = 'password-invalid';
var ALERT_PASSWORDS_NOT_MATCHING = 'passwords-not-matching';
var ALERT_INVALID_BIRTHDAY = 'invalid-birthday';
var ALERT_USER_EXISTS = 'user-exists';
var ALERT_NO_USER_EXISTS = 'no-user-exists';
var ALERT_REGISTER_SUCCESS = 'register-success';
var ALERT_WRONG_CURRENT_PASSWORD = 'wrong-current-password';

// alert constants
var ALERT_WEB_RTC_NOT_SUPPORTED = 'web-rtc-not-supported';
var ALERT_NO_WEBSOCKETS = 'no-websockets';
var ALERT_NO_SCENES_ASSEMBLED = 'no-scenes-assembled';
var ALERT_NO_GESTURES_ASSEMBLED = 'no-gestures-assembled';
var ALERT_ASSEMBLED_GESTURE_REMOVED = 'assembled-gesture-removed';
var ALERT_NO_TRIGGER_ASSEMBLED = 'no-trigger-assembled';
var ALERT_ASSEMBLED_TRIGGER_REMOVED = 'assembled-trigger-removed';
var ALERT_NO_FEEDBACK_ASSEMBLED = 'no-feedback-assembled';
var ALERT_ASSEMBLED_FEEDBACK_REMOVED = 'assembled-feedback-removed';
var ALERT_ASSEMBLED_SCENE_REMOVED = 'assembled-scene-removed';
var ALERT_NO_TITLE = 'no-title';
var ALERT_PIDOCO_EDIT_URL_INVALID = 'pidoco-edit-url-invalid';
var ALERT_PIDOCO_EMBED_URL_INVALID = 'pidoco-embed-url-invalid';
var ALERT_VIDEO_EMBED_URL_INVALID = 'video-embed-url-invalid';
var ALERT_NO_SEARCH_RESULTS = 'no-search-results';
var ALERT_NO_PHASE_DATA = 'no-phase-data';
var ALERT_WAITING_FOR_TRAINING_GESTURE = 'waiting-for-training-gesture';
var ALERT_WAITING_FOR_SLIDESHOW = 'waiting-for-slideshow';
var ALERT_WAITING_FOR_IDENTIFICATION = 'waiting-for-identification';
var ALERT_WAITING_FOR_SCENARIO_START = 'waiting-for-scenario-start';

var ALERT_GESTURE_SAVE_SUCCESS = 'gesture-save-success';
var ALERT_GESTURE_DELETE_SUCCESS = 'gesture-delete-success';
var ALERT_GESTURE_TOO_SHORT = 'gesture-too-short';
var ALERT_NO_GESTURES = 'no-gestures';
var ALERT_NO_STUDIES = 'no-studies';

var ALERT_RATING_SUBMITTED = 'rating-submitted';

var ALERT_NO_COMMENTS = 'no-comments';

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

function clearAlerts(target) {
    $(target).find('.alert-space').children().remove();
}