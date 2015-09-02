<?php

    require_once 'load.php';

    // Print out authorization URL.
    if( !$authHelper->isAuthorized() ){
        echo "<p id=\"revoke\"><a href='$authUrl'>Grant access to Google Analytics data</a></p>";
        exit;
    }

    //Deal with POST datas
    require_once './includes/datas.php';
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
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URI; ?>/ng-table.min.css"/>
    <base href="http://wfcseo.wfcdemo.com/">
</head>
<body ng-controller="scfDebug">
<?php
    //require_once './includes/index.php';
?>
<?php
    $wfc_core = new wfc_core_class;
?>
    <div ng-controller="dashboard">
    <div id="container">
    <div class="collapse navbar-collapse toolbar wfc-toolbar">
        <ul class="nav navbar-nav navbar-left">
            <li>
            <p class="navbar-text">Welcome <strong>{{username}}</strong></p>
            </li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="dropdown">
            <a href="#"
               class="dropdown-toggle"
               data-toggle="dropdown"
               role="button"
               aria-haspopup="true"
               aria-expanded="false">Web Properties
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <?php
                    $get_properties  = file_get_contents( "property_master.json" );
                    $property_master = json_decode( $get_properties );
                    foreach( $property_master->property_names as $p ){
                        $prop   = explode( ",", $p );
                        $propID = $prop[0];
                        ?>
                        <li ng-click="getProfile(<?php echo $propID; ?>)" class="dropdown-submenu wfc-web-property">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="wfc-property-url"><?php echo $wfc_core->sanitize_title( $prop[1] ); ?>
                                <span ng-show="debugStatus"> - <?php echo $propID; ?></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu"  role="menu" >
                            <li>
                            <a data-code="<?php echo $propID; ?>"
                               data-toggle="modal"
                               class="table-site-template"
                               data-names="code"
                               data-where="this"
                               data-target="#property_dashboard">Edit Manual Data
                            </a>
                            <a data-code="<?php echo $propID; ?>"
                               data-toggle="modal"
                               class="view-metrics"
                               data-names="code"
                               data-where="this"
                               data-target="#viewmetrics">View Metrics
                            </a>
                            </li>
                        </ul>
                        </li>
                        <?php
                    }//endforeach
                ?>
            </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
            <a data-toggle="tooltip" data-placement="bottom" title="Sandbox" href="/sandbox/">
                <span class="glyphicon glyphicon-asterisk"></span>
            </a>
            </li>
            <li>
            <a data-toggle="tooltip" data-placement="bottom" title="Home" href="#dashboard">
                <span class="glyphicon glyphicon-home"></span>
            </a>
            </li>
            <li>
            <a data-toggle="tooltip" data-placement="bottom" title="Refresh" href="index.php?refresh">
                <span class="glyphicon glyphicon-retweet"></span>
            </a>
            </li>
            <li>
            <a class="wfc-documentation"
               data-toggle="tooltip"
               data-placement="bottom"
               title="Documentation"
               href="https://github.com/stevecfischer/wfcseo/wiki"
               target="_blank">
                <span class="glyphicon glyphicon-list-alt"></span>
            </a>
            </li>
            <li>
            <a class="wfc-logout"
               data-toggle="tooltip"
               data-placement="bottom"
               title="Logout"
               href="<?php echo $revokeUrl; ?>">
                <span class="glyphicon glyphicon-log-out"></span>
            </a>
            </li>
        </ul>
    </div>