<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
$h = getv('h');
$studyId = getv('studyId');
$token = getv('token');

if (studyExecutionExists($studyId, $mysqli)) {
    header('Location: study-execution-exists.php');
}

if ($h && $token && $studyId) {
    if (login_check($mysqli) == true) {
        $hash = hash('sha512', $studyId . $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname']);
        if ($hash != $h) {
            header('Location: study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $token);
        }
    } else {
        if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 0 || $_SESSION['user_id'] == '0'))) {
            $time = time();
            $_SESSION['user_id'] = hash('sha512', $time . $_SESSION['usertype']);
        }
        $_SESSION['usertype'] = 'guest';
        $hash = hash('sha512', $studyId . $_SESSION['usertype']);

        if ($hash != $h) {
            header('Location: study-prepare-fallback.php?studyId=' . $studyId . '&h=' . $token);
        }
    }
} else {
    header('Location: study-prepare-failure.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/study-preview.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
        <script src="resumable/resumable.js"></script>

        <script src="js/chance.min.js"></script>
        <script src="color-thief/color-thief.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-tester.js"></script>       
        <script src="js/ajax.js"></script> 
        <script src="js/gesture.js"></script>
        <script src="js/renderForms.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/study-execution.js"></script>
        <script src="js/study-execution-tester.js"></script>
        <script src="js/study-execution-tester-save.js"></script>
        <script src="js/execution-upload-queue.js"></script>

        <!-- gesture recorder sources -->
        <script src="js/gesture-recorder.js"></script>
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-gesture-recorder"></div>

        <!-- modals -->
        <div id="scene-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="help-modal" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hilfe</h4>
                    </div>
                    <div class="modal-body root">
                        <p id="help-text" style="color: #303030"></p>
                        <div id="gesture-preview" class="hidden">
                            <div class="previewGesture autoplay"></div>
                            <div class="text-center gestureControls">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                                    <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                                    <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                                    <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-info btn-block" data-dismiss="modal"><span class="text">Okay</span></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="preview-modal" data-backdrop="static" >
            <div class="modal-dialog">
                <div class="modal-content">

                </div>
            </div>
        </div>

        <!-- progress bar -->
        <div id="progressTop" style="position: fixed; top: 0; left: 0; right: 0">
            <div class="progress" style="border-radius: 0px">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%">
                    0%
                </div>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="mainContent" id="mainContent" style="margin-top: 20px;">
            <div id="viewTester">
                <div id="phase-content"></div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    var path = PATH_EXTERNALS + '/' + currentLanguage + '/';
                    externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                    externals.push(['#template-gesture', path + 'template-gesture.html']);
                    externals.push(['#template-previews', path + 'template-previews.html']);
                    externals.push(['#template-gesture-recorder', path + '/template-gesture-recorder.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                var query = getQueryParams(document.location.search);
                if (query.studyId && query.h && query.token) {
                    var status = window.location.hash.substr(1);
                    var statusAddressMatch = statusAddressMatchIndex(status);

                    // check if there was a page reload
                    status = ''; // for testing
                    if (status !== '' && statusAddressMatch !== null) {
                        currentPhaseStepIndex = statusAddressMatch;
                        init();
                    } else {
                        getStudyById({studyId: query.studyId}, function (result) {
                            if (result.status === RESULT_SUCCESS) {
                                clearLocalItems();
                                setStudyData(result);
                                init();
                            }
                        });
                    }
                }
            }

            function init() {
                currentView = VIEW_TESTER;
                if (typeof (Storage) !== "undefined") {
                    checkStorage();
                } else {
                    console.log("Sorry, your browser do not support Web Session Storage.");
                }
            }

            function renderPhaseStep() {
                removeAlert($('#mainContent'), ALERT_NO_PHASE_DATA);
                resetRenderedContent();
                Tester.renderView();
                window.location.hash = getCurrentPhase().id;
            }

            function resetRenderedContent() {
                $('#viewTester').find('#phase-content').empty();
            }

            $('body').on('click', '.next', function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    nextStep();
                }
            });
        </script>
    </body>
</html>
