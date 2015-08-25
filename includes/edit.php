<?php
    if( isset($_POST['code']) ){ //Customized template
        $wfc_core = new wfc_core_class;
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
    <?php require_once("content-editor.php"); ?>
</div>