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
                                            <option value="<?php echo $k; ?>" <?php echo($m == date( "M" ) ?
                                                "selected" : ""); ?>><?php echo $m; ?></option>
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
                                            <option value="<?php echo $i; ?>" <?php echo($i == "2015" ? "selected" :
                                                ""); ?>><?php echo $i; ?></option>
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
<?php
    $localizeJs  = new wfc_core_class();
    $accessToken = $storage->get();
    $tokenObj    = json_decode( $accessToken );

    $scfLocalizedStr =
        'var wfcLocalized = {"site":"'.URL.'", "ajaxurl":"'.AJAX_URL.'", "access_token":"'.$tokenObj->access_token.
        '"};';
    $localizeJs->print_extra_script( $scfLocalizedStr );
?>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular-route.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/app.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/chart.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular-chart.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/ng-table.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/angular-resource.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URI; ?>/ui-bootstrap-angular.min.js"></script>
<!-- ANGULARJS CONTROLLERS -->
<script type="text/javascript" src="<?php echo CONTROLLERS_URI; ?>/chartController.js"></script>
<script type="text/javascript" src="<?php echo CONTROLLERS_URI; ?>/sandController.js"></script>
<script type="text/javascript" src="<?php echo CONTROLLERS_URI; ?>/dashController.js"></script>
<!-- ANGULARJS DIRECTIVES -->
<script type="text/javascript" src="<?php echo DIRECTIVES_URI; ?>/directives.js"></script>
<!-- ANGULARJS SERVICES -->
<script type="text/javascript" src="<?php echo SERVICES_URI; ?>/sandService.js"></script>
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

