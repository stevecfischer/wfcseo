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
<?php require_once 'header.php'; ?>
<?php
    //require_once './includes/index.php';
?>
<?php
    $wfc_core = new wfc_core_class;
?>
    <div ng-controller="dashboard">
    <div id="container" class="" ng-controller="propController2">
    <scf-header></scf-header>
    <div class="row row-offcanvas row-offcanvas-right" ng-controller="sidebarMenu">
        <div class="col-md-4  sidebar-menu" id="sidebar">
            <span class="glyphicon glyphicon-chevron-left sidebar-menu-toggle"></span>

        </div>
        <div class="col-md-8 main-content">
            <section id="directives" ng-controller="MetricController">
                <?php require_once 'view_metrics_test.php'; ?>
                <div class="row">
                    <div class="col-lg-6 col-sm-12" id="line-chart">
                        <div class="panel panel-default">
                            <div class="panel-heading">Line Chart</div>
                            <div class="panel-body">
                                <canvas id="line" class="chart chart-line" data="data" labels="labels" legend="true"
                                        click="onClick" hover="onHover" series="series"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--/.container-->
<?php
    require_once 'footer.php';