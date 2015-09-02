<?php require_once 'header.php'; ?>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-md-12 main-content">
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
<?php
    require_once 'footer.php';