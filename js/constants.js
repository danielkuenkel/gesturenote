/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ELEMENT_MOVE_TRANSITION_DURATION = 0.2;
var GESTURE_IMAGE_HOME = 'uploads/';
var UPLOADS = 'uploads/';

// user specific constants
//var USER_ID = 'userId';

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
var CLASSIFICATION = 'classification';
var GESTURE_SETS = 'gestureSets';

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
var GUS_SINGLE_GESTURES = 'gus';
var GUS_MULTIPLE_GESTURES = 'questionnaireGestures';
var SUS = 'sus';
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

// general gesture types
var TYPE_GESTURE_DISCRETE = 'discrete';
var TYPE_GESTURE_POSE = 'pose';
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
var ACTION_SHOW_INFO = 'showInfo';
var ACTION_HIDE_INFO = 'hideInfo';
var ACTION_START_TASK = 'startTask';
var ACTION_REQUEST_HELP = 'requestHelp';
var ACTION_START_PERFORM_GESTURE = 'startPerformGesture';
var ACTION_END_PERFORM_GESTURE = 'endPerformGesture';
var ACTION_REFRESH_SCENE = 'refreshScene';
var ACTION_SELECT_GESTURE = 'selectGesture';
var ACTION_NO_GESTURE_FIT_FOUND = 'noGestureFitFound';
var ACTION_NO_GESTURE_DEMONSTRATED = 'noGestureDemonstrated';
var ACTION_START_QUESTIONNAIRE = 'startQuestionnaire';
var ACTION_END_QUESTIONNAIRE = 'endQuestionnaire';

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

var MESSAGE_START_IDENTIFICATION = 'startIdentification';
var MESSAGE_GESTURE_IDENTIFIED = 'gestureIdentified';
var MESSAGE_IDENTIFIED_GESTURE_DELETED = 'identifiedGestureDeleted';
var MESSAGE_IDENTIFICATION_DONE = 'gestureIdentificationDone';

var MESSAGE_START_TRIGGER_SLIDESHOW = 'startTriggerSlideshow';
var MESSAGE_START_SCENARIO = 'startScenario';
var MESSAGE_RELOAD_SCENE = 'reloadScene';
var MESSAGE_TRIGGER_WOZ = 'triggerWOZ';
var MESSAGE_TRIGGER_HELP = 'triggerHelp';
var MESSAGE_HELP_CLOSED = 'helpClosed';

var MESSAGE_START_GESTURE_SLIDESHOW = 'startGestureSlideshow';
var MESSAGE_TRIGGER_GESTURE_SLIDE = 'triggerGestureSlide';
var MESSAGE_REACTIVATE_CONTROLS = 'reactivateControls';
var MESSAGE_GESTURE_PERFORMED = 'gesturePerformed';
var MESSAGE_TRIGGER_SLIDESHOW_DONE = 'triggerSlideshowDone';

var MESSAGE_START_GESTURE_TRAINING = 'startGestureTraining';
var MESSAGE_TRAINING_TRIGGERED = 'trainingTriggered';
var MESSAGE_FEEDBACK_TRIGGERED = 'feedbackTriggered';

var MESSAGE_START_STRESS_TEST = 'startStressTest';
var MESSAGE_TRIGGER_STRESS_TEST_GESTURE = 'triggerStressTestGesture';
var MESSAGE_TRIGGER_STRESS_TEST_QUESTION = 'triggerStressTestQuestion';
var MESSAGE_TRIGGER_NEXT_STRESS_TEST_GESTURE = 'triggerNextStressTestGesture';

var MESSAGE_START_EXPLORATION = 'startExploration';
/*
 * gesture classifcation
 */
var TYPE_CLASSIFICATION_APPEARANCE = 'appearance';
var TYPE_CLASSIFICATION_APPEARANCE_TRIGGER = 'appearanceTrigger';
var TYPE_CLASSIFICATION_GESTURE_TYPE = 'gestureType';
var TYPE_CLASSIFICATION_GESTURE_TYPE_TRIGGER = 'gestureTypeTrigger';

var POTENTIAL_GESTURES = 'potentialGestures';