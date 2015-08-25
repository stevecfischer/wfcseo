<?php

    require_once 'load.php';

    // Print out authorization URL.
    if( !$authHelper->isAuthorized() ){
        echo "<p id=\"revoke\"><a href='$authUrl'>Grant access to Google Analytics data</a></p>";
        exit;
    }

    //Deal with POST datas
    require_once './includes/datas.php';

    if( isset($_GET['export']) && isset($_POST['code']) ){
        require_once './includes/export.php';
    }
?>
<!DOCTYPE html>
<html ng-app="awr">
<head>
    <meta charset="UTF-8">
    <title>WFC Local</title>
    <link href="<?php echo CSS_URI; ?>/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URI; ?>/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URI; ?>/toastr.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URI; ?>/angular-chart.css"/>
    <base href="http://wfcseo.wfcdemo.com/">
</head>
<body ng-controller="scfDebug">
<?php
    if( isset($_GET['create_new']) ){
        require_once './includes/new.php';
    } else{
        if( isset($_GET['export']) && isset($_POST['code']) ){
            //require_once './includes/export.php';
        } else{
            require_once './includes/index.php';
        }
    }

    $localizeJs      = new wfc_core_class();
    $scfLocalizedStr = 'var wfcLocalized = {"site":"http:\/\/rjs.wfcdemo.com\/cms-wfc"};';
    $localizeJs->print_extra_script( $scfLocalizedStr );
?>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular-route.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/app.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/chart.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular-chart.min.js"></script>
<!-- ANGULARJS CONTROLLERS -->
<script type="text/javascript" src="<?php echo CONTROLLERS_URI; ?>/chartController.js"></script>
<script type="text/javascript" src="<?php echo CONTROLLERS_URI; ?>/sandController.js"></script>
<!-- ANGULARJS DIRECTIVES -->
<script type="text/javascript" src="<?php echo DIRECTIVES_URI; ?>/directives.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/jquery.js"></script>
<!--        <script type="text/javascript" src="--><?php //echo JS_URI; ?><!--/form.js"></script>-->
<script type="text/javascript" src="<?php echo URL; ?>/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/toastr.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/bootstrap.min.js"></script>
<!--        <script type="text/javascript" src="--><?php //echo JS_URI; ?><!--/bootbox.min.js"></script>-->
<script type="text/javascript" src="<?php echo JS_URI; ?>/jQuery.download.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/scripts.js"></script>
<!--        <script type="text/javascript" src="--><?php //echo JS_URI; ?><!--/jquery.scrollto.min.js"></script>-->
<?php
    if( isset($notif) ){
        echo '<script type="text/javascript">toastr.success(\''.$notif.'\',\'Information\');</script>';
    }

    if( $users[$_SESSION['email']] > time() ){
        echo '<script type="text/javascript">$("#notalone").modal("show");</script>';
    }

    require_once './includes/app_tour_guide.php';
?>
<footer>
    <div class="scroll-to-top">Scroll to To Top</div>
    <p class="copyright text-center">Copyright © <?php echo date( 'Y', strtotime( "NOW" ) ) ?> All right reserved. Website designed by:
        <a href="http://www.webfullcircle.com" target="_blank">Webfullcircle.com</a>
    </p>
</footer>
</body>
</html>

