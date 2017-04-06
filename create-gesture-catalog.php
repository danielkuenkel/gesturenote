<?php
include './includes/language.php';
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" onclick="onCloseClick()">&times;</button>

    <!-- Nav tabs -->
    <ul class="nav nav-pills" id="gesture-catalogs-nav-tab" style="display: flex; justify-content: center;">
        <li role="presentation"><a href="#study-gesture-set" aria-controls="study-gesture-set" role="tab" data-toggle="pill">Studien-Gesten-Set</a></li>
        <li role="presentation"><a href="#gesture-catalog" aria-controls="gesture-catalog" role="tab" data-toggle="pill">Gesten-Katalog</a></li>
        <li role="presentation"><a href="#gesture-sets" aria-controls="gesture-sets" role="tab" data-toggle="pill">Gesten-Sets</a></li>
        <li role="presentation"><a href="#gesture-recorder-content" aria-controls="gesture-recorder-content" role="tab" data-toggle="pill">Gesten aufzeichnen</a></li>
    </ul> 
</div>

<div id="modal-body" class="modal-body">

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
                <div class="alert-space alert-no-study-gestures-assembled"></div>

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






    <div class="hidden" id="gesture-info">
        <button type="button" class="btn btn-default" id="btn-back"><i class="fa fa-angle-left" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->previous ?></span></button>

        <div class="row" id="general-gesture-info" style="margin-top: 20px">
            <div class="col-md-5 root">
                <div class="previewGesture mouseScrollable btn-shadow autoplay"></div>
                <div class="progress gesture-progress">
                    <div class="progress-bar gesture-progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" id="btn-play-gesture"><i class="glyphicon glyphicon-play"></i></button>
                        <button type="button" class="btn btn-default" id="btn-stop-gesture"><i class="glyphicon glyphicon-stop"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-backward-gesture"><i class="glyphicon glyphicon-step-backward"></i></button>
                        <button type="button" class="btn btn-default" id="btn-step-forward-gesture"><i class="glyphicon glyphicon-step-forward"></i></button>
                    </div>
                </div>
                <hr>
                <div class="gesture-rating" id="gesture-rating" style="margin-top: 20px;">
                    <h3><i class="fa fa-star-o"></i> Bewertung</h3>
                    <div class="rating-container rating-physicalContext row" id="rating-physicalContext">
                        <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                        <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Gestentyp für Kontext stimmig? (z.B. Ganzkörper-Geste für Arbeitsplatz stimmig?)</span></div>
                    </div>
                    <div class="rating-container rating-adaption row" id="rating-adaption">
                        <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                        <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Kontext-Adaption (Könnte die Geste auch woanders eingesetzt werden?)</span></div>
                    </div>
                    <div class="rating-container rating-fittingTask row" id="rating-fittingTask">
                        <div class="col-xs-4 col-sm-3 col-md-5 rating-stars-container"></div>
                        <div class="col-xs-8 col-sm-9 col-md-7 rating-headling"><span class="address"></span> <span class="text">Passt die Geste zur beschriebenen Aufgabe?</span></div>
                    </div>
                    <div id="rating-infos">
                        <span id="rated-by"></span> <span id="rating-users-count"></span> <span id="rated-by-users"></span>
                        <div class="alert-space alert-rating-submitted" style="margin-top: 10px;"></div>
                    </div>
                    <button type="button" class="btn btn-block btn-warning" id="btn-rate-gesture" style="margin-top: 10px;">Geste bewerten</button>
                    <div class="btn-group-vertical btn-block hidden" id="rating-submit-buttons" style="margin-top: 0px;">
                        <button type="button" class="btn btn-success" id="btn-submit-gesture-rating">Bewertung abgeben</button>
                        <button type="button" class="btn btn-danger" id="btn-cancel-gesture-rating">Abbrechen</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h3 style="margin-top: 0"><i class="fa fa-bookmark-o"></i> Allgemeines</h3>
                <div id="gesture-data-preview">
                    <div id="created"><span class="address">Erstellt:</span> <span class="text"></span></div>
                    <div id="title">Titel:<span class="address"></span> <span class="text"></span></div>
                    <div id="type">Gesten-Typ:<span class="address"></span> <span class="text"></span></div>
                    <div id="interactionType">Gesten-Interaktions-Typ:<span class="address"></span> <span class="text"></span></div>
                    <div id="context">Kontext:<span class="address"></span> <span class="text"></span></div>
                    <div id="association">Assoziation:<span class="address"></span> <span class="text"></span></div>
                    <div id="description">Beschreibung:<span class="address"></span> <span class="text"></span></div>

                    <span class="label label-default" id="gesture-source"><i class="fa fa-globe hidden" id="tester"></i><i class="fa fa-video-camera hidden" id="own"></i><i class="fa fa-globe hidden" id="evaluator"></i> <span class="label-text"></span></span>
                    <span class="label label-default" id="gesture-scope"><i class="fa fa-lock hidden" id="private"></i><i class="fa fa-share-alt hidden" id="public"></i> <span class="label-text"></span></span>

                    <div class="preview-joints-humand-body" id="human-body" style="width: 400px; margin: auto; margin-top: 10px">
                        <div id="joint-container" style="position: absolute"></div>
                        <img src="img/human_body.svg">
                    </div>
                </div>

                <div id="gesture-data-edit" class="hidden">
                    <div class="alert-space alert-missing-fields"></div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureName ?></label>
                        <input type="text" class="form-control" id="gesture-name-input" required>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label><?php echo $lang->gestureType ?></label>
                        <div class="input-group">
                            <input class="form-control item-input-text option-gesture-type show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select gestureTypeSelect" role="group" id="gestureTypeSelect">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="0"><a href="#"><?php echo $lang->gestureTypes->pose ?></a></li>
                                    <li id="1"><a href="#"><?php echo $lang->gestureTypes->dynamic ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label><?php echo $lang->gestureInteractionType ?></label>
                        <div class="input-group">
                            <input class="form-control item-input-text option-gesture-interaction-type show-dropdown readonly" type="text" value="" placeholder="<?php echo $lang->pleaseSelect ?>"/>
                            <div class="input-group-btn select gestureInteractionTypeSelect" role="group" id="gestureInteractionTypeSelect">
                                <button class="btn btn-default btn-shadow dropdown-toggle" type="button" data-toggle="dropdown"><span class="chosen hidden" id="unselected"></span><span class="caret"></span></button>
                                <ul class="dropdown-menu option dropdown-menu-right" role="menu">
                                    <li id="0"><a href="#"><?php echo $lang->gestureInteractionTypes->discrete ?></a></li>
                                    <li id="1"><a href="#"><?php echo $lang->gestureInteractionTypes->continuous ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureContext ?></label>
                        <input type="text" class="form-control" placeholder="Wo soll die Geste eingesetzt werden?" id="gesture-context-input" required>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureAssociation ?></label>
                        <textarea class="form-control" id="gesture-association-input" rows="3" maxlength="500" required></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureDescription ?></label>
                        <textarea class="form-control" id="gesture-description-input" rows="3" maxlength="500" required></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php echo $lang->gestureGraphicsQuestion ?></label>
                        <div class="select-joints-humand-body" id="select-joints-human-body" style="width: 400px; margin: auto; margin-top: 10px">
                            <div id="joint-container" style="position: absolute"></div>
                            <img src="img/human_body.svg">
                        </div>
                    </div>
                </div>

                <div class="btn-group-vertical btn-block" style="margin-top: 20px" id="gesture-owner-controls">
                    <button type="button" class="btn btn-default gesture-previewable" id="btn-edit-gesture"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="btn-text"></span></button>
                    <button type="button" class="btn btn-info" id="btn-share-gesture"><i class="fa" aria-hidden="true"></i> <span class="btn-text"></span></button>
                    <button type="button" class="btn btn-danger" id="btn-delete-gesture"><i class="fa fa-trash" aria-hidden="true"></i> <span class="btn-text">Geste löschen</span></button>
                </div>

            </div>
        </div>

        <hr style="">

        <div id="gesture-set-body">
            <div id="attached-gesture-sets" style="margin-top: 30px; margin-bottom: 30px">
                <h3><i class="fa fa-paperclip"></i> Zuweisung zu Gesten-Sets</h3>
   
                <div id="add-to-gesture-set">
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

                    <div class="row text-center" style="margin-top: 10px">
                        <label class="uppercase" style="font-size: 10pt"><?php echo $lang->or ?></label>
                    </div>

                    <div style="margin-top: 0px">
                        <label class="text">Zu vorhandenen Gesten-Sets zuweisen</label>

                        <div id="existing-sets-container">
                            <div class="option-container root"></div>
                        </div>
                        <div class="alert-space alert-no-gesture-sets-for-study"></div>
                    </div>

                </div>
            </div>
        </div>

        <hr style="">

        <div id="discussion-body" class="row">
            <div class="col-xs-12">
                <h3 style="margin-bottom: 20px"><i class="fa fa-comments-o" aria-hidden="true"></i> Mitreden</h3>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <textarea class="form-control" id="comment" rows="4" maxlength="500" placeholder="Kommentar einfügen" required></textarea>
                </div>
                <button type="button" class="btn btn-default btn-block" id="btn-comment-gesture"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="btn-text">Kommentar abschicken</span></button>
            </div>
            <div class="col-md-7">
                <div class="alert-space alert-no-comments"></div>
                <div id="comments-list"></div>
            </div>
        </div>

    </div>

    <!--    <div class="hidden" id="add-to-gesture-set">
            <button type="button" class="btn btn-default" id="btn-back"><i class="fa fa-angle-left" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->previous ?></span></button>
    
            <div style="margin-top: 20px">
                <label class="text">Zu vorhandenen Gesten-Sets zuweisen</label>
    
                <div id="existing-sets-container">
                    <div class="option-container root"></div>
                </div>
                <div class="alert-space alert-no-gesture-sets-for-study"></div>
            </div>
    
            <div class="row text-center">
                <label class="uppercase" style="font-size: 10pt"><?php echo $lang->or ?></label>
            </div>
    
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
        </div>-->


</div>
<div id="modal-footer" class="modal-footer">
    <button type="button" class="btn btn-default btn-shadow" data-dismiss="modal" onclick="onCloseClick()"><i class="fa fa-close"></i> <?php echo $lang->close ?></button>
</div>


<script src="js/gesture-recorder.js"></script>
<script src="js/upload-queue.js"></script>
<script>
        var currentFilterList;
        function renderData(data) {
            var currentActiveTab = getCurrentActiveTab();

            currentFilterData = data;
            $(currentFilterList).empty();
            var index = getCurrentPaginationIndex();
            var listCount = parseInt($(currentPaginationData.filter.countSelect).find('.chosen').attr('id').split('_')[1]);
            var viewFromIndex = index * listCount;
            var viewToIndex = Math.min((index + 1) * listCount, currentFilterData.length);
            var count = 0;
            var clone, isGestureAss;
            for (var i = viewFromIndex; i < viewToIndex; i++) {

                switch ($(currentActiveTab).attr('id')) {
                    case 'gesture-sets':
                        clone = getGestureSetPanel(currentFilterData[i]);
                        $(currentFilterList).append(clone);
                        TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, y: -10});
                        break;
                    case 'study-gesture-set':
                    case 'gesture-catalog':
                        isGestureAss = isGestureAssembled(currentFilterData[i].id);
                        clone = getCreateStudyGestureListThumbnail(currentFilterData[i], 'favorite-gesture-catalog-thumbnail', 'col-xs-6 col-md-3', null, isGestureAss ? 'panel-success' : null);
                        $(currentFilterList).append(clone);
                        TweenMax.from(clone, .2, {delay: count * .03, opacity: 0, scaleX: 0.5, scaleY: 0.5});

                        if (isGestureAss) {
                            clone.find('#btn-tag-as-favorite-gesture').addClass('selected btn-success');
                        }
                        break;
                }
                count++;
            }
        }

        function saveData() {}

        $('.filter').unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();
            if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
            } else {
                renderData(currentFilterData);
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
                renderData(currentFilterData);
            }
        });

        $('.resultsCountSelect').unbind('change').bind('change', function (event) {
            event.preventDefault();
            currentFilterData = sort();
            updatePaginationItems();
            if ($(currentFilterList).closest('#item-view').find('#searched-input').val().trim() !== "") {
                $(currentFilterList).closest('#item-view').find('#searched-input').trigger('keyup');
            } else {
                renderData(currentFilterData);
            }
        });

        $('body').unbind('indexChanged').bind('indexChanged', '.pagination', function (event, index) {
            event.preventDefault();
            console.log('index changed');
            if (!event.handled) {
                event.handled = true;
                renderData(sort());
            }
        });


        $('#gesture-catalogs-nav-tab').on('shown.bs.tab', function (event) {
            $($(event.target).attr('href')).find('#sort .achtive').removeClass('selected');
            resetRecorder();
            switch ($(event.target).attr('href')) {
                case '#study-gesture-set':
                    getWholeStudyGestures();
                    break;
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
            console.log('hide', $(event.relatedTarget).attr('href'), $(event.target).attr('href'));
            closeGestureInfo($(event.target).attr('href'));
        });

        function getWholeStudyGestures() {
            currentFilterList = $('#study-gesture-set').find('#gesture-list-container');
            currentFilterList.empty();
            originalFilterData = assembledGestures();

            if (originalFilterData && originalFilterData.length > 0) {
                clearAlerts($('#study-gesture-set'));
                var data = {
                    pager: {
                        top: $('#study-gesture-set #pager-top .pagination'),
                        bottom: $('#study-gesture-set #pager-bottom .pagination'),
                        dataLength: originalFilterData.length,
                        maxElements: parseInt($('#study-gesture-set').find('#resultsCountSelect .chosen').attr('id').split('_')[1])
                    },
                    filter: {
                        countSelect: $('#study-gesture-set').find('#resultsCountSelect'),
                        filter: $('#study-gesture-set').find('#filter'),
                        sort: $('#study-gesture-set').find('#sort')
                    }
                };

                initPagination(data);

                $(currentFilterList).unbind('change').bind('change', function (event, gestureId, assemble) {
                    console.log('study gestures changed', gestureId);
                    reassembleGesture(gestureId);
                    originalFilterData = assembledGestures();

                    if (originalFilterData && originalFilterData.length > 0) {
                        currentFilterData = sort();
                        updatePaginationItems();
                        renderData(originalFilterData);
                    } else {
                        currentFilterList.empty();
                        $('#study-gesture-set #pager-top .pagination').addClass('hidden');
                        $('#study-gesture-set #pager-bottom .pagination').addClass('hidden');
                        appendAlert($('#study-gesture-set'), ALERT_NO_STUDY_GESTURES_ASSEMBLED);
                    }
                });

                $(currentFilterList).unbind('openGestureInfo').bind('openGestureInfo', function (event) {
                    event.preventDefault();
//                gesturePreviewDeleteable = true;
                    renderGestureInfoData();
                    showGestureInfo($('#study-gesture-set'));
                });

                $('#study-gesture-set').find('#sort #newest').removeClass('selected');
                $('#study-gesture-set').find('#sort #newest').click();
            } else {
                $('#study-gesture-set #pager-top .pagination').addClass('hidden');
                $('#study-gesture-set #pager-bottom .pagination').addClass('hidden');
                appendAlert($('#study-gesture-set'), ALERT_NO_STUDY_GESTURES_ASSEMBLED);
            }
        }

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
                renderGestureInfoData();
                showGestureInfo($('#gesture-sets'));
            });

            $('#gesture-sets .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event) {
                getWholeGestureSets();
            });

            $('#gesture-sets #gesture-sets-container').unbind('gestureSetDeleted').bind('gestureSetDeleted', function (event) {
                console.log('gesture set deleted');
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
//            $('#add-to-gesture-set').addClass('hidden');
            TweenMax.from(currentActiveContent, .3, {x: -25, opacity: 0});
        }

        $('#gesture-info').find('#btn-back').unbind('click').bind('click', function (event) {
            closeGestureInfo(getCurrentActiveTab());
        });

        $(document).ready(function () {
            $('#custom-modal').bind('hidden.bs.modal', function () {
                updateCatalogButtons();
                resetRecorder();
                $(this).unbind('hidden.bs.modal');
                closeGestureInfo(getCurrentActiveTab());
            });

            getGestureSets(function (result) {
                if (result.status === RESULT_SUCCESS) {
                    setLocalItem(GESTURE_SETS, result.gestureSets);
                    initGestureRating($('#gesture-rating'), 5);
                    $('#gesture-catalogs-nav-tab a[href="#study-gesture-set"]').tab('show');
                    getWholeStudyGestures();
                }
            });
        });

        function getCurrentActiveTab() {
            return $($('#gesture-catalogs-nav-tab').find('.active a').attr('href'));
        }






        /*
         * gesture set adding and attached rendering
         */

        function renderAttachedGestureSets(preselect, id) {

            var sets = getLocalItem(GESTURE_SETS);

            if (sets && sets !== null && sets !== '' && sets.length > 0) {
                var container = $('#add-to-gesture-set #existing-sets-container');
                container.find('.option-container').empty();
                $(container).unbind('change');

                for (var i = 0; i < sets.length; i++) {
                    var option = $('#create-item-container-inputs').find('#checkbox').clone();
                    option.find('.option-text').text(sets[i].title);
                    option.find('.btn-checkbox').attr('id', sets[i].id);
                    container.find('.option-container').append(option);
                    container.find('.option-container').append(document.createElement('br'));

                    // preselect item after adding new gesture set
                    if (preselect === true && id && parseInt(id) === parseInt(sets[i].id)) {
                        option.find('.btn-checkbox').click();
                        saveGestureSets();
                    }

                    // check gestures and make checkbox selected if gesture is in gesture set [i]
                    if (sets[i].gestures && sets[i].gestures.length > 0) {
                        if (checkSetAssignment(sets[i].gestures, currentPreviewGesture.gesture.id)) {
                            option.find('.btn-checkbox').click();
                        }
                    }
                }

                $('#add-to-gesture-set .create-gesture-set-input').unbind('gestureSetCreated').bind('gestureSetCreated', function (event, newSetId) {
                    event.preventDefault();
                    getGestureSets(function (result) {
                        if (result.status === RESULT_SUCCESS) {
                            setLocalItem(GESTURE_SETS, result.gestureSets);
                            renderAttachedGestureSets(true, newSetId);
                        }
                    });
                });

                $(container).bind('change', function (event) {
                    event.preventDefault();
                    saveGestureSets();
                });

                function saveGestureSets() {
                    var listItems = $(container).find('.option-container').find('.btn-checkbox');
                    for (var i = 0; i < listItems.length; i++) {
                        var setId = $(listItems[i]).attr('id');
                        if ($(listItems[i]).hasClass('btn-option-checked')) {
                            addToGestureSet(setId, currentPreviewGesture.gesture.id);
                        } else {
                            removeFromGestureSet(setId, currentPreviewGesture.gesture.id);
                        }
                    }

                    // call ajax update gesture sets, calling php 
                    updateGestureSets({sets: getLocalItem(GESTURE_SETS)}, function (result) {
                        getWholeGestureSets();
                    });
                }
            } else {
                appendAlert($('#add-to-gesture-set'), ALERT_NO_GESTURE_SETS_FOR_STUDY);
            }
        }




        /*
         * gesture info panel
         */

        var testRatings = [{physicalContext: 1, adaption: 0, fittingTask: 3}, {physicalContext: 0, adaption: 3, fittingTask: 4}, {physicalContext: 2, adaption: 0, fittingTask: 3}, {physicalContext: 2, adaption: 2, fittingTask: 3}, {physicalContext: 2, adaption: 1, fittingTask: 1}];
        var currentRatings = [{physicalContext: 0, adaption: 0, fittingTask: 0}];
//    $(document).ready(function () {
//        
//        renderModalData();
////        renderGestureRating($('#gesture-rating'), testRatings, true); //result.ratings);
//
//        $('#custom-modal').bind('hidden.bs.modal', function () {
//            currentPreviewGesture = null;
//            gesturePreviewOpened = false;
//            $(this).unbind('hidden.bs.modal');
//        });
//    });

        $('#gesture-info').unbind('gestureDeleted').bind('gestureDeleted', function (event) {
            getWholeGestureCatalog();
            closeGestureInfo(getCurrentActiveTab());
        });

        $(document).on('mouseleave', '.rating-stars-container', function (event) {
            event.preventDefault();
            if ($(this).find('.active').length === 0) {
                $(this).find('.btn-gesture-rating-clickable .fa').removeClass('fa-star').addClass('fa-star-o');
            } else {
                $(this).find('.active').find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(this).find('.active').prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(this).find('.active').nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
            }
        });

        $(document).on('mouseenter', '.btn-gesture-rating-clickable', function (event) {
            event.preventDefault();
            $(this).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
            $(this).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
        });

        $(document).on('click', '.btn-gesture-rating-clickable', function (event) {
            event.preventDefault();
            if (!event.handled) {
                event.handled = true;
                $(this).addClass('active');
                $(this).prevAll().removeClass('active');
                $(this).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star');
                $(this).nextAll().removeClass('active');
                $(this).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');
            }
        });

        $('#btn-rate-gesture').on('click', function (event) {
            event.preventDefault();
            if (!event.handled && !$(this).hasClass('disabled')) {
                $(this).addClass('hidden');
                $(this).closest('.gesture-rating').find('#rating-submit-buttons').removeClass('hidden');
                $(this).closest('.gesture-rating').find('.btn-gesture-rating .fa').removeClass('fa-star-half-full fa-star').addClass('fa-star-o');
                $(this).closest('.gesture-rating').find('.btn-gesture-rating').addClass('btn-gesture-rating-clickable');
            }
        });

        $('#btn-cancel-gesture-rating').on('click', function (event) {
            event.preventDefault();
            if (!event.handled && !$(this).hasClass('disabled')) {
                $(this).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
                $(this).closest('.gesture-rating').find('#btn-rate-gesture').removeClass('hidden');
                $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
                console.log(currentRatings);
                renderGestureRating($(this).closest('.gesture-rating'), currentRatings, false);
            }
        });

        $('#btn-submit-gesture-rating').on('click', function (event) {
            event.preventDefault();
            if (!event.handled && !$(this).hasClass('disabled')) {
                event.handled = true;
                var activeStars = $(this).closest('.gesture-rating').find('.active');
                var container = $(this).closest('.gesture-rating').find('.rating-container');
                var button = $(this);

                if (activeStars.length === container.length) {
                    $(button).addClass('disabled');
                    $(this).closest('.gesture-rating').find('#btn-cancel-gesture-rating').addClass('disabled');
                    $(this).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable');
                    var ratings = {};

                    for (var i = 0; i < container.length; i++) {
                        var id = $(container[i]).attr('id').split('-')[1];
                        var rating = $(container[i]).find('.active').index();
                        ratings[id] = rating;
                    }

                    submitRatingForGesture({gestureId: currentPreviewGesture.gesture.id, ratings: ratings}, function (result) {
                        $(button).removeClass('disabled');
                        $(button).closest('.gesture-rating').find('#btn-cancel-gesture-rating').removeClass('disabled');

                        if (result.status === RESULT_SUCCESS) {
                            $(button).closest('.gesture-rating').find('#btn-rate-gesture').remove();
                            $(button).closest('.gesture-rating').find('#rating-submit-buttons').addClass('hidden');
                            $(button).closest('.gesture-rating').find('.btn-gesture-rating').removeClass('btn-gesture-rating-clickable active');
                            renderGestureRating($(button).closest('.gesture-rating'), result.ratings, true);
                            appendAlert($('#gesture-rating'), ALERT_RATING_SUBMITTED);
                        }
                    });
                }
            }
        });

        function initGestureRating(target, totalStars) {
            for (var i = 0; i < totalStars; i++) {
                var ratingButton = document.createElement('div');
                $(ratingButton).addClass('btn-gesture-rating');
                var emptyStar = document.createElement('i');
                $(emptyStar).addClass('fa fa-star-o');
                $(ratingButton).append(emptyStar);
                $(target).find('.rating-stars-container').append(ratingButton);
            }

            $('#rated-by').text(translation.ratedBy);
        }

        function renderGestureRating(target, ratings, newData) {
            if (newData) {
                $('#rating-users-count').text(ratings !== null ? ratings.length : 0);
                if (ratings === null) {
                    $('#rated-by-users').text(translation.ratedByUsers);
                } else {
                    $('#rated-by-users').text(ratings.length === 1 ? translation.ratedByUser : translation.ratedByUsers);
                }

                ratings = calculateRatings(ratings);
            }

            currentRatings = ratings;
//        console.log()

            if (ratings) {
                for (var key in ratings) {
                    var value = parseFloat(ratings[key]) + 1;
                    var viewValue;
                    if (value % .5 === 0) {
                        viewValue = value;
                    } else if ((value % 1 >= .25 && value % 1 < .5) || (value % 1 <= .75 && value % 1 > .5)) {
                        viewValue = Math.floor(value) + .5;
                    } else {
                        viewValue = Math.round(value);
                    }

                    var container = $(target).find('.rating-' + key + ' .rating-stars-container');
                    var fullStars = parseInt(Math.abs(viewValue));
                    var hasHalfStar = viewValue % 1 === .5;
                    var nthStar = container.find(".btn-gesture-rating:nth-child(" + fullStars + ")");
                    $(nthStar).prevAll().find('.fa').removeClass('fa-star-o').addClass('fa-star');
                    $(nthStar).find('.fa').removeClass('fa-star-o').addClass('fa-star');
                    $(nthStar).nextAll().find('.fa').removeClass('fa-star').addClass('fa-star-o');

                    if (hasHalfStar) {
                        $(nthStar).next().find('.fa').removeClass('fa-star-o').addClass('fa-star-half-full');
                    }
                }
            } else {
                $(target).find('.btn-gesture-rating .fa').removeClass('fa-star-half-full fa-star').addClass('fa-star-o');
            }
        }

        function calculateRatings(ratingsArray) {
            var ratings = {physicalContext: 0, adaption: 0, fittingTask: 0};
            if (ratingsArray && ratingsArray.length > 0) {
                for (var key in ratings) {
                    for (var i = 0; i < ratingsArray.length; i++) {
                        var currentRating = ratings[key];
                        ratings[key] = currentRating + parseInt(ratingsArray[i].ratings[key]);
                    }
                    ratings[key] = ratings[key] / ratingsArray.length;
                }
                return ratings;
            }
            return null;
        }

        function renderGestureInfoData() {
            var gesture = getGestureById(currentPreviewGesture.gesture.id, currentPreviewGesture.source);
            if (gesture === null) {
                return false;
            }
            console.log('renderGestureInfoData', gesture);

            var container = $('#gesture-info');
            container.find('#created .text').text(convertSQLTimestampToDate(gesture.created).toLocaleString());
            container.find('#title .text').text(gesture.title);
            container.find('#type .text').text(getGestureType(gesture.type));
            container.find('#interactionType .text').text(getGestureInteractionType(gesture.interactionType));
            container.find('#context .text').text(gesture.context);
            container.find('#association .text').text(gesture.association === null ? '-' : gesture.association);
            container.find('#description .text').text(gesture.description);
            container.find('#btn-edit-gesture .btn-text').text(translation.edit);
            container.find('#btn-delete-gesture .btn-text').text(translation.deleteGesture);
            container.find('#gesture-source .fa').addClass('hidden');
            container.find('#gesture-scope .fa').addClass('hidden');
            container.find('#gesture-scope .label-text').text(translation.gestureScopes[gesture.scope]);
            container.find('#gesture-scope #' + gesture.scope).removeClass('hidden');
            var shareButton = $(container).find('#btn-share-gesture');

            if (gesture.isOwner === true) {
                $(container).find('#gesture-rating #btn-rate-gesture').addClass('hidden');
                $(container).find('#gesture-owner-controls').removeClass('hidden');

                if (gesture.scope === SCOPE_GESTURE_PRIVATE) {
                    shareButton.removeClass('unshare-gesture').addClass('share-gesture');
                    shareButton.find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
                    shareButton.find('.btn-text').text(translation.share);
                } else {
                    shareButton.removeClass('share-gesture').addClass('unshare-gesture');
                    shareButton.find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
                    shareButton.find('.btn-text').text(translation.unshare);
                }

                if (gesture.source !== SOURCE_GESTURE_TESTER) {
                    container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_OWN]);
                    container.find('#gesture-source #' + SOURCE_GESTURE_OWN).removeClass('hidden');
                } else {
                    container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                    container.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
                }
            } else {
                $(container).find('#gesture-owner-controls').addClass('hidden');
                $(container).find('#gesture-rating #btn-rate-gesture').removeClass('hidden');

                if (gesture.source !== SOURCE_GESTURE_TESTER) {
                    container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_EVALUATOR]);
                    container.find('#gesture-source #' + SOURCE_GESTURE_EVALUATOR).removeClass('hidden');
                } else {
                    container.find('#gesture-source .label-text').text(translation.gestureSources[SOURCE_GESTURE_TESTER]);
                    container.find('#gesture-source #' + SOURCE_GESTURE_TESTER).removeClass('hidden');
                }
            }

            renderGestureImages(container.find('.previewGesture'), gesture.images, gesture.previewImage, null);
            renderBodyJointsPreview(container.find('#human-body'), gesture.joints);

            var thumbnail = $(currentFilterList).find('#' + currentPreviewGesture.gesture.id);

            $(container).find('#btn-share-gesture').unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
                event.preventDefault();
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('disabled');
                    var button = $(this);

                    if ($(this).hasClass('share-gesture')) {
                        showCursor($('body'), CURSOR_PROGRESS);
                        shareGesture({gestureId: event.data.gestureId}, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                $(button).removeClass('share-gesture').addClass('unshare-gesture');
                                $(button).find('.fa').removeClass('fa-share-alt').addClass('fa-lock');
                                $(button).find('.btn-text').text(translation.unshare);
                                $(container).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
                                $(container).find('#gesture-scope .fa').addClass('hidden');
                                $(container).find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');

                                $(thumbnail).find('#btn-share-gesture').removeClass('share-gesture').addClass('unshare-gesture');
                                $(thumbnail).find('#btn-share-gesture .fa').removeClass('fa-share-alt').addClass('fa-lock');
                                $(thumbnail).find('#btn-share-gesture .btn-text').text(translation.unshare);
                                $(thumbnail).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PUBLIC]);
                                $(thumbnail).find('#gesture-scope .fa').addClass('hidden');
                                $(thumbnail).find('#gesture-scope #' + SCOPE_GESTURE_PUBLIC).removeClass('hidden');

                                updateGestureById(currentPreviewGesture.source, result.id, {scope: 'public'});
                                originalFilterData = getLocalItem(currentPreviewGesture.source);
                                currentFilterData = sort();
                            }
                        });
                    } else if ($(this).hasClass('unshare-gesture')) {
                        showCursor($('body'), CURSOR_PROGRESS);
                        unshareGesture({gestureId: event.data.gestureId}, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                $(button).removeClass('unshare-gesture').addClass('share-gesture');
                                $(button).find('.fa').removeClass('fa-lock').addClass('fa-share-alt');
                                $(button).find('.btn-text').text(translation.share);
                                $(container).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
                                $(container).find('#gesture-scope .fa').addClass('hidden');
                                $(container).find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');

                                $(thumbnail).find('#btn-share-gesture').removeClass('unshare-gesture').addClass('share-gesture');
                                $(thumbnail).find('#btn-share-gesture .fa').removeClass('fa-lock').addClass('fa-share-alt');
                                $(thumbnail).find('#btn-share-gesture .btn-text').text(translation.share);
                                $(thumbnail).find('#gesture-scope .label-text').text(translation.gestureScopes[SCOPE_GESTURE_PRIVATE]);
                                $(thumbnail).find('#gesture-scope .fa').addClass('hidden');
                                $(thumbnail).find('#gesture-scope #' + SCOPE_GESTURE_PRIVATE).removeClass('hidden');

                                updateGestureById(currentPreviewGesture.source, result.id, {scope: 'private'});
                                originalFilterData = getLocalItem(currentPreviewGesture.source);
                                currentFilterData = sort();
                            }
                        });
                    }
                }
            });

            getGestureInfos({gestureId: gesture.id}, function (result) {
                if (result.status === RESULT_SUCCESS) {
                    renderComments(result.comments);
                    renderGestureRating($('#gesture-rating'), result.ratings, true);
                    if (hasUserRatedGesture(result.userId, result.ratings)) {
                        $(container).find('#gesture-rating #btn-rate-gesture').remove();
                    }
                }
            });

            $('#discussion-body #btn-comment-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var comment = $('#discussion-body #comment').val().trim();
                if (comment !== '') {
                    var button = $(this);
                    $(button).addClass('disabled');
                    showCursor($('body'), CURSOR_PROGRESS);
                    submitCommentForGesture({gestureId: gesture.id, comment: comment}, function (result) {
                        showCursor($('body'), CURSOR_DEFAULT);
                        $(button).removeClass('disabled');
                        if (result.status === RESULT_SUCCESS) {
                            $('#discussion-body #comment').val('');
                            renderComments(result.comments);
                        }
                    });
                }
            });

            $(container).find('#btn-edit-gesture').unbind('click').bind('click', function (event) {
                event.preventDefault();
                var button = $(this);
                if ($(this).hasClass('gesture-editable')) {
                    if (!$(this).hasClass('disabled') && inputsValid(true)) {

                        $(button).addClass('disabled');
                        showCursor($('body'), CURSOR_PROGRESS);
                        var title = $('#gesture-name-input').val().trim();
                        var type = $(container).find('#gestureTypeSelect .chosen').attr('id');
                        var interactionType = $(container).find('#gestureInteractionTypeSelect .chosen').attr('id');
                        var context = $('#gesture-context-input').val().trim();
                        var association = $('#gesture-association-input').val().trim();
                        var description = $('#gesture-description-input').val().trim();
                        var joints = getSelectedJoints($('#select-joints-human-body #joint-container'));

                        updateGesture({gestureId: gesture.id, title: title, type: type, interactionType: interactionType, context: context, association: association, description: description, joints: joints}, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            $(button).removeClass('disabled');
                            $(container).find('#btn-delete-gesture').removeClass('disabled');
                            $(container).find('#btn-share-gesture').removeClass('disabled');
                            if (result.status === RESULT_SUCCESS) {
                                updateGestureById(currentPreviewGesture.source, result.id, {title: result.title, type: type, interactionType: interactionType, context: result.context, association: association, description: result.description, joints: result.joints});
                                $(thumbnail).find('.title-text').text(title);
                                $(button).removeClass('gesture-editable').addClass('gesture-previewable');
                                $(button).find('.btn-text').text(translation.edit);
                                $(container).find('#gesture-data-preview').removeClass('hidden');
                                $(container).find('#gesture-data-edit').addClass('hidden');

//                            setLocalItem(GESTURE_CATALOG, result.gestures);
                                originalFilterData = getLocalItem(currentPreviewGesture.source);
//                            currentFilterData = sort();
                                renderGestureInfoData();
                            } else {
                                appendAlert($('#modal-body'), ALERT_GENERAL_ERROR);
                            }
                        });
                    }
                } else {
//                console.log($('#gestureTypeSelect').find('#' + gesture.type));
                    $(this).removeClass('gesture-previewable').addClass('gesture-editable');
                    $(this).find('.btn-text').text(translation.gesturePreviewable);
                    $(container).find('#gesture-data-preview').addClass('hidden');
                    $(container).find('#gesture-data-edit').removeClass('hidden');
                    $(container).find('#btn-delete-gesture').addClass('disabled');
                    $(container).find('#btn-share-gesture').addClass('disabled');
                    $('#gesture-name-input').val(gesture.title);
                    $('#gesture-data-edit #gestureTypeSelect').find('#' + gesture.type).click();
                    $('#gesture-data-edit #gestureInteractionTypeSelect').find('#' + gesture.interactionType).click();
                    $('#gesture-association-input').val(gesture.association);
                    $('#gesture-context-input').val(gesture.context);
                    $('#gesture-description-input').val(gesture.description);
                    renderBodyJoints($('#select-joints-human-body'), gesture.joints);
                }
            });

            if (gesturePreviewDeleteable === true) {
                $(container).find('#btn-delete-gesture').unbind('click').bind('click', {gestureId: gesture.id}, function (event) {
                    event.preventDefault();

                    if (!event.handled && !$(this).hasClass('disabled')) {
                        event.handled = true;
                        $(this).addClass('disabled');
                        showCursor($('body'), CURSOR_PROGRESS);
                        deleteGesture({gestureId: event.data.gestureId}, function (result) {
                            showCursor($('body'), CURSOR_DEFAULT);
                            if (result.status === RESULT_SUCCESS) {
                                $(container).trigger('gestureDeleted');
                            }
                        });
                    }
                });
            } else {
//                console.log('gesture is not deletable');
                $(container).find('#btn-delete-gesture').remove();
            }

            // gesture set attachment
            renderAttachedGestureSets();
        }


        function renderComments(data) {
            var list = $('#discussion-body #comments-list');
            list.empty();
            if (data !== null && data.length > 0) {
                clearAlerts($('#discussion-body'));

                for (var i = 0; i < data.length; i++) {
                    var clone = $('#gesture-comment-item').clone().removeClass('hidden').removeAttr('id');
                    clone.find('.panel-heading #user .text').text(data[i].forename + " " + data[i].surname);
                    clone.find('.panel-heading #created .text').text(convertSQLTimestampToDate(data[i].created).toLocaleString());
                    clone.find('.panel-body').text(data[i].comment);
                    list.prepend(clone);
                    if (data[i].isOwner === true) {
                        clone.find('#btn-delete-comment').click({commentId: data[i].id, gestureId: data[i].gestureId}, function (event) {
                            event.preventDefault();
                            showCursor($('body'), CURSOR_PROGRESS);
                            deleteComment({commentId: event.data.commentId, gestureId: event.data.gestureId}, function (result) {
                                showCursor($('body'), CURSOR_DEFAULT);
                                if (result.status === RESULT_SUCCESS) {
                                    renderComments(result.comments);
                                }
                            });
                        });
                    } else {
                        clone.find('.panel-footer').remove();
                    }
                }
            } else {
                appendAlert($('#discussion-body'), ALERT_NO_COMMENTS);
            }
        }

        function hasUserRatedGesture(userId, ratings) {
            if (ratings && ratings.length > 0) {
                for (var i = 0; i < ratings.length; i++) {
                    if (parseInt(ratings[i].userId) === parseInt(userId)) {
                        return true;
                    }
                }
            }

            return false;
        }

        function inputsValid(showErrors) {
            var container = $('#gesture-data-edit');
            var title = $('#gesture-data-edit #gesture-name-input').val().trim();
            if (title === '') {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            var type = $(container).find('#gestureTypeSelect .chosen').attr('id');
            if (type === 'unselected') {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            var interactionType = $(container).find('#gestureInteractionTypeSelect .chosen').attr('id');
            if (interactionType === 'unselected') {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            var context = $('#gesture-data-edit #gesture-context-input').val().trim();
            if (context === '') {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            var association = $('#gesture-data-edit #gesture-association-input').val().trim();
            if (association === '') {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            var description = $('#gesture-data-edit #gesture-description-input').val().trim();
            if (description === '') {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            var selectedJoints = getSelectedJoints($('#select-joints-human-body #joint-container'));
            if (selectedJoints.length === 0) {
                if (showErrors) {
                    appendAlert(container, ALERT_MISSING_FIELDS);
                } else {
                    removeAlert(container, ALERT_MISSING_FIELDS);
                }
                return false;
            }

            return true;
        }

        $('#gesture-data-edit #select-joints-human-body').bind('change', function () {
            if (inputsValid()) {
                $('#btn-edit-gesture').removeClass('disabled');
            } else {
                $('#btn-edit-gesture').addClass('disabled');
            }
        });

        $('#gesture-data-edit #gestureTypeSelect, #gesture-data-edit #gestureInteractionTypeSelect').unbind('change').bind('change', function () {
            if (inputsValid()) {
                $('#btn-edit-gesture').removeClass('disabled');
            } else {
                $('#btn-edit-gesture').addClass('disabled');
            }
        });

        $('#gesture-name-input, #gesture-association-input, #gesture-context-input, #gesture-description-input').bind('input', function () {
            if (inputsValid()) {
                $('#btn-edit-gesture').removeClass('disabled');
            } else {
                $('#btn-edit-gesture').addClass('disabled');
            }
        });
</script>