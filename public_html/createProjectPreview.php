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

        <nav class="navbar navbar-default navbar-fixed-top">
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
        </nav>
        <div class="line text-center"></div>

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

        </script>
        <script src="js/w3-include-HTML.js"></script>
    </body>
</html>