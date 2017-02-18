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
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/gesture.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>

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

        <!-- gesture recorder sources -->
        <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
        <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
        <script src="https://cdn.webrtc-experiment.com/RecordRTC/Whammy.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>
        <div id="template-gesture"></div>
        <div id="template-gesture-recorder"></div>

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content root"></div>
            </div>
        </div>
        
        
        <div class="container" id="breadcrumb" style="padding-top: 40px">
            <div class="row">
                    <ol class="breadcrumb">
                        <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                        <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                        <li class="active"><?php echo $lang->breadcrump->gestureCatalog ?></li>
                    </ol>
                </div>
        </div>
        
        <!-- Container (Landing Section) -->
<!--        <div class="container-fluid bg-grey wall">
             Container (Breadcrump) 
            <div class="container" id="breadcrumb">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                        <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                        <li class="active"><?php echo $lang->breadcrump->gestureCatalog ?></li>
                    </ol>
                </div>
            </div>

            <div class="container text-center dropShadowText">
                <h1><i class="fa fa-sign-language" style="font-size: 60pt" aria-hidden="true"></i> GESTEN-KATALOG</h1>
                <p>Hier werden alle Gesten, die veröffentlicht wurden angezeigt. Zusätzlich werden hier auch die Gesten aufgelistet, die für eine Studie aufgezeichnet wurden, sei es vom Studien-Ersteller oder von einer Testperson. Private Gesten, z.B. von anderen Moderatoren werden dagegen nicht aufgelistet.</p>
                <p>Von anderen Moderatoren veröffentlichte Gesten können bewertet werden. Des Weiteren gibt es die Möglichkeit, über die Geste zu diskutieren.</p>
            </div>
        </div>-->

        <div class="container mainContent" style="margin-top: 0px;" id="item-view">

            <button type="button" class="btn btn-success btn-block btn-lg btn-shadow" id="btn-record-gesture"><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="btn-text">Neue Geste aufzeichnen</span></button>

            <div class="form-group form-group-no-margin" style="margin-top: 20px">
                <div class="input-group">
                    <span class="input-group-addon">Filter</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                    <div class="input-group-btn select" id="filter" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="all"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="all" class="selected"><a href="#">Alle</a></li>
                            <li id="recorded"><a href="#">Eigene Aufgezeichnete</a></li>
                            <li id="tester"><a href="#">Tester</a></li>
                            <li id="public"><a href="#">Öffentlich</a></li>
                        </ul>
                    </div>
                    <span class="input-group-addon">Sortierung</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                    <div class="input-group-btn select" id="sort" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="newest"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li class="dropdown-header">Datum</li>
                            <li id="oldest"><a href="#">Älteste zuerst</a></li>
                            <li id="newest"><a href="#">Neueste zuerst</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Titel</li>
                            <li id="asc"><a href="#">A bis Z</a></li>
                            <li id="desc"><a href="#">Z bis A</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-margin-top">
                <div class="input-group">
                    <span class="input-group-addon">Suchen</span>
                    <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>
                    <span class="input-group-addon">Einträge pro Seite</span>
                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="12"/>
                    <div class="input-group-btn select" id="resultsCountSelect" role="group">
                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="results_12"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                            <li id="results_6"><a href="#">6</a></li>
                            <li id="results_12" class="selected"><a href="#">12</a></li>
                            <li id="results_48"><a href="#">48</a></li>
                            <li id="results_96"><a href="#">96</a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="text-center custom-pagination" id="custom-pager">
                <nav>
                    <ul class="pagination pagination-custom hidden" itemprop="clipping_5">
                        <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                        <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                        <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                    </ul>
                </nav>
            </div>

            <div class="container-root row root" id="gestures-list-container" style="margin-top: 10px;"></div>

            <div class="alert-space alert-no-search-results"></div>
            <div class="alert-space alert-no-gestures"></div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            checkDomain();
            currentFilterList = $('#gestures-list-container');
            checkLanguage(function () {
                var externals = new Array();
                externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                loadExternals(externals);
            });
        });

        function onAllExternalsLoadedSuccessfully() {
            renderSubPageElements();

            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
//                    currentModalId = GESTURE_CATALOG;
                    if (result.gestures && result.gestures.length > 0) {
                        originalFilterData = result.gestures;
                        initPagination($('#custom-pager .pagination'), result.gestures.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
                        $('#sort #newest').click();
                    } else {
                        appendAlert($('#item-view'), ALERT_NO_GESTURES);
                    }
                }
            });
        }

        function renderData(data) {
            currentFilterData = data;
            $('#gestures-list-container').empty();
            clearAlerts($('#item-view'));
//            initPagination($('#gesture-pager .pagination'), currentFilterData.length, parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]));
            var index = parseInt($('#custom-pager .pagination').find('.active').text()) - 1;
            var listCount = parseInt($('#resultsCountSelect .chosen').attr('id').split('_')[1]);
            var viewFromIndex = index * listCount;
            var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);

            if (currentFilterData && currentFilterData.length > 0) {
                var count = 0;
                for (var i = viewFromIndex; i < viewToIndex; i++) {
                    var clone = getGestureCatalogListThumbnail(currentFilterData[i]);
                    $('#gestures-list-container').append(clone);
                    TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                    count++;
                }
            } else {
//                appendAlert($('#item-view'), ALERT_NO_SEARCH_RESULTS);
            }
        }

        $('#filter').unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();
            renderData(currentFilterData);

            if ($('#searched-input').val().trim() !== "") {
                $('#searched-input').trigger('keyup');
            }
        });

        $('#sort').unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();

            if ($('#searched-input').val().trim() !== "") {
                $('#searched-input').trigger('keyup');
            }
        });

        $('#resultsCountSelect').unbind('change').bind('change', function (event, id) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();

            if ($('#searched-input').val().trim() !== "") {
                $('#searched-input').trigger('keyup');
            }
        });

        $('#custom-pager .pagination').on('indexChanged', function (event) {
            event.preventDefault();
            if (!event.handled) {
                event.handled = true;
                renderData(sort());
            }
        });

        $('#btn-record-gesture').unbind('click').bind('click', function (event) {
            event.preventDefault();
            loadHTMLintoModal('custom-modal', 'create-gesture-recorder.php', 'modal-md');

            $('#custom-modal').unbind('saveSuccess').bind('saveSuccess', function (event, gestureId) {
                getGestureCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        originalFilterData = result.gestures;
                        $('#sort #newest').removeClass('selected');
                        $('#sort #newest').click();
                    }
                });
            });
            
            $('#custom-modal').unbind('deleteSuccess').bind('deleteSuccess', function (event, gestureId) {
                getGestureCatalog(function (result) {
                    if (result.status === RESULT_SUCCESS) {
                        originalFilterData = result.gestures;
                        $('#sort #newest').removeClass('selected');
                        $('#sort #newest').click();
                    }
                });
            });
        });
    </script>

</body>
</html>