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
        <title><?php echo $lang->gestureNoteStyleguides ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- third party sources -->
        <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/greensock/TweenMax.min.js"></script>
        
        <!-- gesturenote specific sources -->
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        
        <script src="js/refreshSession.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="template-subpages"></div>



        <!-- Container (Landing Section) -->
        <!--<div class="container-fluid bg-grey wall" id="landingText">-->
        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb" style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><i class="fa fa-map-signs" aria-hidden="true"></i> <?php echo $lang->breadcrump->gestureStyleguides ?></li>
                </ol>
            </div>
        </div>

        <!--            <div class="container text-center dropShadowText">
                        <h1><i class="fa fa-map-signs" style="font-size: 60pt" aria-hidden="true"></i> <span class="uppercase"><?php echo $lang->breadcrump->gestureStyleguides ?></span></h1>
                    </div>-->
        <!--</div>-->

        <div class="container" id="general-styleguides" style="margin-top: 0px">
            <h2 style="margin-top: 40px"><?php echo $lang->gestureStyleguides->process->headline ?></h2>
            <hr>
            <div class="text">
                <?php echo $lang->gestureStyleguides->process->info ?>
            </div>
            <img src="<?php echo $lang->gestureStyleguides->process->processImage ?>" class="img-responsive" style="display: block; margin-left: auto; margin-right: auto"/>
        </div>

        <div class="container" id="general-styleguides" style="margin-top: 50px">
            <h2><?php echo $lang->gestureStyleguides->processStyleguides->headline ?></h2>
            <hr>
            <p><?php echo $lang->gestureStyleguides->processStyleguides->info ?></p>
            <div class="text">
                <ul>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg1 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg2 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg3 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg4 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg5 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg6 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg7 ?></li>
                    <ul>
                        <li><?php echo $lang->generalGestureProcessStyleguides->sg71 ?></li>
                        <li><?php echo $lang->generalGestureProcessStyleguides->sg72 ?></li>
                    </ul>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg8 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg9 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg10 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg11 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg12 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg13 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg14 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg15 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg16 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg17 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg18 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg19 ?></li>
                    <li><?php echo $lang->generalGestureProcessStyleguides->sg20 ?></li>
                </ul>
            </div>
        </div>

        <div class="container" id="gus-styleguides" style="margin-top: 50px">
            <h2><?php echo $lang->gestureStyleguides->usabilityScale->headline ?></h2>
            <hr>
            <p><?php echo $lang->gestureStyleguides->usabilityScale->info ?></p>
            <div style="margin-top:40px; display: inline; cursor: pointer" class="btn-toggle-gus-items text" id="btn-toggle-single">
                <h4 class="pull-left"><?php echo $lang->gusForSingleGesture ?></h4>
                <div id="plus-sign" class="pull-right"><i class="fa fa-plus"></i></div>
            </div>
            <div style="clear: both"></div>
            <div id="single-gus-list" class="hidden">
                <hr style="margin-top: 10px; margin-bottom: 20px">
                <div class="text" id="single-gus-list-container"></div>
            </div>

            <div style="margin-top:40px; display: inline; cursor: pointer" class="btn-toggle-gus-items text" id="btn-toggle-multiple">
                <h4 class="pull-left"><?php echo $lang->gusForMultipleGestures ?></h4>
                <div id="plus-sign" class="pull-right"><i class="fa fa-plus"></i></div>
            </div>
            <div style="clear: both"></div>
            <div id="multiple-gus-list" class="hidden">
                <hr style="margin-top: 10px; margin-bottom: 20px">
                <div class="text" id="multiple-gus-list-container"></div>
            </div>

        </div>
        <div class="container" id="references" style="margin-bottom: 60px; margin-top: 50px">
            <h2><?php echo $lang->gestureStyleguides->references->headline ?></h2>
            <hr>
            <div class="text">
                <p>Ashbrook, D., & Starner, T. (2010). MAGIC : A Motion Gesture Design Tool. Proceedings of the SIGCHI Conference on Human Factors in Computing Systems, 2159–2168. http://doi.org/10.1145/1753326.1753653</p>
                <p>Intel. (2012). Intel ® Perceptual Computing SDK Human Interface Guidelines. Retrieved November 16, 2015, from https://software.intel.com/sites/default/files/article/401008/perc-humaninterfaceguidelines.pdf</p>
                <p>Leap Motion. (n.d.-a). Menu Design Guidelines. Retrieved November 16, 2015, from https://developer.leapmotion.com/documentation/csharp/practices/Leap_Menu_Design_Guidelines.html</p>
                <p>Leap Motion. (n.d.-b). User Experience Guidelines. Retrieved November 16, 2015, from https://developer.leapmotion.com/documentation/csharp/practices/Leap_UX_Guidelines.html</p>
                <p>Long, A. C., Landay, J. a, & Rowe, L. a. (1999). Implications For a Gesture Design Tool. ACM, Computer-Human Interface, CHI ’99: Proceedings of the SIGCHI Conference on Human Factors in Computing Systems, 40–47. http://doi.org/10.1145/302979.302985</p>
                <p>Manresa-Yee, C., Amengual, E., & Pere, P. (2013). Usability of Vision-Based Interfaces. ACM International Conference on Interactive Tabletops and Surfaces (ITS ’11), 113–118.</p>
                <p>Microsoft. (2013). Interface Guidelines. Retrieved November 16, 2015, from https://msdn.microsoft.com/en-us/library/jj663791.aspx</p>
                <p>Nielsen, M., Störring, M., Moeslund, T. B., & Granum, E. (2004). A procedure for developing intuitive and ergonomic gesture interfaces for HCI. Gesture-Based Communication in Human-Computer Interaction, 409–420. http://doi.org/10.1007/978-3-540-24598-8_38</p>
                <p>Ruiz, J., Li, Y., & Lank, E. (2011). User-defined motion gestures for mobile interaction. Proceedings of the 2011 Annual Conference on Human Factors in Computing Systems - CHI ’11, 197. http://doi.org/10.1145/1978942.1978971</p>
                <p>Wachs, J. P., Kölsch, M., Stern, H., & Edan, Y. (2011). Vision-based hand-gesture applications. Communications of the ACM, 54(2), 60. http://doi.org/10.1145/1897816.1897838</p>
                <p>Wobbrock, J. O., Aung, H. H., Rothrock, B., & Myers, B. A. (2005). Maximizing the guessability of symbolic input. CHI ’05 Extended Abstracts on Human Factors in Computing Systems - CHI ’05, 1869. http://doi.org/10.1145/1056808.1057043</p>

            </div>
        </div>

        <div class="hidden" style="width: 100%; margin-bottom: 10px;" id="item-factors-headline">
            <!--                <div class="label label-primary" id="factor-main"></div>
                <img src="img/factor-transition.jpg" class="item-factors-separator">-->
            <div class="label label-primary" id="factor-primary"></div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                renderGUSStyleguides($('#single-gus-list-container'), translation.singleGUS);
                renderGUSStyleguides($('#multiple-gus-list-container'), translation.multipleGUS);
            }

            function renderGUSStyleguides(target, gus) {
                var currentDimension = null;
                if (gus && gus.length > 0) {
                    for (var i = 0; i < gus.length; i++) {
                        var row = document.createElement('div');
                        $(row).addClass('row');

                        var column = document.createElement('div');
                        $(column).addClass('col-xs-6');
                        $(column).html(gus[i].styleguide); // html because of the html tags in the translation
                        $(row).append(column);

                        column = document.createElement('div');
                        $(column).addClass('col-xs-6');
                        $(column).text(gus[i].question);
                        $(row).append(column);

                        if (currentDimension !== gus[i].dimension) {
                            currentDimension = gus[i].dimension;
                            var headline = $('#item-factors-headline').clone().removeClass('hidden').removeAttr('id');
                            $(headline).find('#factor-primary').text(translation.dimensions[currentDimension].title);
                            $(target).append(headline);

                            if (i > 0) {
                                $(headline).css({marginTop: "40px"});
                            }
                        } else {
                            $(row).css({marginTop: "20px"});
                        }

                        $(target).append(row);
                    }
                }
            }

            $('.btn-toggle-gus-items').click(function (event) {
                event.preventDefault();

                if (!$(this).hasClass('disabled')) {

                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');

                        TweenMax.to($(this).find('#plus-sign'), .3, {rotation: '0'});
                        $('#multiple-gus-list, #single-gus-list').addClass('hidden');
                    } else {
                        
                        $('.btn-toggle-gus-items').removeClass('active');
                        $(this).addClass('active');
                        TweenMax.to($('.btn-toggle-gus-items').find('#plus-sign'), .3, {rotation: '0'});
                        TweenMax.to($(this).find('#plus-sign'), .3, {rotation: '45'});
                        
                        if ($(this).attr('id') === 'btn-toggle-single') {
                            $('#single-gus-list').removeClass('hidden');
                            $('#multiple-gus-list').addClass('hidden');
                            TweenMax.from($('#single-gus-list'), .5, {opacity: 0});
                        } else {
                            $('#single-gus-list').addClass('hidden');
                            $('#multiple-gus-list').removeClass('hidden');
                            TweenMax.from($('#multiple-gus-list'), .5, {opacity: 0});
                        }
                        
                        var offset = $(this).offset();
                        $("html, body").animate({scrollTop: offset.top - 60}, "slow");
                    }
                }
            });
        </script>

    </body>
</html>