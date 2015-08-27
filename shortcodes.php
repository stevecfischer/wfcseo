<?php
    error_reporting( E_ERROR );
    $shortcode_tags = array();
    //https://developers.google.com/analytics/devguides/reporting/core/dimsmets
    /*
     * I went a different route.  this looped the shortcodes whether they existed or not... inefficient
    $list_shortcodes = array(
        'unique_visitors',
        'visitor',
        'visits',
        'from_google',
        'new_vs_returning_pie',
        'top_pages_table',
        'month',
        'year'
    );

    function parse_content( $content ){
        global $list_shortcodes;
        foreach( $list_shortcodes as $value ){
            $content = preg_replace_callback( "#\[month\]#", $value, $content );
        }
        return $content;
    }
    */
    $wfcga = new wfc_ga_class();
    function do_shortcode( $content ){
        global $shortcode_tags;
        if( empty($shortcode_tags) || !is_array( $shortcode_tags ) ){
            return $content;
        }
        $pattern = get_shortcode_regex();
        return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
    }

    function do_shortcode_tag( $m ){
        global $shortcode_tags;
        // allow [[foo]] syntax for escaping a tag
        if( $m[1] == '[' && $m[6] == ']' ){
            return substr( $m[0], 1, -1 );
        }
        $tag = $m[2];
        if( isset($m[5]) ){
            // enclosing tag - extra parameter
            return $m[1].call_user_func( $shortcode_tags[$tag], $m[5], $tag ).$m[6];
        } else{
            // self-closing tag
            return $m[1].call_user_func( $shortcode_tags[$tag], NULL, $tag ).$m[6];
        }
    }

    function get_shortcode_regex(){
        global $shortcode_tags;
        $tagnames  = array_keys( $shortcode_tags );
        $tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        return
            '\\[' // Opening bracket
            .'(\\[?)' // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            ."($tagregexp)" // 2: Shortcode name
            .'(?![\\w-])' // Not followed by word character or hyphen
            .'(' // 3: Unroll the loop: Inside the opening shortcode tag
            .'[^\\]\\/]*' // Not a closing bracket or forward slash
            .'(?:'
            .'\\/(?!\\])' // A forward slash not followed by a closing bracket
            .'[^\\]\\/]*' // Not a closing bracket or forward slash
            .')*?'
            .')'
            .'(?:'
            .'(\\/)' // 4: Self closing tag ...
            .'\\]' // ... and closing bracket
            .'|'
            .'\\]' // Closing bracket
            .'(?:'
            .'(' // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            .'[^\\[]*+' // Not an opening bracket
            .'(?:'
            .'\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            .'[^\\[]*+' // Not an opening bracket
            .')*+'
            .')'
            .'\\[\\/\\2\\]' // Closing shortcode tag
            .')?'
            .')'
            .'(\\]?)'; // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }

    function cache_data( $shortcode, $m, $y ){
        if( PROPERTY_CACHE === false ){
            return true;
        }
        if( file_exists(
            PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'cache'.DS.$shortcode.'-'.$m.'-'.$y.'.ini' ) ){
            return unserialize(
                file_get_contents(
                    PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'cache'.DS.$shortcode.'-'.$m.'-'.$y.
                    '.ini' ) );
        } else{
            return false;
        }
    }

    function add_cache( $data, $shortcode, $m, $y ){
        if( PROPERTY_CACHE === false ){
            return true;
        }
        if( !file_exists( PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID ) ){
            mkdir( PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID );
        }
        if( !file_exists( PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'cache' ) ){
            mkdir( PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'cache' );
        }
        $f = fopen(
            PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'cache'.DS.$shortcode.'-'.$m.'-'.$y.
            '.ini', 'w+' );
        fwrite( $f, serialize( $data ) );
        fclose( $f );
    }

    function add_shortcode( $tag, $func ){
        global $shortcode_tags;
        if( is_callable( $func ) ){
            $shortcode_tags[$tag] = $func;
        }
    }

    function scf_number_format( $n, $d = 2 ){
        if( $n && !empty($n) ){
            return number_format( $n, $d );
        }
    }

    function scf_curreny_format( $n, $d = 2 ){
        if( $n && !empty($n) ){
            return "$ ".number_format( $n, $d );
        }
    }

    function scf_time_format( $n ){
        return gmdate( "H:i:s", $n );
    }

    function scf_word_wrap( $s ){
        $s = wordwrap( $s, 30, PHP_EOL, true );
        return $s;
    }

    ///////////////
    // USER SHORTCODES //
    ////////////////
    add_shortcode( 'month', 'month' );
    add_shortcode( 'year', 'year' );
    add_shortcode( 'users', 'users' );
    add_shortcode( 'new_users', 'new_users' );
    add_shortcode( 'sessions', 'sessions' );
    add_shortcode( 'bouncerate', 'bouncerate' );
    add_shortcode( 'bounces', 'bounces' );
    add_shortcode( 'avg_session_duration', 'avg_session_duration' );
    add_shortcode( 'percent_new_sessions', 'percent_new_sessions' );
    add_shortcode( 'new_vs_returning_pie', 'new_vs_returning_pie' );
    add_shortcode( 'referral_traffic', 'referral_traffic' );
    add_shortcode( 'mobile_traffic', 'mobile_traffic' );
    add_shortcode( 'geo_summary', 'geo_summary' );
    add_shortcode( 'geo_city_summary', 'geo_city_summary' );
    add_shortcode( 'visitor_overview', 'visitor_overview' );
    add_shortcode( 'traffic_new_vs_returning_pie', 'traffic_new_vs_returning_pie' );
    add_shortcode( 'top_pages', 'top_pages' );
    add_shortcode( 'exit_pages', 'exit_pages' );
    add_shortcode( 'site_speed', 'site_speed' );
    add_shortcode( 'acquisition_overview', 'acquisition_overview' );
    add_shortcode( 'search_engine_traffic', 'search_engine_traffic' );
    add_shortcode( 'new_vs_returning_table', 'new_vs_returning_table' );
    add_shortcode( 'allgoal_completions', 'allgoal_completions' );
    add_shortcode( 'adwords_clicks', 'adwords_clicks' );
    add_shortcode( 'adwords_impressions', 'adwords_impressions' );
    function month(){
        $months = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );
        return $months[MONTH];
    }

    function year(){
        return YEAR;
    }

    function users(){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric( 'ga:users' ), 0 );
    }

    function new_users(){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric( 'ga:newUsers' ), 0 );
    }

    function sessions(){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric( 'ga:sessions' ), 0 );
    }

    function bouncerate(){
        global $wfcga;
        return $wfcga->get_metric( 'ga:bounceRate' );
    }

    function bounces(){
        global $wfcga;
        return $wfcga->get_metric( 'ga:bounces' );
    }

    function avg_session_duration(){
        global $wfcga;
        return $wfcga->get_metric( 'ga:avgSessionDuration' );
    }

    function percent_new_sessions(){
        global $wfcga;
        return $wfcga->get_metric( 'ga:percentNewSessions' );
    }

    function new_vs_returning_pie(){
        global $wfcga;
        $a = $wfcga->get_metric( 'ga:percentNewSessions' );
        $b = 100 - $a;
        return draw_pie(
            array($a, $b), array(
            'New - %.1f%%',
            'Returning - %.1f%%'
        ), 'New vs. Returning', 'new_vs_returning_pie' );
    }

    ///////////////////////////////////////
    ///////////////////////////////////////
    ///////////////////////////////////////
    ///////////////////////////////////////
    ///////////////////////////////////////
    function allgoal_completions(){
        global $wfcga;
        $metrics = $wfcga->get_metric(
            'ga:goalCompletionsAll',
            array('dimensions' => "ga:channelGrouping"),
            'all'
        );
        $r       = array();
        foreach( $metrics->rows as $referrer ){
            $r[$referrer[0]] = $referrer[1];
        }
        return $r;
    }

    function sessions_month( $month, $year ){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric_by_month( 'ga:sessions', '', '', $month, $year ), 0 );
    }

    function bouncerate_month( $month, $year ){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric_by_month( 'ga:bounceRate', '', '', $month, $year ), 0 );
    }

    function total_ctr_month( $month, $year ){
        global $wfcga;
        return $wfcga->get_metric_by_month( 'ga:CTR', '', '', $month, $year );
    }

    function allgoal_completions_month( $month, $year ){
        //metric = ga:goalCompletionsAll
        //dimesion = ga:medium
        //direct = "none" dumbasss
        global $wfcga;
        $metrics = $wfcga->get_metric_by_month(
            'ga:goalCompletionsAll',
            array('dimensions' => "ga:channelGrouping"),
            'all',
            $month,
            $year
        );
        $r       = array();
        foreach( $metrics->rows as $referrer ){
            $r[$referrer[0]] = $referrer[1];
        }
        return $r;
    }

    function all_phone_goal_completions_month( $month, $year ){
        global $wfcga;
        $metrics = $wfcga->get_metric_by_month(
            'ga:goal6Completions',
            array('dimensions' => "ga:channelGrouping"),
            'all',
            $month,
            $year
        );
        $r       = array();
        foreach( $metrics->rows as $referrer ){
            $r[$referrer[0]] = $referrer[1];
        }
        return $r;
    }

    function adwords_clicks_month( $month, $year ){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric_by_month( 'ga:adClicks', '', '', $month, $year ), 0 );
    }

    function adwords_impressions_month( $month, $year ){
        global $wfcga;
        return scf_number_format( $wfcga->get_metric_by_month( 'ga:impressions', '', '', $month, $year ), 0 );
    }

    function adwords_ppc_cost_month( $month, $year ){
        global $wfcga;
        return $wfcga->get_metric_by_month( 'ga:adCost', '', '', $month, $year );
    }

    function goalcompletions_total_month( $month, $year ){
        global $wfcga;
        return $wfcga->get_metric_by_month( 'ga:goalCompletionsAll', '', '', $month, $year );
    }

    ///////////////////////////////////////
    ///////////////////////////////////////
    ///////////////////////////////////////
    ///////////////////////////////////////
    ///////////////////////////////////////
    function referral_traffic(){
        global $wfcga;
        $metrics = $wfcga->get_metric(
            'ga:sessions,ga:percentNewSessions,ga:newUsers',
            array('dimensions' => "ga:source", "sort" => "-ga:sessions", "max-results" => 10),
            'all'
        );
        $r       =
            '<table align="center"  class="tg"><tr><th class="tg-s27x">Source</th><th class="tg-s27x">Visits</th></tr>';
        foreach( $metrics->rows as $referrer ){
            $r .= '<tr>';
            $r .= '<td class="tg-031e">'.$referrer[0].'</td>
                <td>'.$referrer[1].'</td>';
            $r .= '</tr>';
        }
        $r .= '</table>';
        return $r;
    }

    function mobile_traffic(){
        global $wfcga;
        $r = '<table align="center"  class="tg">
          <tr>
            <td class="tg-s27x">Device Category</td>
            <td class="tg-s27x">Sessions</td>
            <td class="tg-s27x">% New Sessions</td>
            <td class="tg-s27x">New Users</td>
            <td class="tg-s27x">Bounce Rate</td>
            <td class="tg-s27x">Pages / Session</td>
            <td class="tg-s27x">Avg. Session Duration</td>
          </tr>
          <tr>
            <td class="tg-031e"></td>
<td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:sessions' ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:percentNewSessions' ) ).'%</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:newUsers' ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:bounceRate' ) ).'%</td>
            <td class="tg-031e">'.scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession' ) ).'</td>
            <td class="tg-031e">'.scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration' ) ).'</td>
          </tr>
          <tr>
            <td class="tg-031e">desktop</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:sessions', array('segment' => "gaid::YVp8iezNSm-k9MTSqGTFBQ") ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::YVp8iezNSm-k9MTSqGTFBQ") ) ).'%</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:newUsers', array('segment' => "gaid::YVp8iezNSm-k9MTSqGTFBQ") ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:bounceRate', array('segment' => "gaid::YVp8iezNSm-k9MTSqGTFBQ") ) ).'%</td>
            <td class="tg-031e">'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession', array('segment' => "gaid::YVp8iezNSm-k9MTSqGTFBQ") ) ).'</td>
            <td class="tg-031e">'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration', array('segment' => "gaid::YVp8iezNSm-k9MTSqGTFBQ") ) ).'</td>
          </tr>
          <tr>
            <td class="tg-031e">tablet</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:sessions', array('segment' => "gaid::-13") ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::-13") ) ).'%</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:newUsers', array('segment' => "gaid::-13") ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:bounceRate', array('segment' => "gaid::-13") ) ).'%</td>
            <td class="tg-031e">'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession', array('segment' => "gaid::-13") ) ).'</td>
            <td class="tg-031e">'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration', array('segment' => "gaid::-13") ) ).'</td>
          </tr>
          <tr>
            <td class="tg-031e">mobile</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:sessions', array('segment' => "gaid::-14") ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::-14") ) ).'%</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:newUsers', array('segment' => "gaid::-14") ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format(
                $wfcga->get_metric( 'ga:bounceRate', array('segment' => "gaid::-14") ) ).'%</td>
            <td class="tg-031e">'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession', array('segment' => "gaid::-14") ) ).'</td>
            <td class="tg-031e">'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration', array('segment' => "gaid::-14") ) ).'</td>
          </tr>
        </table>';
        return $r;
    }

    function geo_summary(){
        global $wfcga;
        $metrics = $wfcga->get_metric(
            'ga:sessions,ga:percentNewSessions,ga:newUsers', array(
            'dimensions'  => "ga:country",
            "sort"        => "-ga:sessions",
            "max-results" => 10
        ), 'all' );
        $r       = '<table align="center"  class="tg">
          <tr>
            <th class="tg-031e">Country / Territory</th>
            <th class="tg-031e">Visits</th>
            <th class="tg-031e">% New Visits</th>
            <th class="tg-031e">New Visits</th>
          </tr>';
        $r .= '<tr>
            <td class="tg-031e"></td>
            <td class="tg-031e">'.$wfcga->get_metric( 'ga:sessions' ).'</td>
            <td class="tg-031e">'.scf_number_format( $wfcga->get_metric( 'ga:percentNewSessions' ) ).'%</td>
            <td class="tg-031e">'.$wfcga->get_metric( 'ga:newUsers' ).'</td>
          </tr>';
        foreach( $metrics->rows as $rr ):
            $country = array_shift( $rr );
            $row     = array_map( 'scf_number_format', $rr );
            $r .= '<tr>
                <td class="tg-031e">'.$country.'</td>
                <td class="tg-031e">'.$row[0].'</td>
                <td class="tg-031e">'.$row[1].'%</td>
                <td class="tg-031e">'.$row[2].'</td>
              </tr>';
        endforeach;
        $r .= '</table>';
        return $r;
    }

    function geo_city_summary(){
        global $wfcga;
        $metrics = $wfcga->get_metric(
            'ga:sessions,ga:percentNewSessions,ga:newUsers',
            array('segment' => 'gaid::-6', 'dimensions' => "ga:city", "sort" => "-ga:sessions", "max-results" => 10),
            'all'
        );
        $r       = '<table align="center"  class="tg">
          <tr>
            <th class="tg-031e">Search Traffic</th>
            <th class="tg-031e">Sessions</th>
            <th class="tg-031e">% New Sessions</th>
            <th class="tg-031e">New Users</th>
          </tr>';
        $r .= '<tr>
            <td class="tg-031e"></td>
            <td class="tg-031e">'.scf_number_format( $wfcga->get_metric( 'ga:sessions' ), 0 ).'</td>
            <td class="tg-031e">'.scf_number_format( $wfcga->get_metric( 'ga:percentNewSessions' ) ).'%</td>
            <td class="tg-031e">'.scf_number_format( $wfcga->get_metric( 'ga:newUsers' ), 0 ).'</td>
          </tr>';
        foreach( $metrics->rows as $rr ):
            $c   = array_shift( $rr );
            $row = $rr;
            $r .= '<tr>
                <td class="tg-031e">'.$c.'</td>
                <td class="tg-031e">'.scf_number_format( $row[0], 0 ).'</td>
                <td class="tg-031e">'.scf_number_format( $row[1] ).'%</td>
                <td class="tg-031e">'.scf_number_format( $row[2], 0 ).'</td>
              </tr>';
        endforeach;
        $r .= '</table>';
        return $r;
    }

    function visitor_overview(){
        global $wfcga;
        $r = '<table align="center"  class="tg">
          <tr>
            <td class="tg-031e">Sessions<br />'.scf_number_format( $wfcga->get_metric( 'ga:sessions' ), 0 ).'</td>
            <td class="tg-031e">Users<br />'.scf_number_format( $wfcga->get_metric( 'ga:users' ), 0 ).'</td>
            <td class="tg-031e">Pageviews<br />'.scf_number_format( $wfcga->get_metric( 'ga:pageviews' ), 0 ).'</td>
            <td class="tg-031e" rowspan="3">'.do_shortcode( '[new_vs_returning_pie]' ).'</td>
          </tr>
          <tr>
            <td class="tg-031e">Pages / Session<br />'.scf_number_format(
                $wfcga->get_metric( 'ga:pageviewsPerSession' ) ).'</td>
            <td class="tg-031e">Avg. Session Duration<br />'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration' ) ).'</td>
            <td class="tg-031e">Bounce Rate<br />'.scf_number_format( $wfcga->get_metric( 'ga:bounceRate' ) ).'%</td>
          </tr>
          <tr>
            <td class="tg-031e">% New Sessions<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:percentNewSessions' ) ).'%</td>
            <td class="tg-031e"></td>
            <td class="tg-031e"></td>
          </tr>
        </table>';
        return $r;
    }

    function traffic_new_vs_returning_pie(){
        global $wfcga;
        $a = $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::-6") );
        $b = 100 - $a;
        return draw_pie(
            array($a, $b), array(
            'New - %.1f%%',
            'Returning - %.1f%%'
        ), 'New vs. Returning', 'traffic_new_vs_returning_pie' );
    }

    function top_pages(){
        global $wfcga;
        $metrics_head = $wfcga->get_metric(
            'ga:pageviews,ga:uniquePageviews,ga:avgTimeOnPage,ga:entrances,ga:bounceRate,ga:exitRate', array(), 'all' );
        $metrics_rows = $wfcga->get_metric(
            'ga:pageviews,ga:uniquePageviews,ga:avgTimeOnPage,ga:entrances,ga:bounceRate,ga:exitRate', array(
            'dimensions'  => "ga:pagepath",
            "sort"        => "-ga:pageviews",
            "max-results" => 10
        ), 'all' );
        $r            = '<table align="center" class="tg top_pages">';
        $r .= '<tr>
            <td class="tg-s27x">Page</td>
            <td class="tg-s27x">Pageviews</td>
            <td class="tg-s27x">Unique Pageviews</td>
            <td class="tg-s27x">Avg. Time on Page</td>
            <td class="tg-s27x">Entrances</td>
            <td class="tg-s27x">Bounce Rate</td>
            <td class="tg-s27x">% Exit</td>
          </tr>';
        foreach( $metrics_head->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e"></td>
                <td class="tg-031e" >'.scf_number_format( $row[0], 0 ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[1], 0 ).'</td>
                <td class="tg-031e" >'.scf_time_format( $row[2] ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[3], 0 ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[4] ).'%</td>
                <td class="tg-031e" >'.scf_number_format( $row[5] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        foreach( $metrics_rows->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e" > '.$row[0].'</td>
                <td class="tg-031e" > '.scf_number_format( $row[1], 0 ).'</td>
                <td class="tg-031e" > '.scf_number_format( $row[2], 0 ).'</td>
                <td class="tg-031e" > '.scf_time_format( $row[3] ).'</td>
                <td class="tg-031e" > '.$row[4].'</td>
                <td class="tg-031e" > '.scf_number_format( $row[5] ).'%</td>
                <td class="tg-031e" > '.scf_number_format( $row[6] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        $r .= '</table>';
        return $r;
    }

    function exit_pages(){
        global $wfcga;
        $metrics_head = $wfcga->get_metric(
            'ga:exits,ga:pageviews,ga:exitRate', array(), 'all' );
        $metrics_rows = $wfcga->get_metric(
            'ga:exits,ga:pageviews,ga:exitRate', array(
            'dimensions'  => "ga:exitpagepath",
            "sort"        => "-ga:exits",
            "max-results" => 10
        ), 'all' );
        $r            = '<table align="center"  class="tg exit_pages">';
        $r .= '<tr>
            <td class="tg-s27x">Page</td>
            <td class="tg-s27x">Exits</td>
            <td class="tg-s27x">Pageviews</td>
            <td class="tg-s27x">% Exit</td>
          </tr>';
        foreach( $metrics_head->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e"></td>
                <td class="tg-031e" >'.$row[0].'</td>
                <td class="tg-031e" >'.$row[1].'</td>
                <td class="tg-031e" >'.scf_number_format( $row[2] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        foreach( $metrics_rows->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e" > '.$row[0].'</td>
                <td class="tg-031e" > '.$row[1].'</td>
                <td class="tg-031e" > '.$row[2].'</td>
                <td class="tg-031e" > '.scf_number_format( $row[3] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        $r .= '</table>';
        return $r;
    }

    function site_speed(){
        global $wfcga;
        $metrics_head = $wfcga->get_metric(
            'ga:avgPageLoadTime,ga:bounceRate', array(), 'all' );
        $metrics_rows = $wfcga->get_metric(
            'ga:avgPageLoadTime,ga:bounceRate', array(
            'dimensions'  => "ga:pagepath",
            "sort"        => "-ga:avgPageLoadTime",
            "max-results" => 10
        ), 'all' );
        $r            = '<table align="center" style="width: 100%;" class="tg site_speed">';
        $r .= '<tr>
            <td class="tg-s27x" style="width: 30%;">Page</td>
            <td class="tg-s27x" style="width: 30%;">Avg Page Load Time</td>
            <td class="tg-s27x" style="width: 30%;">Bounce Rate compared to site average</td>
          </tr>';
        foreach( $metrics_head->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e" style="width: 30%;"></td>
                <td class="tg-031e" style="width: 30%;">'.scf_time_format( $row[0] ).'</td>
                <td class="tg-031e" style="width: 30%;">'.scf_number_format( $row[1] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        foreach( $metrics_rows->rows as $rr ):
            $row = $rr;
            /*
             * @todo: need function for bar graph last column
             */
            $cell = '<td class="tg-031e" style="width:30%;">'.scf_word_wrap( $row[0] ).'</td>
                <td class="tg-031e">'.scf_time_format( $row[1] ).'</td>
                <td class="tg-031e">'.scf_number_format( $row[2] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        $r .= '</table>';
        return $r;
    }

    function acquisition_overview(){
        global $wfcga;
        $metrics_head = $wfcga->get_metric(
            'ga:sessions,ga:percentNewSessions,ga:newUsers,ga:bounceRate,ga:pageviewsPerSession,ga:avgSessionDuration', array(), 'all' );
        $metrics_rows = $wfcga->get_metric(
            'ga:sessions,ga:percentNewSessions,ga:newUsers,ga:bounceRate,ga:pageviewsPerSession,ga:avgSessionDuration', array(
            'dimensions'  => "ga:channelGrouping",
            "sort"        => "-ga:sessions",
            "max-results" => 10
        ), 'all' );
        $r            = '<table align="center"  class="tg">';
        $r .= '<tr>
            <td class="tg-s27x">Default Channel Grouping</td>
            <td class="tg-s27x">Sessions</td>
            <td class="tg-s27x">% New Sessions</td>
            <td class="tg-s27x">New Users</td>
            <td class="tg-s27x">Bounce Rate</td>
            <td class="tg-s27x">Pages / Session</td>
            <td class="tg-s27x">Avg. Session Duration</td>
          </tr>';
        foreach( $metrics_head->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e"></td>
                <td class="tg-031e" >'.scf_number_format( $row[0], 0 ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[1] ).'%</td>
                <td class="tg-031e" >'.scf_number_format( $row[2], 0 ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[3] ).'%</td>
                <td class="tg-031e" >'.scf_number_format( $row[4] ).'</td>
                <td class="tg-031e" >'.scf_time_format( $row[5] ).'</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        foreach( $metrics_rows->rows as $rr ):
            $row  = $rr;
            $cell = '<td class="tg-031e" > '.$row[0].'</td>
                <td class="tg-031e" > '.scf_number_format( $row[1], 0 ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[2] ).'%</td>
                <td class="tg-031e" > '.scf_number_format( $row[3], 0 ).'</td>
                <td class="tg-031e" >'.scf_number_format( $row[4] ).'%</td>
                <td class="tg-031e" >'.scf_number_format( $row[5] ).'</td>
                <td class="tg-031e" > '.scf_time_format( $row[6] ).'%</td>';
            $r .= "<tr>$cell</tr>";
        endforeach;
        $r .= '</table>';
        return $r;
    }

    function search_engine_traffic(){
        global $wfcga;
        $r = '<table align="center"  class="tg">
          <tr>
            <td class="tg-031e">Sessions<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:sessions', array('segment' => "gaid::-6") ), 0 ).'</td>
            <td class="tg-031e">Users<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:users', array('segment' => "gaid::-6") ), 0 ).'</td>
            <td class="tg-031e">Pageviews<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviews', array('segment' => "gaid::-6") ), 0 ).'</td>
            <td class="tg-031e" rowspan="3">'.do_shortcode( '[traffic_new_vs_returning_pie]' ).'</td>
          </tr>
          <tr>
            <td class="tg-031e">Pages / Session<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession', array('segment' => "gaid::-6") ) ).'</td>
            <td class="tg-031e">Avg. Session Duration<br />'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration', array('segment' => "gaid::-6") ) ).'</td>
            <td class="tg-031e">Bounce Rate<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:bounceRate', array('segment' => "gaid::-6") ) ).'%</td>
          </tr>
          <tr>
            <td class="tg-031e">% New Sessions<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::-6") ) ).'%</td>
            <td class="tg-031e"></td>
            <td class="tg-031e"></td>
          </tr>
        </table>';
        return $r;
    }

    function new_vs_returning_table(){
        global $wfcga;
        $metrics = $wfcga->get_metric(
            'ga:sessions,ga:percentNewSessions,ga:newUsers',
            array(
                'segment'     => 'gaid::-1',
                'dimensions'  => "ga:userType",
                "sort"        => "-ga:sessions",
                "max-results" => 10
            ),
            'all'
        );
        print_r( $metrics );
        $r = '<table align="center"  class="tg">
          <tr>
            <th class="tg-031e">User Type</th>
            <th class="tg-031e">Sessions</th>
            <th class="tg-031e">% New Sessions</th>
            <th class="tg-031e">New Users</th>
          </tr>';
        $r .= '<table align="center"  class="tg">
          <tr>
            <td></td>
            <td class="tg-031e">'.$wfcga->get_metric( 'ga:sessions', array('segment' => "gaid::-1") ).'</td>
            <td class="tg-031e">'.$wfcga->get_metric( 'ga:users', array('segment' => "gaid::-1") ).'</td>
            <td class="tg-031e">'.$wfcga->get_metric( 'ga:pageviews', array('segment' => "gaid::-1") ).'</td>
          </tr>';
        foreach( $metrics->rows as $rr ):
            $c   = array_shift( $rr );
            $row = array_map( 'scf_number_format', $rr );
            $r .= ' < tr>
                <td class="tg-031e" > '.$c.'</td>
                <td class="tg-031e" > '.$row[0].'</td>
                <td class="tg-031e" > '.$row[1].' %</td>
                <td class="tg-031e" > '.$row[2].'</td>
              </tr > ';
        endforeach;
        $r .= '<tr>
            <td class="tg-031e">1. New Visitors</td>
            <td class="tg-031e">Pages / Session<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession', array('segment' => "gaid::-6") ) ).'</td>
            <td class="tg-031e">Avg. Session Duration<br />'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration', array('segment' => "gaid::-6") ) ).'</td>
            <td class="tg-031e">Bounce Rate<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:bounceRate', array('segment' => "gaid::-6") ) ).'%</td>
          </tr>
          <tr>
            <td class="tg-031e">% New Sessions<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::-6") ) ).'%</td>
            <td class="tg-031e"></td>
            <td class="tg-031e"></td>
          </tr>
          <tr>
            <td class="tg-031e">2. Returning Visitors</td>
            <td class="tg-031e">Pages / Session<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:pageviewsPerSession', array('segment' => "gaid::-6") ) ).'</td>
            <td class="tg-031e">Avg. Session Duration<br />'.
            scf_time_format( $wfcga->get_metric( 'ga:avgSessionDuration', array('segment' => "gaid::-6") ) ).'</td>
            <td class="tg-031e">Bounce Rate<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:bounceRate', array('segment' => "gaid::-6") ) ).'%</td>
          </tr>
          <tr>
            <td class="tg-031e">% New Sessions<br />'.
            scf_number_format( $wfcga->get_metric( 'ga:percentNewSessions', array('segment' => "gaid::-6") ) ).'%</td>
            <td class="tg-031e"></td>
            <td class="tg-031e"></td>
          </tr>
        </table>';
        return $r;
    }