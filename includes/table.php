<?php
    print_r( $_POST );
    $manual_data_file =
        PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS.$_POST['month'].DS.'data.json';
    $man_data = array();
    if( file_exists( $manual_data_file ) ){
        $man_data = unserialize( file_get_contents( $manual_data_file ) );
        print_r( $man_data['sales'] );

    }
?>
<div id="manual-data-form-wrapper">
    <form method="POST" action="#" id="manual-data-form">
        <input type="hidden" name="fnc" value="updatemanualdata"/>
        <input type="hidden" name="code" value="<?php echo $_POST['code'] ?>"/>
        <input type="hidden" name="month" value="<?php echo $_POST['month'] ?>"/>
        <input type="hidden" name="year" value="<?php echo $_POST['year'] ?>"/>
        <input name="sales" placeholder="Sales" value="<?php echo $man_data['sales'] ?>"/>
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
                    toastr.success(data,'Information');
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
<?php
    define( 'MONTH', "05" );
    define( 'YEAR', "2015" );
    define( 'TABLE_ID', $_POST['code'] );
    $allgoal = allgoal_completions();
    //    print_r($allgoal);
    $metricArr = array(
        'Paid' => 'allgoal_completions'
    );
    /* $metricArr = array(
     'Paid',
     'Organic',
     'Direct',
     'Referral',
     'Social',
     'Conversions (Analytics)',
     'Sessions',
     'Click',
     'PPC Impressions',
     'Search CTR',
     'PPC Cost',
     'Cost Per Conversion',
     'Website Opportunities',
     'Closed Opportunities',
     'Closing Ratio',
     'Sales',
     'Money Earned Per Lead',
     'Average Sale',
     'Goals',
     'Ad Revenue Percentage'
 );*/
?>
<table id='table1'>
    <?php foreach( $allgoal as $k => $v ): ?>
        <tr>
            <td><?php echo $k ?></td>
            <td><?php echo $v ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td>Classifieds</td>
        <td>**NEED FN **</td>
    </tr>
    <tr>
        <td>Sessions</td>
        <td><?php echo sessions() ?></td>
    </tr>
    <tr>
        <td>Clicks</td>
        <td><?php echo adwords_clicks() ?></td>
    </tr>
    <tr>
        <td>Impressions</td>
        <td><?php echo adwords_impressions() ?></td>
    </tr>
</table>