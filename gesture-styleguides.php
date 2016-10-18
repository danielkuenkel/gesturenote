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
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script src="js/storage.js"></script>
        <script src="js/alert.js"></script>
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
        <div class="container-fluid bg-grey wall" id="landingText">
            <!-- Container (Breadcrump) -->
            <div class="container" id="breadcrumb">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a class="breadcrump-btn" id="btn-index"><?php echo $lang->breadcrump->home ?></a></li>
                        <li><a class="breadcrump-btn" id="btn-dashboard"><?php echo $lang->breadcrump->dashboard ?></a></li>
                        <li class="active"><?php echo $lang->breadcrump->gestureStyleguides ?></li>
                    </ol>
                </div>
            </div>

            <div class="container text-center dropShadowText">
                <h1><i class="fa fa-map-signs" style="font-size: 60pt" aria-hidden="true"></i> <span class="uppercase"><?php echo $lang->breadcrump->gestureStyleguides ?></span></h1>
            </div>
        </div>

        <div class="container" id="general-styleguides" style="margin-top: 50px">
            <h2 style="margin-top: 40px"><?php echo $lang->gestureStyleguides->process->headline ?></h2>
            <hr>
            <div class="text">
                <?php echo $lang->gestureStyleguides->process->info ?>
            </div>
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
                </ul>
            </div>
        </div>
        <div class="container" id="heuristics-styleguides" style="margin-top: 50px">
            <h2><?php echo $lang->gestureStyleguides->heuristics->headline ?></h2>
            <hr>
            <p></p>
            <div class="text">

            </div>
        </div>
        <div class="container" id="gus-styleguides" style="margin-top: 50px">
            <h2><?php echo $lang->gestureStyleguides->usabilityScale->headline ?></h2>
            <hr>
            <p><?php echo $lang->gestureStyleguides->usabilityScale->info ?></p>
            <h4 style="margin-top:40px">GUS für einzelne Gesten</h4>
            <hr>
            <div class="text" id="single-gus-list-container"></div>

            <h4 style="margin-top:60px">GUS für mehrere Gesten</h4>
            <hr>
            <div class="text" id="multiple-gus-list-container"></div>
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
            <div class="label label-primary" id="factor-main"></div>
            <img src="img/factor-transition.jpg" style="margin-left: -3px; margin-right: -3px">
            <div class="label label-info" id="factor-primary"></div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + 'alerts.php']);
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();

                renderDimensions($('#gus-styleguides #single-gus-list-container'));
                renderGUSStyleguides($('#single-gus-list-container'), translation.singleGUS);

                renderDimensions($('#gus-styleguides #multiple-gus-list-container'));
                renderGUSStyleguides($('#multiple-gus-list-container'), translation.multipleGUS);
            }

            function renderDimensions(target) {
                var count, subCount = 0;
                var dimension = null;
                var mainDimensions = translation.mainDimensions;
                var dimensionsForMainDimensions = translation.mainDimensionsForDimension;
                for (var mainDimension in mainDimensions) {
                    if (dimension !== mainDimension) {
                        dimension = mainDimension;

                        var container = document.createElement('div');
                        $(container).attr('id', 'mainDimension_' + dimension);
                        $(container).addClass('container');
                        $(target).append(container);

                        if (count > 0) {
                            $(container).css({marginTop: "40px"});
                        }

                        for (var subDimension in dimensionsForMainDimensions) {
                            var headline = $('#item-factors-headline').clone().removeClass('hidden').removeAttr('id');
                            $(headline).find('#factor-main').text(mainDimensions[dimension]);
                            $(headline).addClass('row');
                            $(headline).find('#factor-primary').text(translation.dimensions[subDimension]);

                            if (dimensionsForMainDimensions[subDimension] === dimension) {
                                $(container).append(headline);

                                var subContainer = document.createElement('div');
                                $(subContainer).addClass('row');
                                $(subContainer).attr('id', 'subDimension_' + subDimension);
                                $(container).append(subContainer);

                                if (subCount > 0) {
                                    $(headline).css({marginTop: "40px"});
                                }
                            }
                            subCount++;
                        }
                    }
                    count++;
                }
            }

            function renderGUSStyleguides(target, gus) {
                console.log(gus.length);
                var currentDimension = null;
                for (var i = 0; i < gus.length; i++) {

                    var row = document.createElement('div');
                    $(row).addClass('row');

                    var column = document.createElement('div');
                    $(column).addClass('col-xs-6');
                    $(column).text(gus[i].styleguide);
                    $(row).append(column);

                    column = document.createElement('div');
                    $(column).addClass('col-xs-6');
                    $(column).text(gus[i].question);
                    $(row).append(column);

                    if (currentDimension !== gus[i].dimension) {
                        currentDimension = gus[i].dimension;
                    } else {
                        $(row).css({marginTop: "20px"});
                    }

                    $(target).find('#subDimension_' + gus[i].dimension).append(row);
                }
            }
        </script>

    </body>
</html>