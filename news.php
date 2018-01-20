<?php
include './includes/language.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $lang->gestureNoteNews ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/generalSubPages.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
        <div id="template-subpages"></div>



        <!-- Container (Landing Section) -->
        <div class="container" id="breadcrumb" style="margin-top: 40px">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a class="breadcrump-btn" id="btn-index"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $lang->breadcrump->home ?></a></li>
                    <li><a class="breadcrump-btn" id="btn-dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> <?php echo $lang->breadcrump->dashboard ?></a></li>
                    <li class="active"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <?php echo $lang->breadcrump->news ?></li>
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
                    externals.push(['#template-subpages', PATH_EXTERNALS + 'template-sub-pages.php']);
                    loadExternals(externals);
                });
            });

            function onAllExternalsLoadedSuccessfully() {
                var loggedIn = parseInt('<?php echo login_check($mysqli) ?>') === 1;
                renderSubPageElements(loggedIn, false);
                console.log(loggedIn);
                
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
                        $(newsItem).css({marginTop: '20px'});
                    }
                }
            }
        </script>

    </body>
</html>