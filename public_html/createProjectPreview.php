<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GestureNote</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="css/createProjectPreview.css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
        <script src="http://chancejs.com/chance.min.js"></script>
        <script src="js/constants.js"></script>
        <script src="js/thumbscrubber.js"></script>
        <script src="js/gotoPage.js"></script>
        <!--<script src="js/subPages.js"></script>-->
        <script src="js/storage.js"></script>
        <script src="js/createProjectPreview.js"></script>
    </head>
    <body>

        <div w3-include-HTML="template-forms.html"></div>

        <div class="form-group navbar-fixed-top" id="preview-bar-top" style="padding: 10px;">

            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-gn">Mederator</button>
                    <button type="button" class="btn btn-default">Tester</button>
                </div>
                <!--<span class="input-group-addon">Projektphase</span>-->
                <input class="form-control item-input-text option-phase-steps show-dropdown text-center readonly" type="text" value=""/>
                <div class="input-group-btn phaseStepsSelect select" role="group">
                    <button class="btn btn-default btn-dropdown dropdown-toggle" id="btn-phaseStepSelect" type="button" data-toggle="dropdown"><span class="selected hidden" id="unselected"></span><span class="caret"></span></button>
                    <ul class="dropdown-menu option dropdown-menu-right" role="menu">
<!--                        <li id="elicitation"><a href="#">Ermittlung</a></li>
                        <li id="evaluation"><a href="#">Evaluierung</a></li>-->
                    </ul>
                    <button type="button" class="btn btn-danger" onclick="gotoCreateProject()"><i class="glyphicon glyphicon-remove"></i> Schließen</button>
                </div>
                <!--                <div class="input-group-btn">
                                    
                                </div>-->
            </div>
        </div>

        <!--        <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="navbar-header" style="top: 10px; left: 15px; position: absolute;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default btn-gn">Mederator</button>
                            <button type="button" class="btn btn-sm btn-default">Tester</button>
                        </div>
        
                    </div>
                    <div style="width: 100%;">
                        <div class="navbar-header pull-right" style="top: 10px; right: 15px; position: relative">
                            <button type="button" class="btn btn-sm btn-danger" onclick="gotoCreateProject()"><i class="glyphicon glyphicon-remove"></i> Vorschau schließen</button>
                        </div>
                    </div>
                </nav>-->

        <div id="progressTop">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 50%">
                    50%
                </div>
            </div>
        </div>




        <!--<div class="container-fluid">test</div>-->

        <!-- Container (Breadcrump) -->
        <!--        <div class="container" id="breadcrumb">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li><a class="breadcrump-btn" onclick="gotoIndex()">Home</a></li>
                            <li><a class="breadcrump-btn" onclick="gotoMainLanding()">Hauptmenü</a></li>
                            <li><a class="breadcrump-btn" onclick="gotoProjects()">Projekte</a></li>
                            <li class="active">Neues Projekt</li>
                        </ol>
                    </div>
                </div>-->

        <!-- Modal -->
        <div id="custom-modal" class="modal fade custom-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="mainContent" style="padding-top: 100px;">
        </div>


        <script>
            $(document).ready(function () {

                if (typeof (Storage) !== "undefined") {
                    checkStorage();
                } else {
                    console.log("Sorry, your browser do not support Web Session Storage.");
                }
            });
            
            $('body').on('click', '.select .option li', function (event) {
                event.preventDefault();

//                if ($(this).hasClass('dropdown-header') || $(this).hasClass('divider')) {
//                    return false;
//                }
    
                var parent = $(this).closest('.select');
                var itemText = $(this).children().text();
                var listItemId = $(this).attr('id');
                $(parent).find('.selected').attr('id', listItemId);
                $(parent).prev().val(itemText);
                $(this).parent().children('li').removeClass('selected');
                $(this).addClass('selected');

//                var disabledElements = $(parent).children('.dropdown-disabled');
//                if (disabledElements.length > 0) {
//                    for (var i = 0; i < disabledElements.length; i++) {
//                        $(disabledElements[i]).removeClass('disabled');
//                    }
//                }
            });
            
            $('body').on('click', '.show-dropdown', function(event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).next().find('[data-toggle=dropdown]').dropdown('toggle');
            });
        </script>
        <script src="js/w3-include-HTML.js"></script>
    </body>
</html>