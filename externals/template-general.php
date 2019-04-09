<?php
include '../includes/language.php';
?>


<div id="template-general-container" class="hidden">

    <div class="btn-group" id="radio">
        <button class="btn btn-default btn-radio list-btn" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-circle-thin" id="normal"></i>
                <i class="fa fa-circle hidden" id="over"></i>
                <i class="fa fa-check-circle hidden" id="checked"></i>
            </span>
            <span class="option-text ellipsis"></span>
        </button>
    </div>

    <div class="btn-group" id="checkbox">
        <button class="btn btn-default btn-checkbox" name="primary">
            <span id="icons" style="margin-right: 6px">
                <i class="fa fa-square-o" id="normal"></i>
                <i class="fa fa-square hidden" id="over"></i>
                <i class="fa fa-check-square hidden" id="checked"></i>
            </span>
            <span class="option-text ellipsis"></span>
        </button>
    </div>

    <div class="item hidden" id="carousel-listbox-item">
        <img src="">
        <div class="carousel-caption">
            <h4 class="carousel-caption-header"></h4>
            <p class="carousel-caption-text"></p>
        </div>
    </div>

</div>

<div class="hidden" id="header-footer-container">

    <div class="sub-page-header" id="sub-page-header">
        <div class="container" id="">
            <div class="row">
                <div class="col-xs-12">
                    <div class="" id="logo" style="color: white">
                        <div class="navbar-brand"><i class="glyphicon glyphicon-stats"></i> <span style="letter-spacing: 0pt; margin-left: -5px"><?php echo $lang->gestureNote ?></span> <sup><span class="label label-success uppercase" style="position: relative; font-size: 6pt; letter-spacing: normal"><?php echo $lang->beta ?></span></sup></div>
                    </div>
                    <div class="pull-right" style="display: flex">
                        <div class="pull-right text-center" id="toggle-dark-mode" style="padding-right: 37px; cursor: pointer; font-size: 13pt; color: white; width: 22px">
                            <i class="fa fa-moon-o" style="top: 13px; position: relative"></i>
                        </div>
                        <div class="dropdown pull-right language-selection" id="language-selection" style="padding-right: 10px">
                            <div class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="height: 51px">
                                <img class="flag-small" src="" style="top: 16px; position: relative">
                            </div>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="de" style="margin-top: 1px"><img class="flag-small" src="img/flags/de.png"> <span><?php echo $lang->languages->de->language ?></span></a></li>
                                <li><a href="#" id="en"><img class="flag-small" src="img/flags/en.png"> <span><?php echo $lang->languages->en->language ?></span></a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right" id="main-navigation-dropdown" style="padding-left: 10px;">
                            <div class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="height: 51px">
                                <div class="" style="top: 19px; position: relative">
                                    <div class="burger-line" style="height: 2px; width: 17px; background-color: white"></div>
                                    <div class="burger-line" style="height: 2px; width: 17px; background-color: white; margin-top: 3px"></div>
                                    <div class="burger-line" style="height: 2px; width: 17px; background-color: white; margin-top: 3px"></div>
                                </div>
                            </div>
                            <ul class="dropdown-menu main-burger-menu">
                                <li class="btn-dashboard" data-id="btn-dashboard"><a href="#" style="margin-top: 1px"><i class="fa fa-tachometer" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->dashboard ?></span></a></li>
                                <li role="separator" class="divider" style="background-color: #787878; margin: 4px 0px;"></li>
                                <li class="btn-studies" data-id="btn-studies"><a href="#"><i class="fa fa-tasks" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->studies ?></span></a></li>
                                <li class="btn-study hidden" data-id="btn-study"><a href="#"><i class="fa fa-clipboard"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->study ?></span></a></li>
                                <li class="btn-gesture-styleguides" data-id="btn-gesture-styleguides"><a href="#"><i class="fa fa-map-signs" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->gestureStyleguides ?></span></a></li>
                                <li class="btn-gesture-catalog" data-id="btn-gesture-catalog"><a href="#"><i class="fa fa-sign-language" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->gestureCatalog ?></span></a></li>
                                <li class="btn-simulator" data-id="btn-simulator"><a href="#"><i class="fa fa-sign-language" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->simulator ?></span></a></li>
                                <li class="btn-news" data-id="btn-news"><a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->news ?></span></a></li>
                                <li class="btn-publications" data-id="btn-publications"><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->publications ?></span></a></li>
                                <li class="btn-profile" data-id="btn-profile"><a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->profile ?></span></a></li>
                                <li class="btn-support" data-id="btn-support"><a href="#"><i class="fa fa-support" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->help ?></span></a></li>
                                <li class="btn-informations" data-id="btn-informations"><a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->informations ?></span></a></li>
                                <li class="btn-imprint" data-id="btn-imprint"><a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="main-burger-menu-text"><?php echo $lang->breadcrump->imprint ?></span></a></li>
                                <li role="separator" class="divider" style="background-color: #787878; margin: 4px 0px;"></li>
                                <li id="btn-sign-out"><a href="#"><i class="fa fa-lock"></i> <span class="main-burger-menu-text"><?php echo $lang->signOut ?></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="subpage-line"></div>
    </div>

</div>