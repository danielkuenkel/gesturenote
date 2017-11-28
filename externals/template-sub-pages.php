<?php
include '../includes/language.php';
?>

<div class="hidden" id="header-footer-container">
    <nav class="navbar navbar-default navbar-fixed-top" id="sub-page-header">
        <div class="container">
            <div class="navbar-header" id="logo">
                <button class="navbar-toggle"><span class="icon-bar"></span></button>
                <a class="navbar-brand"><i class="glyphicon glyphicon-stats"></i> <?php echo $lang->gestureNote ?> <sup><span class="label label-success uppercase" style="position: relative; font-size: 6pt; letter-spacing: normal"><?php echo $lang->beta ?></span></sup></a>
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
            <span class="footer-copyright uppercase"><i class="glyphicon glyphicon-copyright-mark"></i> Daniel Künkel</span>
            <ul class="nav navbar-right">
                <li class="dropdown language-selection" id="language-selection">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src=""> <span class="language-indicator"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" id="de"><img src="img/flags/de.png"> <span><?php echo $lang->languages->de->language ?></span></a></li>
                        <li><a href="#" id="en"><img src="img/flags/en.png"> <span><?php echo $lang->languages->en->language ?></span></a></li>
                    </ul>
                </li>
                <li role="presentation"><a id="btn-imprint" class="uppercase" style="cursor: pointer"><?php echo $lang->imprint ?></a></li>
            </ul>
        </div>
    </nav>

</div>