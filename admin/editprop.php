<?php
    if( !empty($_POST) && isset($_POST['property_names']) ){
        $data['property_names'] = $_POST['property_names'];
        file_put_contents( ROOT.'/property_master.json', json_encode( $data ) );
        header( "Location: http://wfcseo.wfcdemo.com/admin/index.php?action=edit_prop" );
    }

    $get_properties  = file_get_contents( ROOT."/property_master.json" );
    $property_master = json_decode( $get_properties );
    //print_r( $property_master );
?>
<h3>Toggle Property Status</h3>
<div>
    <p>Check the box to activate the property. Active properties will be displayed on the dashboard.</p>
</div>
<form method="POST" name="property-visibility">
    <?php
        $sites = $wfc_core->getSitesList( $analytics );
        usort( $sites, array($wfc_core, 'property_sort') );
        $i = 1;
        foreach( $sites as $s ){
            $p_val = $s->getId().','.$wfc_core->sanitize_title( $s->getWebsiteUrl() );
            $chk = "";
            if( in_array( $p_val, (array)$property_master->property_names ) ){
                $chk = " checked='checked' ";
            }
            ?>
            <label for="property_names_<?php echo $i; ?>">
                <input <?php echo $chk; ?> type="checkbox" id="property_names_<?php echo $i; ?>" name="property_names[]" value="<?php echo $p_val; ?>"/>
                <?php echo $wfc_core->sanitize_title( $s->getWebsiteUrl() ); ?>
            </label>
            <br/>
            <?php
            $i++;
        }
    ?>
    <input type="submit" value="Update" name="update-property-visibility"/>
</form>
<hr/>