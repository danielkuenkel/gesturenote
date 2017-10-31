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
        <script src="js/gesture-recorder.js"></script>
        <script src="js/upload-queue.js"></script>

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
        <div id="template-general"></div>
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
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo $lang->breadcrump->gestureCatalog ?></li>
                </ol>
            </div>
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-pills" id="gesture-catalogs-nav-tab" style="display: flex; justify-content: center;">
            <li role="presentation"><a href="#gesture-catalog" aria-controls="gesture-catalog" role="tab" data-toggle="pill">Gesten-Katalog</a></li>
            <li role="presentation"><a href="#gesture-sets" aria-controls="gesture-sets" role="tab" data-toggle="pill">Gesten-Sets</a></li>
            <li role="presentation"><a href="#gesture-recorder-content" aria-controls="gesture-recorder-content" role="tab" data-toggle="pill">Gesten aufzeichnen</a></li>
        </ul> 


        <!--        <div class="container mainContent" style="margin-top: 0px;" id="item-view">
        
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
                                <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
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
        
        
                    <div class="text-center custom-pagination" id="pager-top">
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
        
                    <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                        <nav>
                            <ul class="pagination pagination-custom" itemprop="clipping_5">
                                <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>-->


        <div class="container mainContent" style="margin-top: 0px;">


            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane" id="study-gesture-set">
                    <div id="item-view">
                        <div>
                            <div class="form-group form-group-no-margin">
                                <div class="input-group">
                                    <span class="input-group-addon">Filter</span>
                                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                                    <div class="input-group-btn select filter" id="filter" role="group">
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
                                    <div class="input-group-btn select sort" id="sort" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li class="dropdown-header">Datum</li>
                                            <li id="oldest"><a href="#">Älteste zuerst</a></li>
                                            <li id="newest"><a href="#">Neueste zuerst</a></li>
                                            <li class="divider"></li>
                                            <li class="dropdown-header">Gestentitel</li>
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
                                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="16"/>
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
                                <ul class="pagination pagination-custom" itemprop="clipping_2">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>


                        <div class="container-root row root" id="gesture-list-container" style="margin-top: 10px;"></div>

                        <div class="alert-space alert-no-search-results"></div>
                        <div class="alert-space alert-no-gestures-assembled"></div>

                        <div class="text-center custom-pagination" id="pager-bottom" style="margin: 0">
                            <nav>
                                <ul class="pagination pagination-custom" itemprop="clipping_2">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>

                </div>

                <div role="tabpanel" class="tab-pane" id="gesture-catalog">
                    <div id="item-view">
                        <div>
                            <div class="form-group form-group-no-margin">
                                <div class="input-group">
                                    <span class="input-group-addon">Filter</span>
                                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Alle"/>
                                    <div class="input-group-btn select filter" id="filter" role="group">
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
                                    <div class="input-group-btn select sort" id="sort" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li class="dropdown-header">Datum</li>
                                            <li id="oldest"><a href="#">Älteste zuerst</a></li>
                                            <li id="newest"><a href="#">Neueste zuerst</a></li>
                                            <li class="divider"></li>
                                            <li class="dropdown-header">Gestentitel</li>
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
                                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="16"/>
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
                                <ul class="pagination pagination-custom" itemprop="clipping_5">
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
                                <ul class="pagination pagination-custom" itemprop="clipping_5">
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
                        <label class="text">Neues Gesten-Set anlegen</label>

                        <div class="alert-space alert-gesture-set-title-too-short"></div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="input-new-set-title" minlength="8" maxlength="60" placeholder="Name des Gesten-Sets (mindestens 8 Zeichen)">
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-add-gesture-set" type="button" id="btn-add-gesture-set"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div id="item-view">

                        <div>
                            <div class="form-group form-group-no-margin">
                                <div class="input-group">
                                    <span class="input-group-addon">Sortierung</span>
                                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="Neueste zuerst"/>
                                    <div class="input-group-btn select sort" id="sort" role="group">
                                        <button class="btn btn-default btn-shadow btn-dropdown dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 0px"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                        <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                            <li class="dropdown-header">Datum</li>
                                            <li id="oldest"><a href="#">Älteste zuerst</a></li>
                                            <li id="newest"><a href="#">Neueste zuerst</a></li>
                                            <li class="divider"></li>
                                            <li class="dropdown-header">Gestentitel</li>
                                            <li id="asc"><a href="#">A bis Z</a></li>
                                            <li id="desc"><a href="#">Z bis A</a></li>
                                        </ul>
                                    </div>
                                    <span class="input-group-addon">Einträge pro Seite</span>
                                    <input class="form-control item-input-text show-dropdown text-center readonly" tabindex="-1" type="text" value="4"/>
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
                            <div class="form-group form-group-margin-top">
                                <div class="input-group">
                                    <span class="input-group-addon">Suchen</span>
                                    <input class="form-control item-input-text search search-input" id="searched-input" autocomplete="off" type="search" value="" placeholder="Suchbegriff eingeben"/>

                                </div>
                            </div>
                        </div>

                        <div class="text-center custom-pagination" id="pager-top">
                            <nav>
                                <ul class="pagination pagination-custom" itemprop="clipping_2">
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
                                <ul class="pagination pagination-custom" itemprop="clipping_2">
                                    <li id="btn-first-page"><a href="#" aria-label="First"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-previous-page"><a href="#" aria-label="Previous"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                    <li id="btn-next-page"><a href="#" aria-label="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                                    <li id="btn-last-page"><a href="#" aria-label="Last"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="gesture-recorder-content"></div>

            </div>

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
                externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                externals.push(['#template-gesture', PATH_EXTERNALS + 'template-gesture.php']);
                externals.push(['#template-gesture-recorder', PATH_EXTERNALS + 'template-gesture-recorder.php']);
                loadExternals(externals);
            });
        });

        function onAllExternalsLoadedSuccessfully() {
            renderSubPageElements();
            $('#gesture-catalogs-nav-tab a[href="#gesture-catalog"]').tab('show');
            getWholeGestureCatalog();
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
            for (var i = viewFromIndex; i < viewToIndex; i++) {

                switch ($(currentActiveTab).attr('id')) {
                    case 'gesture-sets':
                        clone = getGestureCatalogGestureSetPanel(currentFilterData[i]);
                        $(currentFilterList).append(clone);
                        if (animate && animate === true) {
                            TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, y: -10});
                        }
                        break;
                    case 'gesture-catalog':
                        clone = getGestureCatalogListThumbnail(currentFilterData[i]);
                        $(currentFilterList).append(clone);
                        if (animate && animate === true) {
                            TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});
                        }
                        break;
                }
                count++;
            }
        }

        $('.filter').unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();
            if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
            } else {
                renderData(currentFilterData, true);
            }
        });

        $('.sort').unbind('change').bind('change', function (event) {
            console.log('sort changed', getCurrentActiveTab());
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();
            if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
            } else {
                renderData(currentFilterData, true);
            }
        });

        $('.resultsCountSelect').unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();
            if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
            } else {
                renderData(currentFilterData, true);
            }
        });

        $('body').on('indexChanged', '.pagination', function (event, index) {
            event.preventDefault();
            if (!event.handled) {
                event.handled = true;
                renderData(sort(), true);
            }
        });

        $('#gesture-catalogs-nav-tab').on('shown.bs.tab', function (event) {
            $($(event.target).attr('href')).find('#sort .achtive').removeClass('selected');
            resetRecorder();
            switch ($(event.target).attr('href')) {
                case '#gesture-catalog':
                    getWholeGestureCatalog();
                    break;
                case '#gesture-sets':
                    getWholeGestureSets();
                    break;
                case '#gesture-recorder-content':
                    getWholeGestureRecorder();
                    break;
            }
        });

        $('#gesture-catalogs-nav-tab').on('hide.bs.tab', function (event) {
//            console.log('hide', $(event.relatedTarget).attr('href'), $(event.target).attr('href'));
            closeGestureInfo($(event.target).attr('href'));
        });

        function getWholeGestureCatalog() {
            currentFilterList = $('#gesture-catalog').find('#gesture-list-container');
            currentFilterList.empty();

            getGestureCatalog(function (result) {
                if (result.status === RESULT_SUCCESS) {
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

            $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
                event.preventDefault();
                renderData(data);
            });
        }

        function getWholeGestureSets() {
            currentFilterList = $('#gesture-sets').find('#gesture-sets-container');
            currentFilterList.empty();

            getGestureSets(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    originalFilterData = result.gestureSets;
                    setLocalItem(GESTURE_SETS, result.gestureSets);

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
//                            filter: $('#gesture-sets').find('#filter'),
                                sort: $('#gesture-sets').find('#sort')
                            }
                        };
                        initPagination(data);
                        $('#gesture-sets').find('#sort #newest').removeClass('selected');
                        $('#gesture-sets').find('#sort #newest').click();
                    } else {
                        // show alert that no data is there
                    }
                }
            });

            $(currentFilterList).unbind('openGestureInfo').bind('openGestureInfo', function (event) {
                event.preventDefault();
                renderGestureInfoData();
                showGestureInfo($('#gesture-sets'));
            });
            
            $(currentFilterList).unbind('renderData').bind('renderData', function (event, data) {
                event.preventDefault();
                renderData(data);
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

        function getWholeGestureRecorder() {
            var recorder = $('#item-container-gesture-recorder').find('#gesture-recorder').clone().removeAttr('id');
            $('#gesture-recorder-content').empty().append(recorder);
            renderBodyJoints($(recorder).find('#human-body'));

            var options = {
                alertTarget: $('#gesture-recorder-content'),
                recorderTarget: recorder,
                saveGestures: true,
                checkType: true,
                checkInteractionType: true
            };

            new GestureRecorder(options);
        }

//        $('#btn-record-gesture').unbind('click').bind('click', function (event) {
//            event.preventDefault();
//            loadHTMLintoModal('custom-modal', 'create-gesture-recorder.php', 'modal-md');
//
//            $('#custom-modal').unbind('saveSuccess').bind('saveSuccess', function (event, gestureId) {
//                getGestureCatalog(function (result) {
//                    if (result.status === RESULT_SUCCESS) {
//                        originalFilterData = result.gestures;
//                        $('#sort #newest').removeClass('selected');
//                        $('#sort #newest').click();
//                    }
//                });
//            });
//
//            $('#custom-modal').unbind('deleteSuccess').bind('deleteSuccess', function (event, gestureId) {
//                getGestureCatalog(function (result) {
//                    if (result.status === RESULT_SUCCESS) {
//                        originalFilterData = result.gestures;
//                        $('#sort #newest').removeClass('selected');
//                        $('#sort #newest').click();
//                    }
//                });
//            });
//        });

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
    </script>

</body>
</html>