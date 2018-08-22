<?php
include '../includes/language.php';
?>


<div id="template-general-container" class="hidden">

    <!--     register modal 
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-register">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $lang->createAccount ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert-space alert-general-error"></div>
                        <div class="alert-space alert-missing-fields"></div>
                        <div class="alert-space alert-register-success"></div>
    
                        <div id="register-form">
                            <div class="form-group">
                                <label for="forename"><?php echo $lang->forename ?></label>
                                <input type="text" class="form-control" name="forename" id="forename" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="surname"><?php echo $lang->surname ?></label>
                                <input type="text" class="form-control" name="surname" id="surname" placeholder="">
                            </div>
    
                            <div class="alert-space alert-user-exists"></div>
                            <div class="alert-space alert-invalid-email"></div>
    
                            <div class="form-group">
                                <label for="email"><?php echo $lang->email ?></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="">
                            </div>
    
                            <div class="alert-space alert-password-short"></div>
                            <div class="alert-space alert-password-invalid"></div>
                            <div class="alert-space alert-passwords-not-matching"></div>
    
                            <div class="form-group">
                                <label for="password"><?php echo $lang->password ?> <i class="fa fa-info-circle text btn-show-info" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo $lang->tooltips->general->password ?>"></i></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword"><?php echo $lang->passwordConfirm ?></label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="">
                            </div>
    
                            <div class="alert-space alert-invalid-birthday"></div>
    
                            <div class="form-group">
                                <label><?php echo $lang->birthdate ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $lang->day ?></span>
                                    <input class="form-control" id="date" type="text" placeholder="z.B. 1" minlength="1" maxlength="2"/>
                                    <span class="input-group-addon"><?php echo $lang->month ?></span>
                                    <input class="form-control" id="month" type="text" placeholder="z.B. 12" minlength="1" maxlength="2"/>
                                    <span class="input-group-addon"><?php echo $lang->year ?></span>
                                    <input class="form-control" id="year" type="text" placeholder="z.B. 1980" minlength="4" maxlength="4"/>
                                </div>
                            </div>
    
                            <div class="form-group root" id="gender">
                                <label><?php echo $lang->gender ?></label><br>
    
                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="female">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gendersRegister->female ?></span>
                                    </button>
                                </div>
    
                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="male">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->gendersRegister->male ?></span>
                                    </button>
                                </div>
    
                            </div>
    
                            <div class="form-group root" id="userType">
                                <label><?php echo $lang->userType ?></label><br>
    
                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="tester">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->userTypesRegister->tester ?></span>
                                    </button>
                                </div>
    
                                <div class="btn-group" id="radio">
                                    <button class="btn btn-default btn-radio" name="primary" id="evaluator">
                                        <span id="icons" style="margin-right: 6px">
                                            <i class="fa fa-circle-thin" id="normal"></i>
                                            <i class="fa fa-circle hidden" id="over"></i>
                                            <i class="fa fa-check-circle hidden" id="checked"></i>
                                        </span>
                                        <span class="option-text"><?php echo $lang->userTypesRegister->evaluator ?></span>
                                    </button>
                                </div>
    
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-success hidden" id="btn-close"><span class="btn-text"><?php echo $lang->close ?></span></button>
                        <button type="button" class="btn btn-block btn-primary" id="btn-register"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="btn-text"><?php echo $lang->register ?></span></button>
                    </div>
                </div>
            </div>
        </div>-->

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
                        <!--<ul class="nav navbar-nav navbar-right">-->
                        <div class="dropdown pull-right language-selection" id="language-selection" style="padding-right: 10px">
                            <div class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="height: 51px">
                                <img class="flag-small" src="" style="top: 16px; position: relative">
                            </div>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="de" style="margin-top: 1px"><img class="flag-small" src="img/flags/Germany.png"> <span><?php echo $lang->languages->de->language ?></span></a></li>
                                <li><a href="#" id="en"><img class="flag-small" src="img/flags/en.png"> <span><?php echo $lang->languages->en->language ?></span></a></li>
                            </ul>
                        </div>
                        <div class="dropdown pull-right" id="main-navigation-dropdown" style="padding-left: 10px">
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
                        <!--</ul>-->
                    </div>
                </div>
            </div>

        </div>
        
        <div class="line"></div>
    </div>


    <!--    <nav class="navbar navbar-default navbar-fixed-top" id="sub-page-header">
            <div class="container">
    
    
            </div>
    
            <div class="line"></div>
        </nav>-->

</div>