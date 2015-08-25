<?php
    $wfc_core = new wfc_core_class;
    if( isset($_POST) && !empty($_POST['codenew']) ){ //NEW CUSTOMIZED TPL
        if( !is_dir( PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['codenew'] )].DS.intval( $_POST['codenew'] ) ) ){
            mkdir( PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['codenew'] )].DS.intval( $_POST['codenew'] ) );
        }
        if( isset($_POST['logo']) ){
            $infos['logo'] = $_POST['logo'];
        }
        $infos['name']          = $_POST['name'];
        $infos['url']           = $_POST['url'];
        $infos['awr_file_name'] = $_POST['awr_file_name'];
        $infos['code']          = $_POST['codenew'];
        $infos['emails']        = str_replace( ' ', '', (isset($_POST['emails']) ? $_POST['emails'] : '') );
        $f                      = fopen( PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['codenew'] )].DS.intval( $_POST['codenew'] ).DS.'profile.ini', 'w+' );
        fwrite( $f, serialize( $infos ) );
        fclose( $f );
        $f        = fopen( TPL_DIR.DS.$_SESSION['email'].DS.$_POST['template'], 'r' );
        $textarea = $wfc_core->parseTpl( $f );
        $hidden   = '<input type="hidden" name="code" id="code" value="'.intval( $_POST['codenew'] ).'" />';
    }else{
        die("Access Denied");
    }
?>
<div class="<?php echo __FILE__; ?>">
    <?php require_once("content-editor.php"); ?>
</div>