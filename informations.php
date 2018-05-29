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
        <div id="template-subpages"></div>


        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb"style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><?php echo $lang->breadcrump->informations ?></li>
                </ol>
            </div>
        </div>


        <!-- Container (Landing Section) -->
        <div class="container mainContent" style="margin-top: 0px">
            <div class="row">
                <div class="col-md-5 col-md-push-7 text-center text" style="margin-bottom: 30px">
                    <i class="fa fa-pencil fa-5x"></i> 
                    <h2 style="margin-top: 4px" class="uppercase font-bold"><?php echo $lang->infosContent->planning->title ?></h2>
                    <div style="margin-top: 20px"><?php echo $lang->infosContent->planning->content ?></div>
                </div>
                <div class="col-md-7 col-md-pull-5" style="margin-bottom: 30px">
                    <!-- 16:9 aspect ratio -->
                    <div class="rtc-shadow embed-responsive embed-responsive-16by9" style="border-radius: 5px">
                        <video class="embed-responsive-item" poster="<?php echo $lang->infosContent->planning->videoPlaceholderUrl ?>" controls controlsList="nodownload">
                            <source src="video/planning.mp4" type="video/mp4">
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
                        <video class="embed-responsive-item" poster="<?php echo $lang->infosContent->execution->videoPlaceholderUrl ?>" controls controlsList="nodownload">
                            <source src="video/execution.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 120px">
                <div class="col-md-5 col-md-push-7 text-center text" style="margin-bottom: 30px">
                    <i class="fa fa-comments fa-5x"></i> 
                    <h2 style="margin-top: 4px" class="uppercase font-bold"><?php echo $lang->infosContent->analysis->title ?></h2>
                    <div style="margin-top: 20px"><?php echo $lang->infosContent->analysis->content ?></div>
                </div>
                <div class="col-md-7 col-md-pull-5" style="margin-bottom: 30px">
                    <!-- 16:9 aspect ratio -->
                    <div class="rtc-shadow embed-responsive embed-responsive-16by9" style="border-radius: 5px">
                        <video class="embed-responsive-item" poster="<?php echo $lang->infosContent->analysis->videoPlaceholderUrl ?>" controls controlsList="nodownload">
                            <source src="video/analysis.mp4" type="video/mp4">
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
                    <em>Nutzerzentriert</em>
                </div>
            </div>

            <hr>

            <div class="row text" id="features-user-centered" style="margin-top: 10px">
                <div class="col-md-4">
                    <h4 class="text-center font-bold">Ermittlung</h4>
                    <ul>
                        <li><strong>Ermittlung (Top-Down):</strong> Gesten für vorhandene Funktionen ermitteln.</li>
                        <li><strong>Ermittlung (Bottom-Up):</strong> Funktionen für vorhandene Gesten ermitteln.</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="hidden-sm hidden-md hidden-lg" style="margin-top: 20px"></div>
                    <h4 class="text-center font-bold">Extraktion</h4>
                    <ul>
                        <li><strong>Exploration (Top-Down):</strong> Abfrage favorisierter Gesten für vorhandene Funktionen.</li>
                        <li><strong>Exploration (Bottom-Up):</strong> Abfrage favorisierter Funktionen für vorhandene Gesten.</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="hidden-sm hidden-md hidden-lg" style="margin-top: 20px"></div>
                    <h4 class="text-center font-bold">Evaluierung</h4>
                    <ul>
                        <li><strong>GUS:</strong> Baukasten zur Erstellung von Bewertungsbögen für Gesten-Interaktionen.</li>
                        <li><strong>SUS:</strong> Bewertung eines Systems oder Prototyp.</li>
                        <li><strong>UEQ:</strong> Messen der Benutzererfahrung von interaktiven Produkten.</li>
                        <li><strong>Gesten-Training:</strong> Trainieren von Gesten vor der Nutzung.</li>
                        <li><strong>Szenario:</strong> Interaktive explorative szenariobasierte WOZ-Experimente.</li>
                        <li><strong>Gesten erraten</strong> Messen von Erinnerbarkeit und Intuitivität von Gesten.</li>
                        <li><strong>Funktionen erraten:</strong> Messen von Erinnerbarkeit und Intuitivität von Gesten.</li>
                        <li><strong>Physischer Belastungstest:</strong> Messen der körperlichen Belastung von Gesten.</li>
                    </ul>
                </div>
            </div>


            <div class="row" style="margin-top: 30px">
                <div class="col-md-12 text-center">
                    <em>Expertenbasiert</em>
                </div>
            </div>

            <hr>

            <div class="row text" id="features-expert-based" style="margin-top: 10px">
                <div class="col-md-4">
                    <h4 class="text-center font-bold">Ermittlung</h4>
                    <ul>
                        <li><strong>Gesten-Recorder:</strong> Aufzeichnung von Gesten mit über Webcam und/oder Leap Motion Controller.</li>
                        <li><strong>Gesten-Katalog:</strong> Zugriff auf alle erstellten und von anderen Gesten-Designern freigegebene Gesten.</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="hidden-sm hidden-md hidden-lg" style="margin-top: 20px"></div>
                    <h4 class="text-center font-bold">Extraktion</h4>
                    <ul>
                        <li><strong>Klassifizierung:</strong> Einfaches Klassifizieren von nutzerzentriert ermittelten Gesten.</li>
                        <li><strong>Potentielle Gesten:</strong> Bewertung klassifizierter Gesten auf Basis bereitgestellter Kennzahlen (Anzahl von Gesten, statische Übereinstimmung nach Wobbrock) und Bewertungsinstrumenten (Checkliste, Sinnzusammenhänge).</li>
                        <li><strong>Gesten-Sets:</strong> Fassen Sie potentielle Gesten zu einem Gesten-Set zusammen, um diese für eine Evaluierung zu verwenden.</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="hidden-sm hidden-md hidden-lg" style="margin-top: 20px"></div>
                    <h4 class="text-center font-bold">Evaluierung</h4>
                    <ul>
                        <li><strong>Rohdaten:</strong> Bereitstellung von Rohdaten (Videos, Gesten, Fragebögen, Beobachtungen, etc.).</li>
                        <li><strong>Umfangreicher Video-Player:</strong> Automatische Synchronisierung von Videodaten (Moderator, Proband, Prototyp).</li>
                        <li><strong>Zeitleiste & Annotationen:</strong> Synchroniserte Darstellung automatische gespeicherter Annotationen. Hinzufügen/Löschen von Annotationen.</li>
                        <li><strong>Automatische Score-Berechnung:</strong> SUS-Scores, sowie Scores für „Gesten erraten“ und „Funktionen erraten“ werden automatisch berechnet.</li>
                        <li><strong>Notizen:</strong> Fügen Sie wichtige Notizen zu jedem Leitfadenschritt hinzu.</li>
                        <li><strong>Teilen von Ergebnissen:</strong> Teilen Sie Studien-Ergebnisse mit anderen registrierten Gesten-Designern.</li>
                        <li><strong>Gesten-Katalog:</strong> Teilen Sie ermittelte Gesten mit anderen Gesten-Designern. Diskutieren und bewerten Sie Gesten mit anderen Gesten-Designern.</li>
                    </ul>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    checkDomain();
                    checkLanguage(function () {
                        var externals = new Array();
                        externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                        loadExternals(externals);
                    });
                });

                function onAllExternalsLoadedSuccessfully() {
                    var loggedIn = parseInt('<?php echo login_check($mysqli) ?>') === 1;
                    renderSubPageElements(loggedIn);
                    if (loggedIn === false) {
                        $('#btn-dashboard').parent().remove();
                    }
                }
            </script>

    </body>
</html>