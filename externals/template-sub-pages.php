<?php
include '../includes/language.php';
?>

<div class="hidden" id="header-footer-container">
    <nav class="navbar navbar-default navbar-fixed-top" id="sub-page-header">
        <div class="container">
            <div class="navbar-header" id="logo">
                <button class="navbar-toggle"><span class="icon-bar"></span></button>
                <a class="navbar-brand"><i class="glyphicon glyphicon-stats"></i> <?php echo $lang->gesturenote ?> <sup><span class="label label-success uppercase" style="position: relative; font-size: 6pt; letter-spacing: normal"><?php echo $lang->beta ?></span></sup></a>
            </div>
            <div>
                <ul class="nav navbar-nav navbar-right">
                    <li id="btn-sign-out"><a href="#"><i class="fa fa-lock"></i> <span class="btn-text uppercase"><?php echo $lang->signOut ?></span></a></li>
                </ul>
            </div>
        </div>
        <div class="line text-center"></div>
    </nav>


    <nav class="navbar navbar-default navbar-fixed-bottom" id="sub-page-footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <span class="footer-copyright"><i class="glyphicon glyphicon-copyright-mark"></i> DANIEL KUENKEL</span>
                </div>
                <div class="col-xs-6">
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation"><a id="btn-imprint" class="uppercase" style="cursor: pointer"><?php echo $lang->imprint ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>