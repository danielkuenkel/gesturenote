/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
var TYPE_PHASE_ELICITATION = 'elicitation';

// questionnaire formats
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
TYPE_URL_PIDOCO_EDIT = 'pidocoEdit';
TYPE_URL_PIDOCO_EMBED = 'pidocoEmbed';
TYPE_URL_VIDEO_EMBED = 'videoEmbed';

// alerts
ALERT_NO_GESTURES_ASSEMBLED = 'no-gestures-assembled';
ALERT_ASSEMBLED_GESTURE_REMOVED = 'assembled-gesture-removed';
ALERT_NO_TRIGGER_ASSEMBLED = 'no-trigger-assembled';
ALERT_ASSEMBLED_TRIGGER_REMOVED = 'assembled-trigger-removed';
ALERT_NO_TITLE = 'no-title';
ALERT_PIDOCO_EDIT_URL_INVALID = 'pidoco-edit-url-invalid';
ALERT_PIDOCO_EMBED_URL_INVALID = 'pidoco-embed-url-invalid';
ALERT_VIDEO_EMBED_URL_INVALID = 'video-embed-url-invalid';