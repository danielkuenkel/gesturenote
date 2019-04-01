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
        <title><?php echo $lang->gestureNotePublications ?></title>
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

        <script src="js/refreshSession.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/goto-general.js"></script>
        <script src="js/goto-evaluator.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="template-general"></div>



        <!-- Container (Landing Section) -->
        <div class="container" id="breadcrumb" style="">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-publications"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php echo $lang->breadcrump->publications ?></li>
                </ol>
            </div>
        </div>

        <div id="loading-indicator" class="window-sized-loading text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
        </div>

        <div class="container mainContent hidden" style="margin-top: 0px">
            <h3 style="margin-top:0px">2018</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <div><span><?php echo $lang->title ?>:</span> <span class="text">Definition of Gesture Interactions based on Temporal Relations</span></div>
                    <div><span><?php echo $lang->authors ?>:</span> <span class="text">Dominik Rupprecht, Daniel Künkel, Rainer Blum, Birgit Bomsdorf</span></div>
                    <div><span><?php echo $lang->In ?>:</span> <span class="text">2nd International Conference on Human Computer Interaction Theory and Applications, Januar 2018, Funchal, Portugal</span></div>
                    <a target="blank" href="http://www.hucapp.visigrapp.org"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $lang->moreInfos ?></a><br/>
                    <a target="blank" href="http://www.scitepress.org/PublicationsDetail.aspx?ID=YVkD8vaYNwM=&t=1"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF</a>
                </div>
            </div>
            <h3 style="margin-top:50px">2016</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <div><span><?php echo $lang->title ?>:</span> <span class="text">Bewertung der Gebrauchstauglichkeit von 3D-Gesten</span></div>
                    <div><span><?php echo $lang->authors ?>:</span> <span class="text">Daniel Künkel, Birgit Bomsdorf</span></div>
                    <div><span><?php echo $lang->In ?>:</span> <span class="text">Prinz, W., Borchers, J. & Jarke, M. (Hrsg.), Mensch und Computer 2016 - Tagungsband. Aachen: Gesellschaft für Informatik e.V.</span></div>
                    <a target="blank" href="http://dl.mensch-und-computer.de/bitstream/handle/123456789/5036/Künkel_Bomsdorf_2016.pdf?sequence=1"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF</a>
                </div>
            </div>
            <h3 style="margin-top:50px">2015</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                    <div><span><?php echo $lang->title ?>:</span> <span class="text">Participative development of touchless user interfaces: Elicitation and evaluation of contactless hand gestures for anesthesia</span></div>
                    <div><span><?php echo $lang->authors ?>:</span> <span class="text">Daniel Künkel, Birgit Bomsdorf, Rainer Röhrig, Janko Ahlbrandt und Markus Weigand</span></div>
                    <div><span><?php echo $lang->In ?>:</span> <span class="text">Interfaces and Human Computer Interaction (IHCI) Konferenz</span></div>
                    <a target="blank" href="http://www.iadisportal.org/ihci-2015-proceedings"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $lang->moreInfos ?></a>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                checkDomain();
                keepSessionAlive();

                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#template-general', PATH_EXTERNALS + 'template-general.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                renderSubPageElements();
                animateBreadcrump();
                checkDarkMode(parseInt('<?php echo checkDarkMode(); ?>'));

                $('.mainContent').removeClass('hidden');
                TweenMax.to($('#loading-indicator'), .4, {opacity: 0, onComplete: function () {
                        $('#loading-indicator').remove();
                    }});
                TweenMax.from($('.mainContent'), .3, {delay: .3, opacity: 0});
            }
        </script>

    </body>
</html>