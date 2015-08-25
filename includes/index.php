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
             id="view_site_template"
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
                              action="./index.php?export"
                              data-action="./index.php?export"
                              id="form_"
                              class="view_data"
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
                                    <?php for( $i = 2007; $i <= date( 'Y' ); $i++ ): ?>
                                        <?php $selected = ($i == date( 'Y' ) ? 'selected="selected"' : ''); ?>
                                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="hidden"
                                       name="code"
                                       id="code"
                                       ng-model="property.id"
                                       class="wfc-input form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                        data-action="ajax-right"
                                        data-target="exportReport"
                                        data-where="#form_"
                                        data-names="code,month,year"
                                        class="wfc-property-action-btn btn btn-sm btn-primary">Export Report
                                </button>
                                <input type="button"
                                       class="btn btn-sm btn-danger wfc-property-action-btn"
                                       value="Send Report"
                                       ng-click="sendReport()"/>
                                <!--                            <button type="submit" data-action="ajax-right" data-target="emailReport" data-where="#form_" data-names="code,month,year" class="btn btn-sm btn-danger wfc-property-action-btn">Send Report</button>-->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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
        <!-- /.modal --><!-- Modal -->
        <div class="modal fade"
             id="create_new"
             tabindex="-1"
             role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form role="form" method="POST" class="new" id="modalform" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="wfc-input form-control"
                                       placeholder="Enter Name"
                                       value=""/>
                            </div>
                            <div class="form-group">
                                <input type="text"
                                       id="awr_file_name"
                                       name="awr_file_name"
                                       class="wfc-input form-control"
                                       placeholder="Enter AWR Filename"
                                       value=""/>
                            </div>
                            <div class="form-group">
                                <label for="logo_upload">File input</label>
                                <input type="file" class="wfc-upload form-control" name="logo_upload" id="logo_upload">
                                <input type="hidden" name="logo">
                                <p class="help-block">Upload a logo</p>
                            </div>
                            <div class="form-group">
                                <input type="text"
                                       id="url"
                                       name="url"
                                       class="wfc-input form-control"
                                       placeholder="Enter URL"
                                       value=""/>
                            </div>
                            <div class="form-group">
                                <input type="text"
                                       id="code"
                                       readonly="readonly"
                                       class="wfc-input form-control"
                                       name="codenew"
                                       value=""/>
                            </div>
                            <div class="form-group">
                                <label for="template">Template</label>
                                <select class="wfc-select form-control" name="template">
                                    <?php
                                        $t = scandir( TPL_DIR.DS.$_SESSION['email'] );
                                        foreach( $t as $v ){
                                            if( $v != '.' && $v != '..' ){
                                                if( substr( $v, -3 ) == 'tpl' && $v != '.' && $v != '..' ){
                                                    echo '<option value="'.$v.'">'.substr( $v, 0, -4 ).'</option>';
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="submit"
                                    data-where="#modalform"
                                    data-target="new"
                                    data-names="name,awr_file_name,codenew,url,template,logo"
                                    class="form-control btn btn-default">Submit
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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
        <!-- /.modal -->
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
        <!-- /.modal -->
    </div>
</div>