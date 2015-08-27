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
                <?php
                    if( isset($_POST['code']) && intval( $_POST['code'] ) > 0 ){
                        $html = file_get_contents(
                            PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['code'] )].DS.intval( $_POST['code'] ).
                            DS.'template.tpl' );
                        echo $html;
                    } else{
                        if( isset($_GET['view']) && $_GET['view'] == 'templates' ){
                            $html = file_get_contents( TPL_DIR.DS.$_SESSION['email'].DS.$name );
                            echo $html;
                        } else{
                            echo '<p>Dashboard</p>'; ?>
                            <button class="scfDebug" ng-click="debugStatus = ! debugStatus">Show Debug</button>
                            <?php
                            echo '<p>Click to <a href="'.REAL_URL.'/index.php?tour=on">take the tour.</a></p>';
                            echo '<div ng-view class="view-animate"></div>';
                        }
                    }
                ?>
            </div>
        </div>
        <!--/.container-->
        <div class="modal fade"
             id="property_dashboard"
             tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true"
             modal-show>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form role="form"
                              method="POST"
                              action="./index.php?table"
                              data-action="./index.php?table"
                              id="form_"
                              class="edit_table_data"
                              enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="wfc-select form-control" name="month" ng-model="property.month">
                                    <?php foreach( $wfc_core->month_arr as $k => $m ): ?>
                                        <?php //@scftodo: future bug when January comes around ?>
                                        <?php $selected = ($k == date( 'm' ) - 01 ? 'selected="selected"' : ''); ?>
                                        <option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $m; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="wfc-select form-control" name="year" ng-model="property.year">
                                    <?php for( $i = 2014; $i <= date( 'Y' ); $i++ ): ?>
                                        <?php $selected = ($i == date( 'Y' ) ? 'selected="selected"' : ''); ?>
                                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="code" id="code" class="wfc-input form-control">
                                <input type="hidden"
                                       name="fnc"
                                       id="updatemanualdata"
                                       class="wfc-input form-control"
                                       value="editmanualdata">
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                        data-action="ajax-updatemanualdata"
                                        class="wfc-property-action-btn btn btn-sm btn-primary">Continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade"
             id="viewmetrics"
             tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true"
             modal-show>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form role="form"
                              method="POST"
                              id="form_viewmetrics"
                              class="viewmetrics"
                              enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="year">From Month</label>
                                    <select class="wfc-select form-control" name="f_month">
                                        <?php foreach( $wfc_core->month_arr as $k => $m ): ?>
                                            <option value="<?php echo $k; ?>"><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="month">To Month</label>
                                    <select class="wfc-select form-control" name="t_month">
                                        <?php foreach( $wfc_core->month_arr as $k => $m ): ?>
                                            <option value="<?php echo $k; ?>" <?php echo ($m == date("M") ? "selected" : ""); ?>><?php echo $m; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="year">From Year</label>
                                    <select class="wfc-select form-control" name="f_year">
                                        <?php for( $i = 2014; $i <= date( 'Y' ); $i++ ): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="year">To Year</label>
                                    <select class="wfc-select form-control" name="t_year">
                                        <?php for( $i = 2014; $i <= date( 'Y' ); $i++ ): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == "2015" ? "selected" : ""); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="code" id="code" class="wfc-input form-control">
                                <input type="hidden"
                                       name="fnc"
                                       id="viewmetrics"
                                       class="wfc-input form-control"
                                       value="viewmetrics">
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                        data-action="ajax-viewmetrics"
                                        class="wfc-property-action-btn btn btn-sm btn-primary">Continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade"
             data-backdrop="static"
             data-keyboard="false"
             id="afk"
             tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>You have been disconnected due to your inactivity,
                            <a href="index.php">click here to reconnect.</a>
                        </p>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade"
             id="notalone"
             tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>You are not alone ! Someone else just connected to the same account. Naybe you would like to
                            <a href="<?php echo $revokeUrl; ?>">disconnect this account.</a>
                        </p>
                        <p>Or maybe you don't care, then you can just click outside of the box and keep using the application.</p>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>