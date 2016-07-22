/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ELEMENT_MOVE_TRANSITION_DURATION = 0.2;

// project specific constants
var PROJECT = 'project';
var PROJECT_ORIGIN_GUS = 'project.originGUS';
var PROJECT_ORIGIN_SUS = 'project.originSUS';
var PROJECT_PHASE_STEPS = 'project.phaseSteps';
var PREDEFINED_GESTURE_SET = 'predefinedGestureSet';
var PREDEFINED_OBSERVATIONS = 'predefinedObversation';
var PREDEFINED_GESTURE_QUESTIONNAIRE = 'predefinedGestureQuestionnaire';
var PREDEFINED_GESTURE_FEEDBACK = 'predefinedGestureFeedback';

var PREDEFINED_FEEDBACK = 'predefinedFeedback';
var ASSEMBLED_GESTURE_SET = 'assembledGestureSet';
var ASSEMBLED_SCENES = 'assembledScenes';
var ASSEMBLED_TRIGGER = 'assembledTrigger';
var ASSEMBLED_FEEDBACK = 'assembledFeedback';

var TYPE_TRIGGER = 'trigger';
var TYPE_SURVEY_UNMODERATED = 'unmoderated';
var TYPE_SURVEY_MODERATED = 'moderated';
var TYPE_PHASE_ELICITATION = 'elicitation';
var TYPE_PHASE_EVALUATION = 'evaluation';

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
var SLIDESHOW = 'slideshow';

// questionnaire formats
var OPEN_QUESTION = 'openQuestion';
var DICHOTOMOUS_QUESTION = 'dichotomousQuestion';
var ALTERNATIVE_QUESTION = 'alternativeQuestion';
var GROUPING_QUESTION = 'groupingQuestion';
var GROUPING_QUESTION_GUS = 'groupingQuestionGUS';
var RATING = 'rating';
var SUM_QUESTION = 'sumQuestion';
var RANKING = 'ranking';
var COUNTER = 'ranking';
var GUS_SINGLE = 'gusSingle';

// scene formats
var SCENE_PIDOCO = 'pidoco';
var SCENE_WEB = 'web';
var SCENE_IMAGE = 'image';
var SCENE_VIDEO = 'video';
var SCENE_VIDEO_EMBED = 'videoEmbed';

// gesture types
var GESTURE_OWN = 'own';
var GESTURE_PUBLIC = 'public';
var GESTURE_RECORDED = 'recorded';

// general gesture types
var TYPE_GESTURE_DISCRETE = 'discrete';
var TYPE_GESTURE_POSE = 'pose';
var TYPE_GESTURE_CONTINUOUS = 'continuous';

// gesture body types
var TYPE_BODY_FULL = 'full';
var TYPE_BODY_UPPER = 'upper';
var TYPE_BODY_HAND = 'hand';

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

// cursors
var CURSOR_AUTO = 'auto';
var CURSOR_DEFAULT = 'default';
var CURSOR_POINTER = 'pointer';
var CURSOR_PROGRESS = 'progress';
var CURSOR_MOVE = 'move';
var CURSOR_NWSE_RESIZE = 'nwse-resize';