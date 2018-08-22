<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteNews ?></title>
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
                    <!--<li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>-->
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active" data-id="btn-news"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <?php echo $lang->breadcrump->news ?></li>
                </ol>
            </div>
        </div>

        <div class="container mainContent" id="news-list" style="margin-top: 0px">
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

                var allNews = translation.allNews;
                for (var i = 0; i < allNews.length; i++) {
                    var newsItem = document.createElement('div');
                    $(newsItem).addClass('row');
                    $('#news-list').append(newsItem);

                    var col = document.createElement('div');
                    $(col).addClass('col-xs-12 col-sm-2 col-lg-1');
                    $(newsItem).append(col);

                    var date = new Date(allNews[i].date);
                    var newsDate = document.createElement('span');
                    $(newsDate).text(date.toLocaleDateString());
                    $(col).append(newsDate);

                    var col = document.createElement('div');
                    $(col).addClass('col-xs-12 col-sm-10 col-lg-11');
                    $(newsItem).append(col);

                    var newsTitle = document.createElement('span');
                    $(newsTitle).text(allNews[i].title);
                    $(newsTitle).addClass('text font-bold');
                    $(col).append(newsTitle);

                    var newsContent = document.createElement('div');
                    $(newsContent).html(allNews[i].content);
                    $(newsContent).addClass('text');
                    $(col).append(newsContent);

                    if (i > 0) {
                        $(newsItem).css({marginTop: '40px'});
                    }
                }
            }
        </script>

    </body>
</html>