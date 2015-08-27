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
                <?php require_once 'view_metrics.php'; ?>
            </div>
        </div>
