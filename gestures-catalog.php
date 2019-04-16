<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

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
        <title><?php echo $lang->gestureNoteGestureCatalog ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>

        <script src="js/sha512.js"></script>
        <script src="js/chance.min.js"></script>
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/gifshot/gifshot.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 
        <script src="js/randomColor/randomColor.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/gesture.css">

        <script src="js/refreshSession.js"></script>
        <script src="js/globalFunctions.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/storageFunctions.js"></script>
        <script src="js/language.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>       
        <script src="js/ajax.js"></script> 
        <script src="js/gesture.js"></script>
        <script src="js/joint-selection.js"></script>
        <script src="js/gesture-importer.js"></script>

        <script src="js/upload-queue.js"></script>
        <script src="js/gifshot/gifshot.min.js"></script>
        <script src="js/color-thief/color-thief.js"></script> 
        <script src="js/filesaver/FileSaver.min.js"></script>
        <script src="js/jszip/jszip.min.js"></script>
        <script src="js/jszip/jszip-utils.min.js"></script>

        <!-- leap and plugins -->
        <script src="js/leapjs/leap-0.6.4.min.js"></script>
        <script src="js/leapjs/leap-plugins-0.1.12.min.js"></script>
        <script src="js/three/three.min.js"></script>
        <script src="js/riggedHand/leap.rigged-hand-0.1.7.js"></script>
        <script src="js/leapjs-playback/leap.playback-0.2.1.js"></script>

        <!--gesture recorder--> 
        <script src="js/gestureRecorder/gestureRecorder.js"></script>
        <script src="js/gestureRecorder/webcamRecorder.js"></script>
        <script src="js/gestureRecorder/leapRecorder.js"></script>
        <script src="js/resumable/resumable.js"></script>

        <!-- peer connection with webrtc -->
        <script src="js/collaborativeVideo.js"></script>
        <script src="js/peerConnection.js"></script>
        <script src="js/andyet/simplewebrtc.bundle.js"></script>

        <!-- bootstrap slider -->
        <link rel="stylesheet" href="js/bootstrap-slider/css/bootstrap-slider.css">
        <script src="js/bootstrap-slider/js/bootstrap-slider.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>
        <div id="template-gesture"></div>
        <div id="template-general"></div>
        <div id="template-gesture-recorder"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root"></div>
            </div>
        </div>

        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-gesture-catalog"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->breadcrump->gestureCatalog ?></li>
                </ol>
            </div>
        </div>

        <div id="navigation-container" style="opacity: 0">
            <div class="container">
                <a role="button" class="pull-right" id="btn-introduction"><i class="fa fa-support"></i> <?php echo $lang->help ?></a>
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-pills" id="gesture-catalogs-nav-tab" style="display: flex; justify-content: center;">
                <li role="presentation" id="tab-catalog"><a href="#gesture-catalog" aria-controls="gesture-catalog" role="tab" data-toggle="pill"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->allGestures ?></a></li>
                <li role="presentation" id="tab-sets"><a href="#gesture-sets" aria-controls="gesture-sets" role="tab" data-toggle="pill"><i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo $lang->gestureSets ?></a></li>
                <li role="presentation" id="tab-recorder"><a href="#gesture-recorder" aria-controls="gesture-recorder" role="tab" data-toggle="pill"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php echo $lang->recordGestures ?></a></li>
                <li role="presentation" id="tab-import"><a href="#gesture-importer" aria-controls="gesture-importer" role="tab" data-toggle="pill"><i class="fa fa-file-zip-o" aria-hidden="true"></i> <?php echo $lang->gestureImporter ?></a></li>
            </ul> 
        </div>


        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>

        <div class="container mainContent hidden" id="gesture-catalog-content" style="margin-top: 0px;">


            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane" id="gesture-catalog">
                    <div id="item-view">
                        <div>
                            <div class="form-group form-group-no-margin">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                                    <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                                    <div class="input-group-btn select filter" id="filter" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                            <li id="recorded"><a href="#"><?php echo $lang->filter->ownRecorded ?></a></li>
                                            <li id="tester"><a href="#"><?php echo $lang->filter->tester ?></a></li>
                                            <li class="divider"></li>
                                            <li class="dropdown-header"><?php echo $lang->sorting->titleHeadline ?></li>
                                            <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                            <li id="sharedWithYou"><a href="#"><?php echo $lang->filter->sharedWithYou ?></a></li>
                                            <li id="private"><a href="#"><?php echo $lang->filter->private ?></a></li>
                                            <li id="rated"><a href="#"><?php echo $lang->filter->rated ?></a></li>
                                            <li id="liked"><a href="#"><?php echo $lang->filter->liked ?></a></li>
                                            <li id="generic"><a href="#"><?php echo $lang->gestureNameQualities->generic->title ?></a></li>
                                            <li id="functional"><a href="#"><?php echo $lang->gestureNameQualities->functional->title ?></a></li>
                                        </ul>
                                    </div>
                                    <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                                    <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
                                    <div class="input-group-btn select sort" id="sort" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li class="dropdown-header"><?php echo $lang->sorting->dateHeadline ?></li>
                                            <li id="oldest"><a href="#"><?php echo $lang->sorting->DESC ?></a></li>
                                            <li id="newest"><a href="#"><?php echo $lang->sorting->ASC ?></a></li>
                                            <li class="divider"></li>
                                            <li class="dropdown-header"><?php echo $lang->sorting->titleHeadline ?></li>
                                            <li id="asc"><a href="#"><?php echo $lang->sorting->AToZ ?></a></li>
                                            <li id="desc"><a href="#"><?php echo $lang->sorting->ZToA ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin-top">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $lang->search->name ?></span>
                                    <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="<?php echo $lang->search->placeHolder ?>"/>
                                    <span class="input-group-addon"><?php echo $lang->filterItems->name ?></span>
                                    <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="16"/>
                                    <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_16"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li id="results_8"><a href="#">8</a></li>
                                            <li id="results_16" class="selected"><a href="#">16</a></li>
                                            <li id="results_40"><a href="#">40</a></li>
                                            <li id="results_100"><a href="#">100</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center custom-pagination" id="pager-top">
                            <nav>
                                <ul class="pagination pagination-custom" data-clipping="7">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                        <div class="container-root row root" id="gesture-list-container" style="margin-top: 10px;"></div>

                        <div class="alert-space alert-no-search-results"></div>

                        <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                            <nav>
                                <ul class="pagination pagination-custom" data-clipping="7">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="gesture-sets">

                    <div class="create-gesture-set-input">
                        <label class="text"><?php echo $lang->createNewGestureSet ?></label>

                        <div class="alert-space alert-gesture-set-title-too-short"></div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="<?php echo $lang->createNewGestureSetPlaceholder ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-add-gesture-set btn-shadow" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div id="item-view">

                        <div>
                            <div class="form-group form-group-no-margin">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $lang->filter->name ?></span>
                                    <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->filter->all ?>"/>
                                    <div class="input-group-btn select filter" id="filter" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li id="all" class="selected"><a href="#"><?php echo $lang->filter->all ?></a></li>
                                            <li id="public"><a href="#"><?php echo $lang->filter->shared ?></a></li>
                                            <li id="sharedWithYou"><a href="#"><?php echo $lang->filter->sharedWithYou ?></a></li>
                                            <li id="private"><a href="#"><?php echo $lang->filter->private ?></a></li>
                                            <li id="liked"><a href="#"><?php echo $lang->filter->liked ?></a></li>
                                        </ul>
                                    </div>
                                    <span class="input-group-addon"><?php echo $lang->sorting->name ?></span>
                                    <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="<?php echo $lang->sorting->ASC ?>"/>
                                    <div class="input-group-btn select sort" id="sort" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li class="dropdown-header"><?php echo $lang->sorting->dateHeadline ?></li>
                                            <li id="oldest"><a href="#"><?php echo $lang->sorting->DESC ?></a></li>
                                            <li id="newest"><a href="#"><?php echo $lang->sorting->ASC ?></a></li>
                                            <li class="divider"></li>
                                            <li class="dropdown-header"><?php echo $lang->sorting->titleHeadline ?></li>
                                            <li id="asc"><a href="#"><?php echo $lang->sorting->AToZ ?></a></li>
                                            <li id="desc"><a href="#"><?php echo $lang->sorting->ZToA ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-margin-top">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $lang->search->name ?></span>
                                    <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="<?php echo $lang->search->placeHolder ?>"/>
                                    <span class="input-group-addon"><?php echo $lang->filterItems->name ?></span>
                                    <input class="form-control item-input-text text-center show-dropdown" tabindex="-1" type="text" value="4"/>
                                    <div class="input-group-btn select resultsCountSelect" id="resultsCountSelect" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_4"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li id="results_2"><a href="#">2</a></li>
                                            <li id="results_4" class="selected"><a href="#">4</a></li>
                                            <li id="results_10"><a href="#">10</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center custom-pagination" id="pager-top">
                            <nav>
                                <ul class="pagination pagination-custom" data-clipping="7">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                        <div class="container-root root" id="gesture-sets-container" style="margin-top: 10px;"></div>

                        <div class="alert-space alert-no-search-results"></div>

                        <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                            <nav>
                                <ul class="pagination pagination-custom" data-clipping="7">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="gesture-recorder"></div>

                <div role="tabpanel" class="tab-pane" id="gesture-importer"></div>

            </div>

        </div>

    </div>





    <div id="draggableCollaborativeRTC" class="hidden" style="position: fixed; z-index: 10002; top: 150px; left:100px; display: block; opacity: .7">
        <div style="width: 300px; border-radius: 5px" id="video-caller-container" class="shadow">
            <div class="embed-responsive embed-responsive-4by3" id="video-caller">

                <div class="embed-responsive-item" style="border-radius: 4px; background-color: #eee; display: flex; justify-content: center; align-items: center;">
                    <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                </div>

                <div id="remoteVideo" class="rtc-remote-container rtc-stream embed-responsive-item" style="border-radius: 4px;"></div>

                <div class="rtc-local-container embed-responsive-item">
                    <video autoplay id="localVideo" class="rtc-stream" style="position: relative; height: auto"></video>
                </div>

                <div class="btn-group" id="stream-controls" style="position: absolute; bottom: 6px; left: 50%; transform: translate(-50%, 0); opacity: 0">
                    <button type="button" class="btn btn-sm stream-control" id="btn-stream-local-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->muteMicrofone ?>"><i class="fa fa-microphone-slash"></i> </button>
                    <button type="button" class="btn btn-sm stream-control" id="btn-pause-stream" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOwnWebRTC ?>"><i class="fa fa-pause"></i> </button>
                    <button type="button" class="btn btn-sm stream-control disabled" id="btn-stream-remote-mute" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->pauseOtherWebRTC ?>"><i class="fa fa-volume-up"></i> </button>
                    <button type="button" class="btn btn-sm stream-control" id="btn-config-rtc" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo $lang->configRTC ?>"><i class="fa fa-cog"></i> </button>
                </div>

                <div id="stream-control-indicator">
                    <div style="position: absolute; top: 4px; display: block; left: 10px; opacity: 1; color: white">
                        <i id="mute-local-audio" class="hidden fa fa-microphone-slash" style="margin-right: 3px"></i>
                        <i id="pause-local-stream" class="hidden fa fa-pause"></i>
                    </div>
                    <div style="position: absolute; top: 4px; display: block; right: 10px; opacity: 1; color: white">
                        <i id="mute-remote-audio" class="hidden fa fa-microphone-slash"></i>
                        <i id="pause-remote-stream" class="hidden fa fa-pause" style="margin-left: 3px"></i>
                    </div>
                </div>

            </div>

            <div id="rtc-config-panel" class="hidden" style="border-radius: 4px; background-color: rgba(0,0,0,.4); padding: 15px 15px 0px 15px; position: absolute; top:0px; bottom:0px; left: 0px; right: 0px">
                <div class="form-group" id="video-input-select">
                    <label style="margin: 0; color: white"><?php echo $lang->chooseVideoInput ?></label><br>

                    <div class="input-group">
                        <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                        <div class="input-group-btn select select-video-input" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="audio-input-select">
                    <label style="margin: 0; color: white"><?php echo $lang->chooseAudioInput ?></label><br>

                    <div class="input-group">
                        <input class="form-control item-input-text show-dropdown" tabindex="-1" type="text" value=""/>
                        <div class="input-group-btn select select-audio-input" role="group">
                            <button class="btn btn-default btn-shadow dropdown-toggle disabled" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                            <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            </ul>
                        </div>
                    </div>
                </div>

                <button class="btn btn-default btn-block btn-shadow" id="btn-close-config"><i class="fa fa-check"></i></button>
            </div>

        </div>

        <img src="img/resize-white.png" id="resize-sign" style="position: absolute; bottom: 0; right: 0;"/>
        <div id="btn-leave-room" class="" style="font-size: 14pt; position: absolute; top: -5px; right: 4px; cursor: pointer; color: white; text-shadow: 0px 0px 3px rgba(0, 0, 0, 1.0);"><i class="fa fa-close"></i></div>

    </div>

    <script>
        var firstInit = true;
        $(document).ready(function () {
            checkDomain();
            keepSessionAlive();
            currentFilterList = $('#gestures-list-container');

            checkLanguage(function () {
                var externals = new Array();
                externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                loadExternals(externals);
            });
        });

        function onAllExternalsLoadedSuccessfully() {
            renderSubPageElements();
            animateBreadcrump();
            checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

            getGestureSets(function (setResults) {
                setLocalItem(GESTURE_SETS, setResults.gestureSets);
                var status = window.location.hash.substr(1);
                var statusNavMatch = getStatusNavMatch(status);
                if (status !== '' && statusNavMatch !== null && statusNavMatch !== 'catalog') {
                    $('#gesture-catalogs-nav-tab').find('#tab-' + statusNavMatch + ' a').click();
                    showPageContent();
                } else {
                    $('#gesture-catalogs-nav-tab').children().first().find('a').click();
                }

                var tutorials = <?php echo json_encode($_SESSION['tutorials']) ?>;
                console.log(tutorials);
                if (tutorials && tutorials.gestureCatalog && parseInt(tutorials.gestureCatalog) === 1) {
                    $('#btn-introduction').click();
                }
            });
        }

        function getStatusNavMatch(status) {
            var tabs = $('#gesture-catalogs-nav-tab').children();
            for (var i = 0; i < tabs.length; i++) {
                if ($(tabs[i]).attr('id') === 'tab-' + status) {
                    return status;
                }
            }
            return null;
        }

        function showPageContent() {
            $('#gesture-catalog-content').removeClass('hidden');
            TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                    $('#loading-indicator').remove();
                }});
            TweenMax.from($('#gesture-catalog-content'), .3, {delay: .3, opacity: 0});
            TweenMax.to($('#navigation-container'), .3, {delay: .3, opacity: 1});
        }

        var currentFilterList;
        function renderData(data, animate) {
            var currentActiveTab = getCurrentActiveTab();
            currentFilterData = data;
            $(currentFilterList).empty();

            var index = getCurrentPaginationIndex();
            var listCount = parseInt($(currentPaginationData.filter.countSelect).find('.chosen').attr('id').split('_')[1]);
            var viewFromIndex = index * listCount;
            var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
            var count = 0;
            var clone;

//            console.log('renderData', index, listCount, viewFromIndex, viewToIndex);

            if (currentFilterData.length > 0) {
                clearAlerts($(currentActiveTab).find('#item-view'));
                for (var i = viewFromIndex; i < viewToIndex; i++) {

                    switch ($(currentActiveTab).attr('id')) {
                        case 'gesture-sets':
//                            console.log('render gesture set:', currentFilterData);
                            clone = getGestureCatalogGestureSetPanel(currentFilterData[i]);
                            $(currentFilterList).append(clone);
                            break;
                        case 'gesture-catalog':
//                            console.log(i, currentFilterData[i]);
                            if (currentFilterData[i].setOnly === false) {
                                clone = getGestureCatalogListThumbnail(currentFilterData[i]);
                                $(currentFilterList).append(clone);
                            } else {
                                viewToIndex++;
                            }
                            break;
                    }
                    count++;
                }
            } else {
                appendAlert($(currentActiveTab).find('#item-view'), ALERT_NO_SEARCH_RESULTS);
                $(currentActiveTab).find('#item-view #pager-top .pagination').addClass('hidden');
                $(currentActiveTab).find('#item-view #pager-bottom .pagination').addClass('hidden');
            }

            $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
//                console.log('catched render data');
                event.preventDefault();
                renderData(data);
            });

            initPopover(300);
            firstInit = false;

            $('#custom-modal').unbind('gesture-deleted').bind('gesture-deleted', function () {
                var currentContent = $('#gesture-catalog-content').find('.tab-pane.active');
//                console.log($(currentContent).find('#pager-top'), $(currentContent).find('#pager-top').length, $(currentContent).find('#pager-top .pagination'), $(currentContent).find('#pager-top .pagination').length);
                if ($(currentContent).find('#pager-top .pagination') && $(currentContent).find('#pager-top .pagination').length > 0) {
                    checkPagination($(currentContent).find('#pager-top .pagination'), currentFilterData.length, parseInt($(currentContent).find('#resultsCountSelect .chosen').attr('id').split('_')[1]));
                    renderData(currentFilterData);
                }
            });
        }

        $('.filter').unbind('change').bind('change', function (event) {
            event.preventDefault();
            if (firstInit !== true) {
                currentFilterData = sort();
                updatePaginationItems();
                if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                    $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                } else {
                    renderData(currentFilterData, true);
                }
            }
        });

        $('.sort').unbind('change').bind('change', function (event) {
            event.preventDefault();
            if (firstInit !== true) {
                currentFilterData = sort();
                updatePaginationItems();
                if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                    $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                } else {
                    renderData(currentFilterData, true);
                }
            }
        });

        $('.resultsCountSelect').unbind('change').bind('change', function (event) {
            event.preventDefault();
            if (firstInit !== true) {
                currentFilterData = sort();
                updatePaginationItems();
                if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                    $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
                } else {
                    renderData(currentFilterData, true);
                }
            }
        });

        $('body').on('indexChanged', '.pagination', function (event, index) {
            event.preventDefault();
            if (!event.handled) {
                event.handled = true;
                if (firstInit !== true) {
                    renderData(sort(), true);
                }
            }
        });

        $('#gesture-catalogs-nav-tab').on('shown.bs.tab', function (event) {
            $($(event.target).attr('href')).find('#sort .achtive').removeClass('selected');
            if (gestureRecorder) {
                gestureRecorder.destroy();
                gestureRecorder = null;
            }

//            console.log('show tab', $(event.target).attr('href'));

            switch ($(event.target).attr('href')) {
                case '#gesture-catalog':
                    getWholeGestureCatalog();
                    break;
                case '#gesture-sets':
                    getWholeGestureSets();
                    break;
                case '#gesture-recorder':
                    getWholeGestureRecorder();
                    break;
                case '#gesture-importer':
                    getWholeGestureImporter();
                    break;
            }

            var activeTabId = $(event.target).parent().attr('id').split('-')[1];
            window.location.hash = activeTabId;
        });

        $('#gesture-catalogs-nav-tab').on('hide.bs.tab', function (event) {
            closeGestureInfo($(event.target).attr('href'));
        });

        function getWholeGestureCatalog() {
            currentFilterList = $('#gesture-catalog').find('#gesture-list-container');
            currentFilterList.empty();

//            console.log('get whole gesture catalog');

            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    showPageContent();
                    originalFilterData = result.gestures;
                    if (originalFilterData && originalFilterData.length > 0) {
                        var data = {
                            pager: {
                                top: $('#gesture-catalog #pager-top .pagination'),
                                bottom: $('#gesture-catalog #pager-bottom .pagination'),
                                dataLength: originalFilterData.length,
                                maxElements: parseInt($('#gesture-catalog').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                            },
                            filter: {
                                countSelect: $('#gesture-catalog').find('#resultsCountSelect'),
                                filter: $('#gesture-catalog').find('#filter'),
                                sort: $('#gesture-catalog').find('#sort')
                            }
                        };
                        initPagination(data);
                        $('#gesture-catalog').find('#sort #newest').removeClass('selected');
                        $('#gesture-catalog').find('#sort #newest').click();
                        currentFilterData = sort();
                        renderData(currentFilterData);
                    } else {
                        // show alert that no data is there
                    }
                }
            });

            $(currentFilterList).unbind('change').bind('change', function (event, gestureId, assemble) {
                event.preventDefault();
                if (assemble) {
                    assembleGesture(gestureId);
                } else {
                    reassembleGesture(gestureId);
                }
            });

            $(currentFilterList).unbind('openGestureInfo').bind('openGestureInfo', function (event) {
                event.preventDefault();
                gesturePreviewDeleteable = true;
                renderGestureInfoData();
                showGestureInfo($('#gesture-catalog'));
            });

//            $('#custom-modal').unbind('gestureSetsUpdated').bind('gestureSetsUpdated', function (event, gestureId) {
//                event.preventDefault();
//                console.log('gesture id', gestureId);
//                var thumbnail = $('#gesture-catalog').find('#' + gestureId);
//                var gestureSets = getLocalItem(GESTURE_SETS);
//                if (gestureSets) {
//                    var titles = "";
//                    for (var i = 0; i < gestureSets.length; i++) {
//                        var gestureSetIds = gestureSets[i].gestures;
//                        if (gestureSetIds) {
//                            for (var j = 0; j < gestureSetIds.length; j++) {
//                                if (parseInt(gestureId) === parseInt(gestureSetIds[j])) {
//                                    titles += '<div>' + gestureSets[i].title + '</div>';
//                                }
//                            }
//                        }
//                    }
//                    if (titles.length > 0) {
//                        thumbnail.find('.btn-edit-gesture-set').addClass('primary');
//                        thumbnail.find('.btn-edit-gesture-set').attr('data-content', titles);
//                    } else {
//                        thumbnail.find('.btn-edit-gesture-set').removeClass('primary');
//                        thumbnail.find('.btn-edit-gesture-set').attr('data-content', translation.notAssignedToGestureSet);
//                    }
//                }
//            });
        }

        function getWholeGestureSets() {
            currentFilterList = $('#gesture-sets').find('#gesture-sets-container');
            currentFilterList.empty();

            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
//                    setLocalItem(GESTURE_CATALOG, result.gestures);
                    getGestureSets(function (result) {

                        if (result.status === RESULT_SUCCESS) {
                            originalFilterData = result.gestureSets;
                            setLocalItem(GESTURE_SETS, result.gestureSets);
                            console.log('get gesture sets', result);

                            if (originalFilterData && originalFilterData.length > 0) {
                                var data = {
                                    pager: {
                                        top: $('#gesture-sets #pager-top .pagination'),
                                        bottom: $('#gesture-sets #pager-bottom .pagination'),
                                        dataLength: originalFilterData.length,
                                        maxElements: parseInt($('#gesture-sets').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                                    },
                                    filter: {
                                        countSelect: $('#gesture-sets').find('#resultsCountSelect'),
                                        filter: $('#gesture-sets').find('#filter'),
                                        sort: $('#gesture-sets').find('#sort')
                                    }
                                };
                                initPagination(data);
                                $('#gesture-sets').find('#sort #newest').removeClass('selected');
                                $('#gesture-sets').find('#sort #newest').click();
                                currentFilterData = sort();
                                renderData(currentFilterData);
                            } else {
                                // show alert that no data is there
                            }
                        }
                    });
                }
            });



            $(currentFilterList).unbind('openGestureInfo').bind('openGestureInfo', function (event) {
                event.preventDefault();
                renderGestureInfoData();
                showGestureInfo($('#gesture-sets'));
            });

            $('#gesture-sets .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event) {
                getWholeGestureSets();
            });

            $('#gesture-sets #gesture-sets-container').unbind('gestureSetDeleted').bind('gestureSetDeleted', function (event) {
                getWholeGestureSets();
            });

            $('#custom-modal').unbind('gestureSetsUpdated').bind('gestureSetsUpdated', function () {
                getWholeGestureSets();
            });
        }

        var gestureRecorder = null;
        function getWholeGestureRecorder() {
            var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder-with-introductions').clone().removeAttr('id');
            $('#gesture-recorder').empty().append(recorder);
            var query = getQueryParams(document.location.search);

            var options = {
                recorderTarget: recorder,
                alertTarget: $('#recorder-content'),
                saveGesture: true,
                checkType: true,
                checkInteractionType: true,
                showIntroduction: true,
                record: [
                    {type: 'webcam', autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true, videoSource: query.vSource ? query.vSource : null, allowConfig: true},
                    {type: 'leap', autoplayPlayback: true, autoplaySave: true, autoplaySaveSuccess: true}
                ]
            };

            gestureRecorder = new GestureRecorder(options);
        }

        function getWholeGestureImporter() {
            var importer = $('#template-gesture').find('#gesture-importer-template').clone().removeAttr('id');
            $('#gesture-importer').empty().append(importer);
            appendAlert($('#gesture-importer'), ALERT_NO_EXCHANGEABLE_FILE_SELECTED);
        }

        function getCurrentActiveTab() {
            return $($('#gesture-catalogs-nav-tab').find('.active a').attr('href'));
        }

        function showGestureInfo(currentActiveContent) {
            $(currentActiveContent).addClass('hidden');
            $('#gesture-info').removeClass('hidden');
            TweenMax.from($('#gesture-info'), .3, {x: 25, opacity: 0});
        }

        function closeGestureInfo(currentActiveContent) {
            currentPreviewGesture = null;
            gesturePreviewOpened = false;

            $(currentActiveContent).removeClass('hidden');
            $('#gesture-info').addClass('hidden');
            $('#add-to-gesture-set').addClass('hidden');
            TweenMax.from(currentActiveContent, .3, {x: -25, opacity: 0});
        }

        $('#btn-introduction').on('click', function (event) {
            event.preventDefault();

            var activeTab = $('#gesture-catalogs-nav-tab').find('.active a').attr('href');
            if (activeTab !== '#gesture-catalog') {
                switch (activeTab) {
                    case '#gesture-sets':
                        $('#custom-modal').attr('data-start-tab-id', 'gestureSets');
                        break;
                    case '#gesture-recorder':
                        $('#custom-modal').attr('data-start-tab-id', 'recordGestures');
                        break;
                    case '#gesture-importer':
                        $('#custom-modal').attr('data-start-tab-id', 'gestureImport');
                        break;
                }
            }

            $('#custom-modal').attr('data-help-items-key', 'introductionGestureCatalog');
            $('#custom-modal').attr('data-help-context', 'gestureCatalog');
            $('#custom-modal').attr('data-help-show-tutorial', parseInt(<?php echo $_SESSION['tutorialGestureCatalog'] ?>));
            loadHTMLintoModal('custom-modal', 'externals/modal-introduction.php', 'modal-lg');
        });
    </script>

</body>
</html>