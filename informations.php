<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNote ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>

        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">

        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="template-general"></div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-informations"><i class="fa fa-file-text-o"></i> <?php echo $lang->breadcrump->informations ?></li>
                </ol>
            </div>
        </div>


        <!-- Container (Landing Section) -->
        <div class="container mainContent" style="margin-top: 0px">
            <div class='text' id="help-description"><?php echo $lang->infosContent->general->content ?></div>
            
            <div class="row" style="margin-top: 120px">
                <div class="col-md-5 col-md-push-7 text-center text" style="margin-bottom: 30px">
                    <i class="fa fa-pencil fa-5x"></i> 
                    <h2 style="margin-top: 4px" class="uppercase font-bold"><?php echo $lang->infosContent->planning->title ?></h2>
                    <div style="margin-top: 20px"><?php echo $lang->infosContent->planning->content ?></div>
                </div>
                <div class="col-md-7 col-md-pull-5" style="margin-bottom: 30px">
                    <!-- 16:9 aspect ratio -->
                    <div class="rtc-shadow embed-responsive embed-responsive-16by9" style="border-radius: 5px">
                        <video class="embed-responsive-item" style="border-radius: 5px;" poster="<?php echo $lang->infosContent->planning->videoPlaceholderUrl ?>" controls controlsList="nodownload">
                            <source src="<?php echo $lang->infosContent->planning->videoUrl ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 120px">
                <div class="col-md-5 text-center text" style="margin-bottom: 30px">
                    <i class="fa fa-comments fa-5x "></i> 
                    <h2 style="margin-top: 4px" class="uppercase font-bold"><?php echo $lang->infosContent->execution->title ?></h2>
                    <div style="margin-top: 20px"><?php echo $lang->infosContent->execution->content ?></div>
                </div>
                <div class="col-md-7" style="margin-bottom: 30px">
                    <!-- 16:9 aspect ratio -->
                    <div class="rtc-shadow embed-responsive embed-responsive-16by9" style="border-radius: 5px">
                        <video class="embed-responsive-item" style="border-radius: 5px;" poster="<?php echo $lang->infosContent->execution->videoPlaceholderUrl ?>" controls controlsList="nodownload">
                            <source src="<?php echo $lang->infosContent->execution->videoUrl ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 120px">
                <div class="col-md-5 col-md-push-7 text-center text" style="margin-bottom: 30px">
                    <i class="fa fa-bar-chart fa-5x"></i> 
                    <h2 style="margin-top: 4px" class="uppercase font-bold"><?php echo $lang->infosContent->analysis->title ?></h2>
                    <div style="margin-top: 20px"><?php echo $lang->infosContent->analysis->content ?></div>
                </div>
                <div class="col-md-7 col-md-pull-5" style="margin-bottom: 30px">
                    <!-- 16:9 aspect ratio -->
                    <div class="rtc-shadow embed-responsive embed-responsive-16by9" style="border-radius: 5px">
                        <video class="embed-responsive-item" style="border-radius: 5px;" poster="<?php echo $lang->infosContent->analysis->videoPlaceholderUrl ?>" controls controlsList="nodownload">
                            <source src="<?php echo $lang->infosContent->analysis->videoUrl ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 120px">
                <div class="col-md-12">
                    <h2 class="text-center uppercase font-bold"><?php echo $lang->infosContent->features->title ?></h2>
                </div>
            </div>


            <div class="row" style="margin-top: 30px">
                <div class="col-md-12 text-center">
                    <em style="font-size: 14pt"><?php echo $lang->Usercentered ?></em>
                    <p><?php echo $lang->infosContent->features->usercentered->subline ?></p>
                </div>
            </div>

            <hr>

            <div class="row text" id="features-user-centered" style="margin-top: 10px">
                <div class="col-md-4">
                    <h4 class="text-center font-bold"><?php echo $lang->phaseType->elicitation ?></h4>
                    <p><?php echo $lang->infosContent->features->usercentered->content->col01 ?></p>
                </div>
                <div class="col-md-4">
                    <div class="hidden-md hidden-lg" style="margin-top: 30px"></div>
                    <h4 class="text-center font-bold"><?php echo $lang->phaseType->extraction ?></h4>
                    <p><?php echo $lang->infosContent->features->usercentered->content->col02 ?></p>
                </div>
                <div class="col-md-4">
                    <div class="hidden-md hidden-lg" style="margin-top: 30px"></div>
                    <h4 class="text-center font-bold"><?php echo $lang->phaseType->evaluation ?></h4>
                    <p><?php echo $lang->infosContent->features->usercentered->content->col03 ?></p>
                </div>
            </div>


            <div class="row" style="margin-top: 60px">
                <div class="col-md-12 text-center">
                    <em style="font-size: 14pt"><?php echo $lang->Expertbased ?></em>
                    <p><?php echo $lang->infosContent->features->expertbased->subline ?></p>
                </div>
            </div>

            <hr>

            <div class="row text" id="features-expert-based" style="margin-top: 10px">
                <div class="col-md-4">
                    <h4 class="text-center font-bold"><?php echo $lang->phaseType->elicitation ?></h4>
                    <p><?php echo $lang->infosContent->features->expertbased->content->col01 ?></p>
                </div>
                <div class="col-md-4">
                    <div class="hidden-md hidden-lg" style="margin-top: 30px"></div>
                    <h4 class="text-center font-bold"><?php echo $lang->phaseType->extraction ?></h4>
                    <p><?php echo $lang->infosContent->features->expertbased->content->col02 ?></p>
                </div>
                <div class="col-md-4">
                    <div class="hidden-md hidden-lg" style="margin-top: 30px"></div>
                    <h4 class="text-center font-bold"><?php echo $lang->phaseType->evaluation ?></h4>
                    <p><?php echo $lang->infosContent->features->expertbased->content->col03 ?></p>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    checkDomain();
                    checkLanguage(function () {
                        var externals = new Array();
                        externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                        loadExternals(externals);
                    });
                });

                function onAllExternalsLoadedSuccessfully() {
                    var loggedIn = parseInt('<?php echo login_check($mysqli) ?>') === 1;
                    renderSubPageElements(loggedIn);
                    animateBreadcrump();
                    
                    if (loggedIn === false) {
                        $('#btn-dashboard').parent().remove();
                    }

                    $('.mainContent').find('video').on('click', function (event) {
                        event.preventDefault();
                        var video = $(this)[0];
                        video.paused ? video.play() : video.pause();
                    });
                }
            </script>

    </body>
</html>