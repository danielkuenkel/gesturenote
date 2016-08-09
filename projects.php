<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/projects.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="js/alert.js"></script>
        <script src="js/externals.js"></script>
        <script src="js/language.js"></script>
        <script src="js/gotoPage.js"></script>
        <script src="js/globalFunctions.js"></script>
    </head>
    <body id="pageBody" data-spy="scroll" data-target=".navbar" data-offset="60">

        <!-- externals -->
        <div id="alerts"></div>
        <div id="templage-subpages"></div>
        
        <!-- Container (Breadcrump) -->
        <div class="container" id="breadcrumb">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index">Home</a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard">Dashboard</a></li>
                    <li class="active">Projekte</li>
                </ol>
            </div>
        </div>

        <!-- Container (Landing Section) -->
        <div class=" container-fluid text-center bg-grey" id="landingText">
            <div class="container">
                <h1><i class="fa fa-tasks" style="font-size: 60pt" aria-hidden="true"></i> PROJEKTE</h1>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            </div>
        </div>

        <!-- Container (Panel Section) -->
        <div class="container mainContent">

            <button type="submit" class="btn btn-success btn-lg btn-block" onclick="gotoCreateProject()"><span class="glyphicon glyphicon-plus"></span> Ein neues Projekt erstellen</button>

            <div class="form-group">
                <div class="dropdown text-right" id="filterDropdown">
                    <div class="btn-group">
                        <button class="btn btn-default"><i class="glyphicon glyphicon-sort"></i> <span>projects sorted by</span></button>
                        <button class="btn btn-default" id="filterText">Date (newest first)</button>

                        <div class="btn-group" role="group">
                            <button class="btn btn-default dropdown-toggle" id="filterButton" type="button" data-toggle="dropdown"><span class="caret"/></button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownmenu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Date (newest first)</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Date (oldest first)</a></li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Title (ASC)</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Title (DESC)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

<!--            <div class="row">
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="panel panel-default btn-panel btn-shadow">
                        <div class="panel-heading">Projekt 1</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="panel panel-default btn-panel btn-shadow">
                        <div class="panel-heading">Projekt 2</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="panel panel-default btn-panel btn-shadow">
                        <div class="panel-heading">Projekt 3</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="panel panel-default btn-panel btn-shadow">
                        <div class="panel-heading">Projekt 4</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="panel panel-default btn-panel btn-shadow">
                        <div class="panel-heading">Projekt 5</div>
                        <div class="panel-body">Panel Body</div>
                        <div class="panel-footer">Panel Footer</div>
                    </div>
                </div>
            </div>-->
            
        </div>

        <script>
            $(document).ready(function () {
                checkLanguage(function () {
                    var externals = new Array();
                    externals.push(['#alerts', PATH_EXTERNALS + '/' + currentLanguage + '/alerts.html']);
                    externals.push(['#templage-subpages', PATH_EXTERNALS + '/' + currentLanguage + '/template-sub-pages.html']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                console.log('onAllExternalsLoadedSuccessfully');
                renderSubPageElements();
            }

            $(".dropdown-menu").on('click', 'li a', function () {
                //alert($(this).val());
//                $(".btn:first-child").text($(this).text());
//                $(".btn:first-child").val($(this).text());
                document.getElementById("filterText").innerHTML = $(this).text();
                document.getElementById("filterText").value = "test";

            });
        </script>
    </body>
</html>
