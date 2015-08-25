<?php
    $manual_data_file =
        PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS.$_POST['month'].DS.'data.json';
    $man_data         = array();
    if( file_exists( $manual_data_file ) ){
        $man_data = unserialize( file_get_contents( $manual_data_file ) );
    }
?>
<div id="manual-data-form-wrapper">
    <form method="POST" action="#" id="manual-data-form">
        <input type="hidden" name="fnc" value="updatemanualdata"/>
        <input type="hidden" name="code" value="<?php echo $_POST['code'] ?>"/>
        <input type="hidden" name="month" value="<?php echo $_POST['month'] ?>"/>
        <input type="hidden" name="year" value="<?php echo $_POST['year'] ?>"/>
        <div class="input-group">
            <span class="input-group-addon">Cost Per Conversion</span><span class="input-group-addon"> $ </span>
            <input name="cost_per_conversion" class="form-control" value="<?php echo $man_data['cost_per_conversion'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Closed Opportunities (Total)</span>
            <input name="closed_opportunities" class="form-control" value="<?php echo $man_data['closed_opportunities'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Closing Ratio</span>
            <input name="closing_ratio" class="form-control" value="<?php echo $man_data['closing_ratio'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Sales</span><span class="input-group-addon"> $ </span>
            <input name="sales" class="form-control" value="<?php echo $man_data['sales'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Money Earned Per Lead</span><span class="input-group-addon"> $ </span>
            <input name="money_earned_per_lead" class="form-control" value="<?php echo $man_data['money_earned_per_lead'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Average Sale</span><span class="input-group-addon"> $ </span>
            <input name="average_sale" class="form-control" value="<?php echo $man_data['average_sale'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Goals</span><span class="input-group-addon"> $ </span>
            <input name="goals" class="form-control" value="<?php echo $man_data['goals'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">Ad Revenue Percentage</span>
            <input name="ad_revenue_percentage" class="form-control" value="<?php echo $man_data['ad_revenue_percentage'] ?>"/>
        </div>
        <div class="input-group">
            <span class="input-group-addon">SERP Calls</span>
            <input name="serp_calls" class="form-control" value="<?php echo $man_data['serp_calls'] ?>"/>
        </div>
        <button type="submit" class="update_manual_data">Update</button>
    </form>
</div>
<script>
    jQuery(function ($) {
        $('#manual-data-form-wrapper').on('click', '.update_manual_data', function (e) {
            e.preventDefault();
            var d = $('#manual-data-form').serializeArray();
            console.log(d);
            $.ajax({
                url: "../includes/ajax.php",
                type: "POST",
                data: d,
                success: function (data) {
                    toastr.success(data, 'Information');
                    console.log(data);
                }
            });
        })
    });
</script>
<?php
    if( isset($_POST['code']) ){ //Customized template
        $wfc_core                 = new wfc_core_class;
        $wfc_core->activeProperty = $_POST['code'];
        if( !$wfc_core->buildPropertyDirectory( $_POST['code'] ) ){
            exit("Error, Unable to build folder");
        }
        //if( isset($_POST['name']) || isset($_POST['code']) ){ //EDIT
        $f        = fopen( PROP_DIR.DS.intval( $_POST['code'] ).DS.'template.tpl', 'r' );
        $infos    = unserialize( file_get_contents( PROP_DIR.DS.intval( $_POST['code'] ).DS.'profile.ini' ) );
        $textarea = $wfc_core->parseTpl( $f, true );
        $hidden   = '<input type="hidden" name="code" value="'.$_POST['code'].'" />';
    } else{
        exit("Error, no property selected");
    }
    //}
    //    else{ //NEW TPL
    //        $textarea = '<textarea name="content[0]" id="content0" style="width:100%;height:400px;"></textarea>';
    //        $hidden   = '<input type="hidden" name="nb_textarea" id="nb_textarea" value="1" />';
    //    }
?>
<div class="<?php echo __FILE__; ?>">
    <?php //require_once("content-editor.php"); ?>
</div>