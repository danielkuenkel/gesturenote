/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// login/register alerts
var ALERT_GENERAL_ERROR = 'general-error';
var ALERT_MISSING_FIELDS = 'missing-fields';
var ALERT_MISSING_EMAIL = 'missing-email';
var ALERT_CHECK_EMAIL = 'check-email';
var ALERT_PASSWORD_RESET_SUCCESS = 'password-reset-success';
var ALERT_RESET_PASSWORD_ERROR = 'reset-password-error';
var ALERT_LOGIN_FAILED = 'login-failed';
var ALERT_ACCOUNT_LOGGED = 'account-logged';
var ALERT_INVALID_EMAIL = 'invalid-email';
var ALERT_PASSWORD_RESET_SEND = 'password-reset-send';
var ALERT_WRONG_PASSWORD = 'wrong-password';
var ALERT_PASSWORD_SHORT = 'password-short';
var ALERT_PASSWORD_INVALID = 'password-invalid';
var ALERT_PASSWORDS_NOT_MATCHING = 'passwords-not-matching';
var ALERT_INVALID_BIRTHDAY = 'invalid-birthday';
var ALERT_USER_EXISTS = 'user-exists';
var ALERT_NO_USER_EXISTS = 'no-user-exists';
var ALERT_REGISTER_SUCCESS = 'register-success';
var ALERT_WRONG_CURRENT_PASSWORD = 'wrong-current-password';
var ALERT_CONTACT_SUCCESS = 'contact-success';

// alert constant
var ALERT_WEB_RTC_NOT_SUPPORTED = 'web-rtc-not-supported';
var ALERT_ANOTHER_BROWSER_NEEDED_FOR_WEB_RTC = 'another-browser-needed-for-web-rtc';
var ALERT_NO_STORAGE_API = 'no-storage-api';
var ALERT_NO_WEBSOCKETS = 'no-websockets';
var ALERT_NO_SCENES_ASSEMBLED = 'no-scenes-assembled';
var ALERT_NO_SCENES_ASSEMBLED_LINK = 'no-scenes-assembled-link';
var ALERT_NO_GESTURES_ASSEMBLED = 'no-gestures-assembled';
var ALERT_NO_STUDY_GESTURES_ASSEMBLED = 'no-study-gestures-assembled';
var ALERT_NO_STUDY_GESTURES_ASSEMBLED_LINK = 'no-study-gestures-assembled-link';
var ALERT_ASSEMBLED_GESTURE_REMOVED = 'assembled-gesture-removed';
var ALERT_NO_TRIGGER_ASSEMBLED = 'no-trigger-assembled';
var ALERT_NO_TRIGGER_ASSEMBLED_LINK = 'no-trigger-assembled-link';
var ALERT_ASSEMBLED_TRIGGER_REMOVED = 'assembled-trigger-removed';
var ALERT_NO_FEEDBACK_ASSEMBLED = 'no-feedback-assembled';
var ALERT_NO_FEEDBACK_ASSEMBLED_LINK = 'no-feedback-assembled-link';
var ALERT_ASSEMBLED_FEEDBACK_REMOVED = 'assembled-feedback-removed';
var ALERT_ASSEMBLED_SCENE_REMOVED = 'assembled-scene-removed';
var ALERT_ASSEMBLED_TASK_REMOVED = 'assembled-task-removed';
var ALERT_NO_TITLE = 'no-title';
var ALERT_PIDOCO_EDIT_URL_INVALID = 'pidoco-edit-url-invalid';
var ALERT_PIDOCO_EMBED_URL_INVALID = 'pidoco-embed-url-invalid';
var ALERT_VIDEO_EMBED_URL_INVALID = 'video-embed-url-invalid';
var ALERT_IMAGE_TO_LARGE = 'image-to-large';
var ALERT_SOUND_TO_LARGE = 'sound-to-large';
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
var ALERT_STUDY_UNMODERATED = 'study-unmoderated';
var ALERT_NO_PLAN = 'no-plan';
var ALERT_NO_MORE_TASKS = 'no-more-tasks';

var ALERT_RATING_SUBMITTED = 'rating-submitted';

var ALERT_NO_COMMENTS = 'no-comments';

var ALERT_CONTACT_SUPPORT = 'contact-support';
var ALERT_SUS_INVALID = 'sus-invalid';
var ALERT_WEBM_UNSUPPORTED = 'webm-unsupported';
var ALERT_NO_RECORD = 'no-record';
var ALERT_RECORD_URL_INVALID = 'record-url-invalid';

var ALERT_WAITING_FOR_MODERATOR = 'waiting-for-moderator';
var ALERT_WAITING_FOR_TESTER = 'waiting-for-tester';
var ALERT_NO_PARTICIPATION_REQUESTS = 'no-participation-requests';
var ALERT_SEARCH_PARTICIPATION_REQUESTS = 'search-participation-requests';
var ALERT_STUDY_OVER_RANGE = 'study-over-range';
var ALERT_STUDY_UNDER_RANGE = 'study-under-range';

var ALERT_PLEASE_WAIT = 'please-wait';
var ALERT_GENERAL_PLEASE_WAIT = 'general-please-wait';

var ALERT_NO_RECORDED_GESTURES = 'no-recorded-gestures';
var ALERT_NO_GESTURES_CLASSIFIED = 'no-gestures-classified';
var ALERT_NO_TRIGGER_CLASSIFIED = 'no-trigger-classified';
var ALERT_NO_MORE_GESTURES_FOR_CLASSIFICATION = 'no-more-gestures-for-classification';
var ALERT_NO_MORE_TRIGGER_FOR_CLASSIFICATION = 'no-more-trigger-for-classification';
var ALERT_NO_GESTURE_SETS_FOR_STUDY = 'no-gesture-sets-for-study';
var ALERT_GESTURE_SET_TITLE_TOO_SHORT = 'gesture-set-title-too-short';
var ALERT_EMPTY_GESTURE_SET = 'empty-gesture-set';
var ALERT_NOT_ASSIGNED_TO_GESTURE_SET = 'not-assigned-to-gesture-set';
var ALERT_SET_MISSING_GESTURES = 'set-missing-gestures';

var ALERT_PREVIEW_DUMMY = 'preview-dummy';

// create study alert modal hints
var ALERT_NO_DATA_QUESTIONNAIRE = 'no-data-questionnaire';
var ALERT_NO_DATA_GUS = 'no-data-gus';
var ALERT_NO_DATA_GUS_QUESTIONNAIRE = 'no-data-gus-questionnaire';
var ALERT_NO_DATA_UEQ_QUESTIONNAIRE = 'no-data-ueq-questionnaire';
var ALERT_NO_ANNOTATIONS = 'no-annotations';
var ALERT_NO_USERS_INVITED = 'no-users-invited';
var ALERT_USER_ALREADY_INVITED = 'user-already-invited';
var ALERT_INVITE_YOURSELF = 'invite-yourself';
var ALERT_GESTURE_SET_NOT_SHARED = 'gesture-set-not-shared';
var ALERT_SHARE_GESTURE_SET_TO_YOURSELF = 'share-gesture-set-to-yourself';
var ALERT_GESTURE_NOT_SHARED = 'gesture-not-shared';
var ALERT_SHARE_GESTURE_TO_YOURSELF = 'share-gesture-to-yourself';

// exchangeable file hints
var ALERT_NO_EXCHANGEABLE_FILE_SELECTED = 'no-exchangeable-file-selected';
var ALERT_EXCHANGEABLE_GESTURES_IMPORTED_SUCCESS = 'exchangeable-gestures-imported-success';

function appendAlert(target, alertType) {
    var children = $(target).find('.alert-' + alertType).find('#' + alertType);
    if (children.length === 0) {
        var alert = $('#alert-container').find('#' + alertType).clone();
        console.log('append alert: ', alertType, 'target', target);
        $(target).find('.alert-' + alert.attr('id')).append(alert);
    }
}

function removeAlert(target, alertType) {
    $(target).find('.alert-' + alertType).empty();
}

function clearAlerts(target) {
    $(target).find('.alert-space').children().remove();
}