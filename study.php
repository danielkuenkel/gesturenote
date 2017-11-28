<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
if (login_check($mysqli) == true) {
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'tester') {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteStudy ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/study.css">
        <link rel="stylesheet" href="css/study-create.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

        <script src="js/constants.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/gesture.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/forms.js"></script>
        <script src="js/dimensions.js"></script>
        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/study.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>
        <div id="template-gesture"></div>
        <div id="template-previews"></div>
        <div id="template-create"></div>
        <div id="template-general"></div>
        <div id="template-study"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root">
                </div>
            </div>
        </div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-studies"><i class="fa fa-tasks" aria-hidden="true"></i> <?php echo $lang->breadcrump->studies ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->study ?></li>
                </ol>
            </div>
        </div>

        <div class="container">
            <ul class="nav nav-tabs" role="tablist" id="tab-pane">
                <li role="presentation" id="general"><a href="#general-infos" aria-controls="general-infos" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->general ?></a></li>
                <li role="presentation" id="catalogs"><a href="#study-catalogs" aria-controls="study-catalogs" role="tab" data-toggle="tab"><?php echo $lang->studyCreateNav->catalogs ?></a></li>
                <li role="presentation" id="participants"><a href="#study-participants" aria-controls="study-participants" role="tab" data-toggle="tab"><?php echo $lang->participations ?> <span class="badge"></span></a></li>
                <li role="presentation" class="hidden" id="extraction"><a href="#gesture-extraction" aria-controls="gesture-extraction" role="tab" data-toggle="tab"><?php echo $lang->phaseType->extraction ?></a></li>
                <li role="presentation" id="tab-introduction" class="pull-right"><a role="button"><i class="fa fa-support"></i> <?php echo $lang->help ?></a></li>
            </ul>
        </div>


        <!-- Container (Panel Section) -->
        <div class="container mainContent tab-content" id="main-content">

            <div role="tabpanel" class="tab-pane" id="general-infos">
                <h2 id="study-headline" style="margin-top: 0"></h2>
                <div class="label label-default" id="type-phase"></div>
                <div class="label label-default" id="type-survey"></div>
                <div class="label label-default hidden" id="panel-survey"><?php echo $lang->panelSurvey ?></div>

                <div class="row" style="margin-top: 20px">
                    <div class="col-sm-6 col-lg-7">
                        <div id="study-description">
                            <h3 class="address"></h3>
                            <p class="text"></p>
                        </div>
                        <div class="hidden study-no-plan"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                        <div class="hidden study-plan"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                        <div class="hidden panel-survey"><i class="fa fa-users" aria-hidden="true"></i> <span class="address"></span> <span class="text"></span></div>
                    </div>
                    <div class="col-sm-5 col-sm-offset-1 col-lg-4 col-lg-offset-1">
                        <div id="study-phases">
                            <h3 class="address"><?php echo $lang->phases ?></h3>
                            <div class="alert-space alert-no-phase-data"></div>
                            <div id="phase-steps-container" style="margin-top: 15px"></div>
                        </div>
                        <div class="btn-group-vertical btn-block" style="margin-top: 50px">
                            <button class="btn btn-default btn-shadow" type="button" id="btn-edit-study"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->editStudy ?></span></button>
                            <button class="btn btn-default btn-shadow" type="button" id="btn-preview-study"><i class="fa fa-eye" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->previewStudy ?></span></button>
                            <button class="btn btn-default btn-shadow" type="button" id="btn-delete-study"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->deleteStudy ?></span></button>
                            <button class="btn btn-default btn-shadow" type="button" id="btn-prepare-study"><i class="fa fa-inbox" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->executeStudy ?></span></button>
                        </div>
                    </div>

                    <div class="col-sm-12" style="margin-top: 20px;" id="copy-to-clipboard">
                        <div class="input-group">
                            <div class="input-group-addon"><?php echo $lang->studyUrl ?></div>
                            <input type="text" class="form-control" id="static-study-url">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-shadow" type="button" id="btn-open-static-study-url"><i class="fa fa-external-link" aria-hidden="true"></i> <span><?php echo $lang->openStudyUrl ?></span></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="study-catalogs">
                <div class="alert-space alert-no-phase-data"></div>

                <div id="study-gestures-catalog" class="hidden">
                    <h4 class="address"><?php echo $lang->studyCatalogs->gestures ?></h4>
                    <div class="list-container row" id="gestures-list-container"></div>
                </div>

                <div id="study-scenes-catalog" class="hidden" style="margin-top: 20px;">
                    <h4 class="address"><?php echo $lang->studyCatalogs->scenes ?></h4>
                    <div class="list-container"></div>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div id="study-trigger-catalog" class="hidden col-sm-6" style="margin-bottom: 20px">
                        <h4 class="address"><?php echo $lang->studyCatalogs->trigger ?></h4>
                        <div class="list-container"></div>
                    </div>

                    <div id="study-feedback-catalog" class="hidden col-sm-6">
                        <h4 class="address"><?php echo $lang->studyCatalogs->feedback ?></h4>
                        <div class="list-container"></div>
                    </div>
                </div>
            </div>


            <div role="tabpanel" class="tab-pane" id="study-participants">
                <div class="alert-space alert-no-phase-data"></div>
                <div class="alert-space alert-no-plan"></div>
                <div class="list-container row"></div>
            </div>

            <div role="tabpanel" class="tab-pane" id="gesture-extraction">
                <div class="alert-space alert-no-phase-data"></div>

                <div id="extraction-content" class="row">

                    <div class="col-sm-4 col-md-3" style="margin-bottom: 20px">
                        <div data-spy="affix" data-offset-top="0" id="extraction-navigation">
                            <h5 class="text"><?php echo $lang->extractionContent->preparation ?></h5>
                            <div class="btn-group-vertical btn-block" id="btns-general">
                                <button class="btn btn-default btn-shadow" type="button" id="btn-all-gestures"><span class="btn-text"><?php echo $lang->extractionContent->allElicitedGestures ?></span></button>
                                <button class="btn btn-default btn-shadow" type="button" id="btn-gesture-classification"><span class="btn-text"><?php echo $lang->extractionContent->gestureClassification ?></span></button>
                                <button class="btn btn-default btn-shadow" type="button" id="btn-checklist"><span class="btn-text"><?php echo $lang->extractionContent->checklist ?></span></button>
                            </div>

                            <h5 class="text" style="margin-top: 20px"><?php echo $lang->phaseType->extraction ?></h5>
                            <div class="btn-group-vertical btn-block" id="btns-arrange-gesture-sets">
                                <button class="btn btn-default btn-shadow disabled" type="button" id="btn-potential-gestures"><span class="btn-text"><?php echo $lang->extractionContent->potentialGestures ?></span></button>
                                <button class="btn btn-default btn-shadow disabled" type="button" id="btn-gesture-sets"><span class="btn-text"><?php echo $lang->gestureSets ?></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8 col-md-9" id="extraction-navigation-content" style="margin-top: 5px">
                        <div id="content-btn-all-gestures" class="hidden"></div>

                        <div id="content-btn-gesture-classification" class="hidden">
                            <h4 style="margin-top: 0px"><span class="text"><?php echo $lang->extractionContent->classifyGestures ?></span> 
                                <button type="button" class="btn btn-xs btn-default btn-shadow disabled" id="btn-reclassify-gestures" style="margin-left:5px"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->extractionContent->reclassifyGestures ?></span></button>
                            </h4>
                            <div class="alert-space alert-no-more-gestures-for-classification" style="margin-top:20px"></div>

                            <div id="gesture-classification-parameters" class="hidden text-center" style="margin-top:20px">
                                <div class="form-group root text" id="classification-type">
                                    <label><?php echo $lang->extractionContent->classifyQuestion ?></label><br>

                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio" id="appearance" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle hidden" id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearance ?></span>
                                        </button>
                                    </div>

                                    <br/>
                                    <div class="btn-group" id="radio">
                                        <button class="btn btn-default btn-radio btn-option-checked" id="appearanceTrigger" name="primary">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle " id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->classificationTypes->appearanceTrigger ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-group-vertical">
                                    <!--<button type="button" class="btn btn-default btn-shadow" id="btn-help-classification"><i class="fa fa-question-circle"></i> <span class="btn-text">Mehr Infos zur Klassifizierung</span></button>-->
                                    <button type="button" class="btn btn-primary btn-shadow" id="btn-start-classification"><i class="fa fa-archive"></i> <span class="btn-text"><?php echo $lang->extractionContent->startClassification ?></span></button>
                                </div>
                            </div>

                            <div id="gesture-classification" class="row hidden" style="margin-top:20px">
                                <div class="col-xs-4 col-sm-4"><div class="row"><div id="gesture-left"></div></div></div>
                                <div class="col-xs-4 col-sm-4 text-center" id="match-controls">

                                    <p class="text"><?php echo $lang->extractionContent->compareQuestion ?></p>
                                    <div class="btn-group btn-group-justified" role="group">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-danger btn-shadow" id="btn-gesture-no"><i class="fa fa-thumbs-down"></i> <span class="btn-text"><?php echo $lang->no ?></span></button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-shadow" id="btn-gesture-yes"><i class="fa fa-thumbs-up"></i> <span class="btn-text"><?php echo $lang->yes ?></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-default disabled btn-block btn-shadow" id="btn-redo" style="margin-top:10px"><i class="fa fa-undo" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->redo ?></span></button>
                                </div>
                                <div class="col-xs-4 col-sm-4"><div class="row"><div id="gesture-right"></div></div></div>
                            </div>
                            <h4 style="margin-top:30px" class="text"><?php echo $lang->ClassifiedGestures ?></h4>
                            <div id="classified-gestures"></div>
                            <div class="alert-space alert-no-gestures-classified"></div>
                        </div>

                        <div id="content-btn-checklist" class="hidden">
                            <span class="text" id="checklist-info"><?php echo $lang->extractionContent->checklistInfo ?></span>

                            <div id="use-checklist-switch" style="margin-top: 10px">
                                <label class="text"><?php echo $lang->useChecklist ?></label> 
                                <div class="switch root">
                                    <div class="btn-group" style="margin: 0">
                                        <button class="btn btn-default btn-radio" name="primary" id="yes">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle hidden" id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->yes ?></span>
                                        </button>
                                    </div>
                                    <div class="btn-group" style="margin: 0">
                                        <button class="btn btn-default btn-radio btn-option-checked" name="primary" id="no">
                                            <span id="icons" style="margin-right: 6px">
                                                <i class="fa fa-circle-thin hidden" id="normal"></i>
                                                <i class="fa fa-circle hidden" id="over"></i>
                                                <i class="fa fa-check-circle" id="checked"></i>
                                            </span>
                                            <span class="option-text"><?php echo $lang->no ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="checklist-container" style="margin-top: 20px"></div>
                        </div>

                        <div id="content-btn-potential-gestures" class="hidden"></div>

                        <div id="content-btn-gesture-sets" class="hidden">
                            <div class="create-gesture-set-input" id="add-new-set">
                                <label class="text"><?php echo $lang->createNewGestureSet ?></label>

                                <div class="alert-space alert-gesture-set-title-too-short"></div>

                                <div class="input-group">
                                    <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                            </div>

                            <div id="gesture-sets-container" class="root" style="margin-top: 20px"></div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                    externals.push(['#template-previews', PATH_EXTERNALS + 'template-previews.php']);
                    externals.push(['#template-create', PATH_EXTERNALS + 'template-create.php']);
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    externals.push(['#template-study', PATH_EXTERNALS + 'template-study.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                var showTutorial = parseInt(<?php echo $_SESSION['tutorialStudy'] ?>);
                if (showTutorial === 1) {
                    $('#tab-introduction a').click();
                }

                renderSubPageElements();
                var query = getQueryParams(document.location.search);
                var hash = hex_sha512(parseInt(query.studyId) + '<?php echo $_SESSION['user_id'] . $_SESSION['forename'] . $_SESSION['surname'] ?>');
                if (query.studyId && query.h === hash) {
                    getStudyById({studyId: query.studyId}, function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            setStudyData(result);
                            renderData(result, hash);
                        }
                    });
                }
            }

            $('#tab-introduction a').on('click', function (event) {
                event.preventDefault();
                $('#custom-modal').attr('data-help-items-key', 'introductionStudy');
                $('#custom-modal').attr('data-help-context', 'study');
                $('#custom-modal').attr('data-help-show-tutorial', parseInt(<?php echo $_SESSION['tutorialStudy'] ?>));
                loadHTMLintoModal('custom-modal', 'modal-introduction.php', 'modal-lg');
            });
        </script>
    </body>
</html>
