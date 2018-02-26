/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ELEMENT_MOVE_TRANSITION_DURATION = 0.2;
var GESTURE_IMAGE_HOME = 'uploads/';
var UPLOADS = 'uploads/';

// user specific constants
var USER = 'user';

// ajax result constants
var RESULT_SUCCESS = 'success';
var RESULT_ERROR = 'error';
var RESULT_WRONG_CURRENT_PASSWORD = 'wrongCurrentPassword';

// study specific constants
var STUDY = 'study';
var STUDY_RESULTS = 'studyResults';
var STUDY_PANEL = 'studyPanel';
var STUDY_DATA_EVALUATOR = 'dataEvaluator';
var STUDY_EVALUATOR_OBSERVATIONS = 'evaluatorObservations';
var STUDY_ORIGIN_GUS = 'study.originGUS';
var STUDY_ORIGIN_SUS = 'study.originSUS';
var STUDY_ORIGIN_FAVORITE_GESTURES = 'study.originFavoriteGestures';
var STUDY_PHASE_STEPS = 'study.phaseSteps';
//var PREDEFINED_GESTURE_SET = 'predefinedGestureSet';
var GESTURE_CATALOG = 'gestureCatalog';
var ELICITED_GESTURES = 'elicitedGestures';
var ELICITED_TRIGGER = 'elicitedTrigger';
var CLASSIFICATION = 'classification';
var GESTURE_SETS = 'gestureSets';

var CATALOG_GESTURES = 'catalog-gestures';
var CATALOG_TRIGGER = 'catalog-trigger';
var CATALOG_FEEDBACK = 'catalog-feedback';
var CATALOG_SCENES = 'catalog-scenes';

var PREDEFINED_OBSERVATIONS = 'predefinedObversation';
var PREDEFINED_GESTURE_QUESTIONNAIRE = 'predefinedGestureQuestionnaire';
var PREDEFINED_GESTURE_FEEDBACK = 'predefinedGestureFeedback';

var ASSEMBLED_GESTURE_SET = 'assembledGestureSet';
var ASSEMBLED_SCENES = 'assembledScenes';
var ASSEMBLED_TRIGGER = 'assembledTrigger';
var ASSEMBLED_FEEDBACK = 'assembledFeedback';

var TYPE_TRIGGER = 'trigger';
var TYPE_SURVEY_UNMODERATED = 'unmoderated';
var TYPE_SURVEY_MODERATED = 'moderated';
var TYPE_PHASE_ELICITATION = 'elicitation';
var TYPE_PHASE_EVALUATION = 'evaluation';
var TYPE_PHASE_EXTRACTION = 'extraction';

// feedback types
var TYPE_FEEDBACK_TEXT = 'text';
var TYPE_FEEDBACK_SOUND = 'sound';

// phase step formats
var QUESTIONNAIRE = 'questionnaire';
var INTERVIEW = 'interview';
var GUS_SINGLE_GESTURES = 'gus';
var GUS_MULTIPLE_GESTURES = 'questionnaireGestures';
var SUS = 'sus';
var UEQ = 'ueq';
var LETTER_OF_ACCEPTANCE = 'letterOfAcceptance';
var GESTURE_TRAINING = 'gestureTraining';
var SCENARIO = 'scenario';
var SLIDESHOW_GESTURES = 'gestureSlideshow';
var SLIDESHOW_TRIGGER = 'triggerSlideshow';
var IDENTIFICATION = 'identification';
var PHYSICAL_STRESS_TEST = 'physicalStressTest';
var THANKS = 'thanks';
var EXPLORATION = 'exploration';
var FAVORITE_GESTURES = 'favoriteGestures';

// questionnaire formats
var OPEN_QUESTION = 'openQuestion';
var OPEN_QUESTION_GUS = 'openQuestionGUS';
var DICHOTOMOUS_QUESTION = 'dichotomousQuestion';
var DICHOTOMOUS_QUESTION_GUS = 'dichotomousQuestionGUS';
var ALTERNATIVE_QUESTION = 'alternativeQuestion';
var GROUPING_QUESTION = 'groupingQuestion';
var GROUPING_QUESTION_GUS = 'groupingQuestionGUS';
var GROUPING_QUESTION_OPTIONS = 'groupingQuestionOptions';
var RATING = 'rating';
var MATRIX = 'matrix';
var SUM_QUESTION = 'sumQuestion';
var RANKING = 'ranking';
var COUNTER = 'counter';
var GUS_SINGLE = 'gusSingle';
var SUS_ITEM = 'susItem';
var UEQ_ITEM = 'ueqItem';

// scene formats
var SCENE_PIDOCO = 'pidoco';
var SCENE_WEB = 'web';
var SCENE_IMAGE = 'image';
var SCENE_VIDEO = 'video';
var SCENE_VIDEO_EMBED = 'videoEmbed';

// gesture scopes and sources
var SCOPE_GESTURE_PRIVATE = 'private';
var SCOPE_GESTURE_PUBLIC = 'public';
var SOURCE_GESTURE_OWN = 'own';
var SOURCE_GESTURE_EVALUATOR = 'evaluator';
var SOURCE_GESTURE_TESTER = 'tester';
var SOURCE_GESTURE_RECORDED = 'recorded';
var SCOPE_GESTURE_RATED = 'rated';
var SCOPE_GESTURE_LIKED = 'liked';

// general gesture types
var TYPE_GESTURE_POSE = 'pose';
var TYPE_GESTURE_DYNAMIC = 'dynamic';
var TYPE_GESTURE_DISCRETE = 'discrete';
var TYPE_GESTURE_CONTINUOUS = 'continuous';

// gesture body types
var TYPE_BODY_FULL = 'full';
var TYPE_BODY_UPPER = 'upper';
var TYPE_BODY_HAND = 'hand';

// gus & questionnaire dimensions
var DIMENSION_MAIN_EFFECTIVENESS = 'effectiveness';
var DIMENSION_MAIN_EFFICIENCY = 'effinciency';
var DIMENSION_MAIN_SATIFACTION = 'satisfaction';

var DIMENSION_ANY = 'any'; //espiacially for custom questionnaire items
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
var ALTERNATIVE_GESTURES = 'gestures';
var ALTERNATIVE_TRIGGERS = 'triggers';
var ALTERNATIVE_FOR_GESTURE = 'gesture';
var ALTERNATIVE_FOR_TRIGGER = 'trigger';
var ALTERNATIVE_FOR_FEEDBACK = 'feedback';

// scenario actions
var ACTION_CUSTOM = 'custom';
var ACTION_START_GESTURE_TRAINING = 'startGestureTraning';
var ACTION_SHOW_INFO = 'showInfo';
var ACTION_HIDE_INFO = 'hideInfo';
var ACTION_START_TASK = 'startTask';
var ACTION_REQUEST_HELP = 'requestHelp';
var ACTION_START_PERFORM_GESTURE = 'startPerformGesture';
var ACTION_START_PERFORM_GESTURE_STRESS_TEST = 'startPerformGestureStressTest';
var ACTION_END_PERFORM_GESTURE = 'endPerformGesture';
var ACTION_REFRESH_SCENE = 'refreshScene';
var ACTION_SELECT_GESTURE = 'selectGesture';
var ACTION_NO_GESTURE_FIT_FOUND = 'noGestureFitFound';
var ACTION_NO_GESTURE_DEMONSTRATED = 'noGestureDemonstrated';
var ACTION_START_QUESTIONNAIRE = 'startQuestionnaire';
var ACTION_END_QUESTIONNAIRE = 'endQuestionnaire';
var ACTION_RENDER_SCENE = 'renderScene';
var ACTION_SHOW_FEEDBACK = 'showFeedback';
var ACTION_HIDE_FEEDBACK = 'hideFeedback';
var ACTION_ASSESSMENT = 'assessment';

// cursors
var CURSOR_AUTO = 'auto';
var CURSOR_DEFAULT = 'default';
var CURSOR_POINTER = 'pointer';
var CURSOR_PROGRESS = 'progress';
var CURSOR_MOVE = 'move';
var CURSOR_NWSE_RESIZE = 'nwse-resize';

// messages
var MESSAGE_REQUEST_SYNC = 'requestSync';
var MESSAGE_SYNC_PHASE_STEP = 'syncPhaseStep';
var MESSAGE_ENTER_SURVEY = 'enterSurvey';
var MESSAGE_NEXT_STEP = 'nextStep';
var MESSAGE_CANCEL_SURVEY = 'cancelSurvey';
var MESSAGE_UPDATE_QUESTIONNAIRE = 'updateQuestionnaire';
var MESSAGE_QUESTIONNAIRE_DONE = 'questionnaireDone';
var MESSAGE_SHARED_SCREEN_ADDED = 'sharedScreenAdded';

var MESSAGE_START_IDENTIFICATION = 'startIdentification';
var MESSAGE_GESTURE_IDENTIFIED = 'gestureIdentified';
var MESSAGE_START_RECORDING_GESTURE = 'startGestureRecording';
var MESSAGE_STOP_RECORDING_GESTURE = 'stopGestureRecording';
var MESSAGE_REQUEST_TRIGGER = 'requestTrigger';
var MESSAGE_RESPONSE_TRIGGER = 'responseTrigger';

var MESSAGE_START_TRIGGER_SLIDESHOW = 'startTriggerSlideshow';
var MESSAGE_START_SCENARIO = 'startScenario';
var MESSAGE_RELOAD_SCENE = 'reloadScene';
var MESSAGE_RENDER_SCENE = 'renderScene';
var MESSAGE_TRIGGER_WOZ = 'triggerWOZ';
var MESSAGE_TRIGGER_FEEDBACK = 'triggerFeedback';
var MESSAGE_FEEDBACK_HIDDEN = 'feedbackHidden';
var MESSAGE_TRIGGER_HELP = 'triggerHelp';
var MESSAGE_HELP_CLOSED = 'helpClosed';

var MESSAGE_START_GESTURE_SLIDESHOW = 'startGestureSlideshow';
var MESSAGE_TRIGGER_GESTURE_SLIDE = 'triggerGestureSlide';
var MESSAGE_REACTIVATE_CONTROLS = 'reactivateControls';
var MESSAGE_GESTURE_PERFORMED = 'gesturePerformed';
var MESSAGE_TRIGGER_SLIDESHOW_DONE = 'triggerSlideshowDone';
var MESSAGE_NO_GESTURE_FIT_FOUND = 'noGestureFitFound';
var MESSAGE_GESTURE_FIT_FOUND = 'gestureFitFound';

var MESSAGE_START_GESTURE_TRAINING = 'startGestureTraining';
var MESSAGE_TRAINING_TRIGGERED = 'trainingTriggered';
var MESSAGE_FEEDBACK_TRIGGERED = 'feedbackTriggered';
var MESSAGE_GESTURE_INFO_PRESENT = 'gestureInfoPresent';
var MESSAGE_CLOSE_GESTURE_INFO = 'closeGestureInfo';
var MESSAGE_GESTURE_INFO_CLOSED = 'gestureInfoClosed';

var MESSAGE_START_STRESS_TEST = 'startStressTest';
var MESSAGE_TRIGGER_STRESS_TEST_GESTURE = 'triggerStressTestGesture';
var MESSAGE_TRIGGER_STRESS_TEST_QUESTION = 'triggerStressTestQuestion';
var MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE = 'triggerNextStressTestGesture';

var MESSAGE_START_EXPLORATION = 'startExploration';
var MESSAGE_REQUEST_PREFERRED_GESTURES = 'requestPreferredGestures';
var MESSAGE_RESPONSE_PREFERRED_GESTURES = 'responsePreferredGestures';
var MESSAGE_REQUEST_PREFERRED_TRIGGER = 'requestPreferredTrigger';
var MESSAGE_RESPONSE_PREFERRED_TRIGGER = 'responsePreferredTrigger';

var MESSAGE_SCREEN_SHARING_ESTABLISHED = 'screenSharingEstablished';

/*
 * assessment color constants
 */

var ASSESSMENT_COLOR_GREEN = 'green';
var ASSESSMENT_COLOR_BLUE = 'blue';
var ASSESSMENT_COLOR_YELLOW = 'yellow';
var ASSESSMENT_COLOR_RED = 'red';
var ASSESSMENT_COLOR_DARKBLUE = 'darkblue';

/*
 * gesture classifcation
 */
var TYPE_CLASSIFICATION_APPEARANCE = 'appearance';
var TYPE_CLASSIFICATION_APPEARANCE_TRIGGER = 'appearanceTrigger';
var TYPE_CLASSIFICATION_APPEARANCE = 'appearance';
var TYPE_CLASSIFICATION_APPEARANCE_GESTURE = 'appearanceGesture';
var TYPE_CLASSIFICATION_GESTURE_TYPE = 'gestureType';
var TYPE_CLASSIFICATION_GESTURE_TYPE_TRIGGER = 'gestureTypeTrigger';

var POTENTIAL_GESTURES = 'potentialGestures';
var POTENTIAL_TRIGGER = 'potentialTrigger';

var APOLLO_URL = 'ws://progesture.org:61623';
var APOLLO_LOGIN = 'admin';
var APOLLO_PASSWORD = 'password';
var APOLLO_DESTINATION = '/topic/gestures';

var GESTURE_SET_JSON = {
    url: APOLLO_URL,
    login: APOLLO_LOGIN,
    passcode: APOLLO_PASSWORD,
    destination: APOLLO_DESTINATION
//   "actions": [
//       {
//          "id": "sel_left",
//          "name": "selection left",
//          "description": "select an element on the left",
//          "image": "https://www.dropbox.com/s/k5bw8ffs1uez5a2/cat1.gif?dl=1"
//       },
//       {
//          "id": "sel_middle",
//          "name": "selection middle",
//          "description": "select an element in the middle",
//          "image": "https://www.dropbox.com/s/c8grhz4buioz8py/cat2.gif?dl=1"
//       }
//   ]
};

var AGREEMENT_MARGINS = [
    {max: 0.1, interpretation: 'lowAgreement'},
    {max: 0.3, interpretation: 'mediumAgreement'},
    {max: 0.5, interpretation: 'highAgreement'},
    {max: 1.0, interpretation: 'veryHightAgreement'}
];