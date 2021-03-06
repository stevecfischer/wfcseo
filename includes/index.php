<?php
    $wfc_core = new wfc_core_class;
?>
<div ng-controller="dashboard">
    <div id="container" class="" ng-controller="propController2">
        <scf-header></scf-header>
        <div class="row row-offcanvas row-offcanvas-right" ng-controller="sidebarMenu">
            <div class="col-md-4  sidebar-menu" id="sidebar">
                <span class="glyphicon glyphicon-chevron-left sidebar-menu-toggle"></span>
                <?php require_once('sidebar.php'); ?>
            </div>
            <div class="col-md-8 main-content">
                <h2>{{message}}</h2>
                <?php echo '<p>Dashboard</p>'; ?>
                <button class="scfDebug" ng-click="debugStatus = ! debugStatus">Show Debug</button>
                <?php
                    echo '<p>Click to <a href="'.REAL_URL.'/index.php?tour=on">take the tour.</a></p>';
                    echo '<div ng-view class="view-animate"></div>';
                ?>
            </div>
        </div>
        <!--/.container-->