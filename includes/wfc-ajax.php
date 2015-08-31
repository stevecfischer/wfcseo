<?php
    /*
    * All the ajax actions are here
    *
    */
    include_once __DIR__.'/../load.php';
    if( !$authHelper->isAuthorized() ){
        exit('<script type="text/javascript">window.location.href = "'.$authUrl.'";</script>');
    }

    if( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) ){
        $_POST = json_decode( file_get_contents( 'php://input' ), true );
    }

    define( 'TABLE_ID', $_POST['postdata']['propertyID'] );
    if( isset($_POST['action']) ){
        $action = 'ajax_'.preg_replace( '#[^a-zA-Z0-9\\-]#i', '', $_POST['action'] );
    }

    if( function_exists( $action ) ){
        call_user_func( $action );
    } else{
        exit("No Functions Exist");
    }

    function ajax_googlemetrics(){
        $dates = get_date_headings();
        $obj   = array();
        foreach( $dates as $date ):
            $obj[] = sessions_month( $date[1], $date[0], TABLE_ID );
        endforeach;

        echo(json_encode( $obj ));
        die();
    }

    function ajax_manualmetrics(){
        //        $obj = array(
        //            array(
        //                "label"       => "General Performance",
        //                'subsections' => array(
        //                    array(
        //                        'label'   => 'Unique Visits',
        //                        'metrics' => array(5, 5)
        //                    ),
        //                    array(
        //                        'label'   => 'Bounce Rate',
        //                        'metrics' => array(5, 5)
        //                    )
        //                ),
        //            )
        //        );

        $dates = get_date_headings();

        $allgoalsforyear = array();
        foreach( $dates as $date ):
            $allgoalsm         = allgoal_completions_month( $date[1], $date[0] );
            $allgoalsforyear[] = $allgoalsm;
        endforeach;

        echo(json_encode( $allgoalsforyear ));
        die();
    }

    function get_man_data( $metric, $year, $month ){
        $manual_data_file = PROP_DIR.DS.intval( $_POST['postdata']['propertyID'] ).DS.$year.DS.$month.DS.'data.json';
        if( file_exists( $manual_data_file ) ){
            $y = unserialize( file_get_contents( $manual_data_file ) );
            if( $y[$metric] && !empty($y[$metric]) ){
                return $y[$metric];
            }
        }
    }



    function get_date_headings(){
        $date_cols = array();
        for( $i = 0; $i <= 2; $i++ ){
            $m           = date( "Y-m", strtotime( "NOW"." -$i months" ) );
            $ym          = explode( "-", $m );
            $date_cols[] = $ym;
        }
        return array_reverse( $date_cols );
    }
