<?php
    /*
    * All the ajax actions are here
    *
    */
    include_once __DIR__.'/../load.php';
    if( !$authHelper->isAuthorized() ){
        exit('<script type="text/javascript">window.location.href = "'.$authUrl.'";</script>');
    }
    if( isset($_POST['fnc']) ){
        $fnc = 'ajax_'.preg_replace( '#[^a-zA-Z0-9\\-]#i', '', $_POST['fnc'] );
    } else{
        if( isset($_FILES) ){
            $fnc = 'ajax_uploadImg';
        } else{
            $fnc = 'ajax_revokeUser';
        }
    }
    if( function_exists( $fnc ) ){
        call_user_func( $fnc );
    } else{
        exit();
    }
    function ajax_tplOnly(){
        $name = preg_replace( '#[^.a-zA-Z0-9_-]#i', '', $_POST['name'] );
        if( file_exists( TPL_DIR.DS.$_SESSION['email'].DS.$name ) ){
            include_once TPL_DIR.DS.$_SESSION['email'].DS.$name;
        } else{
            exit();
        }
    }

    function ajax_tplValues(){
        define( 'MONTH', sprintf( "%02s", intval( $_POST['month'] ) ) );
        define( 'YEAR', intval( $_POST['year'] ) );
        define( 'TABLE_ID', intval( $_POST['code'] ) );
        exit(parse_content(
            file_get_contents(
                PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'template.tpl' ) ));
    }

    function ajax_emailReport(){
        include_once 'steve_email.php';
    }

    function ajax_viewReport(){
        //@sftodo: allow user to view pdf instead of downloading
        echo '<script type="text/javascript">window.open("http://www.w3schools.com");</script>';
        //include_once 'steve_email.php';
    }

    function ajax_exportReport(){
        include_once 'export.php';
    }

    function ajax_customTpl(){
        if( file_exists( PROP_DIR.DS.$_SESSION['properties'][$_POST['code']].DS.$_POST['code'].DS.'template.tpl' ) ){
            //include_once PROP_DIR.DS.$_SESSION['properties'][$_POST['code']].DS.$_POST['code'].DS.'template.tpl';
        } else{
            exit('What do we say to the hacker ? Not today !');
        }
    }

    function ajax_new(){
        include_once ROOT.DS.'includes'.DS.'new.php';
    }

    function ajax_edit(){
        include_once ROOT.DS.'includes'.DS.'edit.php';
    }

    function ajax_table(){
        $path_year  = PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS;
        $path_month = PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS.$_POST['month'].DS;
        if( !file_exists( $path_year ) ){
            if( !mkdir( $path_year, 0777, true ) ){
                echo "ERROR creating year path. See file: ".__FILE__;
            }
        }
        if( !file_exists( $path_month ) ){
            if( !mkdir( $path_month, 0777, true ) ){
                echo $path_month;
                echo "ERROR creating month path. See file: ".__FILE__;
            }
        }
        include_once ROOT.DS.'includes'.DS.'table.php';
    }

    function ajax_viewmetrics(){
        include_once ROOT.DS.'includes'.DS.'view_metrics.php';
    }

    function ajax_editmanualdata(){
        $path_year  = PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS;
        $path_month = PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS.$_POST['month'].DS;
        if( !file_exists( $path_year ) ){
            if( !mkdir( $path_year, 0777, true ) ){
                echo "ERROR creating year path. See file: ".__FILE__;
            }
        }
        if( !file_exists( $path_month ) ){
            if( !mkdir( $path_month, 0777, true ) ){
                echo $path_month;
                echo "ERROR creating month path. See file: ".__FILE__;
            }
        }
        include_once ROOT.DS.'includes'.DS.'edit_manual_data.php';
    }

    function ajax_updatemanualdata(){
        $manual_data_file =
            PROP_DIR.DS.intval( $_POST['code'] ).DS.intval( $_POST['year'] ).DS.$_POST['month'].DS.'data.json';
        if(!file_put_contents( $manual_data_file, serialize( $_POST ) )){
            echo "Error Saving";
        }else{
            echo "Saved";
        }
    }

    function templateEdit(){
        include_once ROOT.DS.'includes'.DS.'template-edit.php';
    }

    function ajax_delete(){
        if( isset($_POST['name']) ){
            $name = preg_replace( '#[^.a-z0-9_-]#i', '', $_POST['name'] );
            @unlink( TPL_DIR.DS.$_SESSION['email'].DS.$name );
            echo '<script type="text/javascript">toastr.success(\'Template deleted\', \'Information\');</script>';
        } else{
            if( isset($_POST['code']) ){
                $code = intval( $_POST['code'] );
                deleteDirectory( PROP_DIR.DS.$_SESSION['properties'][$code].DS.$code.DS );
                echo '<script type="text/javascript">toastr.success(\'Customized Template deleted\', \'Information\');</script>';
            } else{
                exit('What do we say to the hacker ? Not today !');
            }
        }
    }

    function ajax_email(){
        include_once ROOT.DS.'includes'.DS.'email.php';
    }

    function ajax_uploadImg(){
        //$path = PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['codenew'] )].DS.intval( $_POST['codenew'] ).DS;
        $path = PROP_DIR.DS.intval( $_POST['codenew'] ).DS;
        if( !file_exists( PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['codenew'] )] ) ){
            mkdir( PROP_DIR.DS.$_SESSION['properties'][intval( $_POST['codenew'] )] );
        }
        if( !file_exists( $path ) ){
            mkdir( $path );
        }
        if( isset($_FILES['logo_upload']) && $_FILES['logo_upload']['size'] > 0 ){
            $tmp_name      = $_FILES["logo_upload"]["tmp_name"];
            $name          = $_FILES['logo_upload']['name'];
            $scf_img       = new wfc_core_class();
            $uploaded_logo = $scf_img->upload_file( $name, $path, $tmp_name, $_POST['codenew'] );
            $infos['logo'] = $uploaded_logo;
            echo $infos['logo'];
            /*move_uploaded_file(
                $_FILES['logo_upload']['tmp_name'],
                $path.'logo-'.intval( $_POST['codenew'] ).'.'.
                substr( $_FILES['logo_upload']['name'], strrpos( $_FILES['logo_upload']['name'], '.' ) + 1, strlen( $_FILES['logo_upload']['name'] ) ) );
            $img = imagecreatefromstring(
                file_get_contents(
                    $path.'logo-'.intval( $_POST['codenew'] ).'.'.
                    substr( $_FILES['logo_upload']['name'], strrpos( $_FILES['logo_upload']['name'], '.' ) + 1, strlen( $_FILES['logo_upload']['name'] ) ) ) );
            imagepng( $img, $path.'logo-'.intval( $_POST['codenew'] ).'.png' );
            if( substr(
                    $path.'logo-'.intval( $_POST['codenew'] ).'.'.
                    substr( $_FILES['logo_upload']['name'], strrpos( $_FILES['logo_upload']['name'], '.' ) + 1, strlen( $_FILES['logo_upload']['name'] ) ), -3 ) != 'png'
            ){
                @unlink(
                    $path.'logo-'.intval( $_POST['codenew'] ).'.'.
                    substr( $_FILES['logo_upload']['name'], strrpos( $_FILES['logo_upload']['name'], '.' ) + 1, strlen( $_FILES['logo_upload']['name'] ) ) );
            }
            $infos['logo'] = $name;
            echo $infos['logo'];*/
        } else{
            //exit('What do we say to the hacker ? Not today !');
        }
    }

    function ajax_revokeUser(){
        $users = unserialize( file_get_contents( __DIR__.DS.'users.ini' ) );
        unset($users[$_SESSION['email']]);
        file_put_contents( __DIR__.DS.'users.ini', serialize( $users ) );
        exit('Disconnected');
    }

    function deleteDirectory( $dir ){
        if( !file_exists( $dir ) ){
            return true;
        }
        if( !is_dir( $dir ) ){
            return @unlink( $dir );
        }
        foreach( scandir( $dir ) as $item ){
            if( $item == '.' || $item == '..' ){
                continue;
            }
            if( !deleteDirectory( $dir.DIRECTORY_SEPARATOR.$item ) ){
                return false;
            }
        }
        return @rmdir( $dir );
    }

