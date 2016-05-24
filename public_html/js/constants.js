/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// path externals
var PATH_EXTERNALS = 'externals/';

var GESTURE_THUMBNAIL_SCROLLING_SPEED = 100;

// project specific constants
var PROJECT = 'project';
var PROJECT_ORIGIN_GUS = 'project.originGUS';
var PROJECT_ORIGIN_SUS = 'project.originSUS';
var PROJECT_PHASE_STEPS = 'project.phaseSteps';
var PREDEFINED_GESTURE_SET = 'predefinedGestureSet';
var PREDEFINED_OBSERVATIONS = 'predefinedObversation';
var PREDEFINED_GESTURE_QUESTIONNAIRE = 'predefinedGestureQuestionnaire';
var PREDEFINED_GESTURE_FEEDBACK = 'predefinedGestureFeedback';
var FEEDBACK_PREDEFINED = 'predefinedFeedback';
var FEEDBACK_CUSTOM = 'customFeedback';

var ASSEMBLED_PROTOTYPES = 'assembledPrototypes';
//var ASSEMBLED_GESTURES = 'assembledGestures';
var ASSEMBLED_TRIGGER = 'assembledTrigger';

var TYPE_TRIGGER = 'trigger';
var TYPE_SURVEY_UNMODERATED = 'unmoderated';
var TYPE_SURVEY_MODERATED = 'moderated';
var TYPE_PHASE_ELICITATION = 'elicitation';
var TYPE_PHASE_EVALUATION = 'evaluation';

// phase step formats
var QUESTIONNAIRE = 'questionnaire';
var GUS_SINGLE_GESTURES = 'gus';
var GUS_MULTIPLE_GESTURES = 'questionnaireGestures';
var SUS = 'sus';
var LETTER_OF_ACCEPTANCE = 'letterOfAcceptance';
var GESTURE_TRAINING = 'gestureTraining';
var SCENARIO = 'scenario';

// questionnaire formats
var OPEN_QUESTION = 'openQuestion';
var DICHOTOMOUS_QUESTION = 'dichotomousQuestion';
var ALTERNATIVE_QUESTION = 'alternativeQuestion';
var GROUPING_QUESTION = 'groupingQuestion';
var RATING = 'rating';
var SUM_QUESTION = 'sumQuestion';
var RANKING = 'ranking';

// prototype formats
var PROTOTYPE_PIDOCO = 'pidoco';
var PROTOTYPE_WEB = 'web';
var PROTOTYPE_IMAGE = 'image';
var PROTOTYPE_VIDEO = 'video';
var PROTOTYPE_VIDEO_EMBED = 'videoEmbed';

// gesture types
var GESTURE_OWN_PROJECT = 'ownProject';
var GESTURE_CATALOG = 'catalog';
var GESTURE_RECORDED = 'recorded';

// questionnaire dimensions
var DIMENSION_ANY = 'any';
var DIMENSION_ERGONOMICS = 'ergonomics'; // Ergonomie
var DIMENSION_LERNABILITY = 'learnability'; // Erlernbarkeit
var DIMENSION_MENTAL_MODEL = 'mental_model'; // Mentales Modell
var DIMENSION_COGNITIVE_STRESS = 'cognitive_stress'; // Kognitive Belastung
var DIMENSION_USABILITY = 'usability'; // Nutzbarkeit
var DIMENSION_ACCEPTABILITY = 'acceptability'; // (soziale) Akzeptanz
var DIMENSION_FEASIBILITY = 'feasability'; // Realisierbarkeit
var DIMENSION_RELIABILITY = 'reliability'; // Zuverlässigkeit

// url types
var TYPE_URL_PIDOCO_EDIT = 'pidocoEdit';
var TYPE_URL_PIDOCO_EMBED = 'pidocoEmbed';
var TYPE_URL_VIDEO_EMBED = 'videoEmbed';

// alerts
var ALERT_NO_GESTURES_ASSEMBLED = 'no-gestures-assembled';
var ALERT_ASSEMBLED_GESTURE_REMOVED = 'assembled-gesture-removed';
var ALERT_NO_TRIGGER_ASSEMBLED = 'no-trigger-assembled';
var ALERT_ASSEMBLED_TRIGGER_REMOVED = 'assembled-trigger-removed';
var ALERT_NO_TITLE = 'no-title';
var ALERT_PIDOCO_EDIT_URL_INVALID = 'pidoco-edit-url-invalid';
var ALERT_PIDOCO_EMBED_URL_INVALID = 'pidoco-embed-url-invalid';
var ALERT_VIDEO_EMBED_URL_INVALID = 'video-embed-url-invalid';
var ALERT_ASSEMBLED_PROTOTYPE_REMOVED = 'assembled-prototype-removed';
var ALERT_NO_SEARCH_RESULTS = 'no-search-results';
var ALERT_NO_PHASE_DATA = 'no-phase-data';

// sort
var SORT_ASC = 'asc';
var SORT_DESC = 'desc';
var SORT_OLDEST = 'oldest';
var SORT_NEWEST = 'newest';

// view
var VIEW_MODERATOR = 'moderator';
var VIEW_TESTER = 'tester';

// scales
var PERCENT = 'percent';
var POINTS = 'points';

// alternatives
ALTERNATIVE_GESTURES = 'gestures';
ALTERNATIVE_TRIGGERS = 'triggers';
ALTERNATIVE_FOR_GESTURE = 'gesture';
ALTERNATIVE_FOR_TRIGGER = 'trigger';

// languages
LANGUAGE_EN = 'en';
LANGUAGE_DE = 'de';