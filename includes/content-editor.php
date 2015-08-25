<div id="editor">
    <form method="POST" enctype="multipart/form-data" action="index.php<?php if( !isset($infos) ){
        echo '?view=templates';
    } ?>" style="width:100%;float:left;" id="form_tpl">
        <?php echo $hidden; ?>
        <?php
            if( isset($infos) && is_array( $infos ) ){
                echo '<div id="profile">
            <span class="box_logo">
            '.(!empty($infos['logo']) ?
                        '<img src="'.$infos['logo'].'?t='.time().'" alt="Logo" />' :
                        'Name is used, upload a logo instead <input type="file" name="logo" />').'
            </span>
            <input type="hidden" value="1" class="keep_logo" name="keep_logo" />
            <div class="input-group">
                <span class="input-group-addon">Name</span>
                <input type="text" class="form-control" name="sitename" value="'.stripslashes( $infos['name'] ).'" />
            </div>
            <br />
            <div class="input-group">
                <span class="input-group-addon">URL</span>
                <input type="text" class="form-control" name="url" value="'.stripslashes( $infos['url'] ).'" />
            </div>
            <br />
            <div class="input-group">
                <span class="input-group-addon">AWR File Name</span>
                <input type="text" class="form-control" name="awr_file_name" value="'.stripslashes( $infos['awr_file_name'] ).'" />
            </div>
            <br />
            <div class="input-group">
                <span class="input-group-addon">Code</span>
                <input type="text" readonly="readonly" class="form-control" name="sitemap" value="'.$infos['code'].'" />
            </div><br />';
                $emails = explode( ',', $infos['emails'] );
                foreach( $emails as $e ){
                    echo ' <div class="input-group">
                            <span class="input-group-addon">Marketing Box Email</span>
                            <input type="text" class="form-control" name="email[]" value="'.$e.'" />
                            <span class="input-group-addon deleteemail btn-danger">-</span>
                        </div><!-- //#input-group --><br />';
                }
                echo '
                <div style="clear: both;"></div>
                </div><!-- //#profile -->';
            } else{
                ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group new-template-name">
                            <span class="input-group-addon">Template Name</span>
                            <input type="text" class="form-control" name="template_name" value="<?php echo(isset($_POST['name']) ? substr( $_POST['name'], 0, -4 ) : ''); ?>">
                        </div>
                    </div>
                </div>
            <?php
            }
        ?>
        <?php echo $textarea; ?>
        <input style="text-align:center;margin:0 auto;display:block;" type="submit" id="save_button" class="btn btn-default" value="Save"/>
    </form>
    <script type="text/javascript">
        refreshTiny();
        $('.box_logo img').hover(function () {
            $(this).parent().append('<span class="del_img">REMOVE</span>');
        });
        $('.box_logo').mouseleave(function () {
            $(this).find('span').remove();
        });
        $('.box_logo').click(function () {
            var keepLogo = $(this).closest('#profile').find('.keep_logo').val(0);
            console.log(keepLogo);
            $(this).parent().append('Name is used, upload a logo instead <input type="file" name="logo" />');
            $(this).remove();
        });
        $('.toolbar').append('<span class="right"><a class="pluspage">[+] Page</a><span class="separator"></span><a onclick="document.getElementById(\'form_tpl\').submit();">Save</a></span>');
    </script>
</div>