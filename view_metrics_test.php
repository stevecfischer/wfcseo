<?php
    error_reporting( E_ALL );
    ini_set( 'display_errors', 1 );

    $date1       = new DateTime( $_POST['f_year'].'-'.$_POST['f_month'] );
    $date2       = new DateTime( $_POST['t_year'].'-'.$_POST['t_month'] );
    $from_date   = $date1->format( "Y-m" );
    $to_date     = $date2->format( "Y-m" );
    $diff        = $date1->diff( $date2 );
    $time_period = ($diff->format( '%y' ) * 12) + ($diff->format( '%m' ));

    define( 'TABLE_ID', $_POST['code'] );
    define( 'TO_DATE', $to_date );
    define( 'FROM_DATE', $from_date );
    define( 'TIME_PERIOD', $time_period );

    $dataBridge = new wfc_core_class();
    $api        = new wfc_ga_class();

    $dates = get_date_headings();
    function get_date_headings(){
        $date_cols = array();
        for( $i = 0; $i <= TIME_PERIOD; $i++ ){
            $m           = date( "Y-m", strtotime( TO_DATE." -$i months" ) );
            $ym          = explode( "-", $m );
            $date_cols[] = $ym;
        }
        return array_reverse( $date_cols );
    }

    function get_man_data( $metric, $year, $month ){
        $manual_data_file = PROP_DIR.DS.intval( $_POST['code'] ).DS.$year.DS.$month.DS.'data.json';
        if( file_exists( $manual_data_file ) ){
            $y = unserialize( file_get_contents( $manual_data_file ) );
            if( $y[$metric] && !empty($y[$metric]) ){
                return $y[$metric];
            }
        }
        return "0";
    }

    function allGoalsMetric(){
        $dates           = get_date_headings();
        $allgoalsforyear = array();
        foreach( $dates as $date ):
            $allgoalsm         = allgoal_completions_month( $date[1], $date[0] );
            $allgoalsforyear[] = $allgoalsm;
        endforeach;

        return $allgoalsforyear;
    }

    $allgoalsforyear = allGoalsMetric();

    function allPhoneGoalsMetric(){
        $dates           = get_date_headings();
        $allgoalsforyear = array();
        foreach( $dates as $date ):
            $allgoalsm         = all_phone_goal_completions_month( $date[1], $date[0] );
            $allgoalsforyear[] = $allgoalsm;
        endforeach;

        return $allgoalsforyear;
    }

    $allPhonegoalsforyear = allPhoneGoalsMetric();

    function getGoalMetric( $metricLabel ){
        global $allgoalsforyear;
        tableCellWrap( array_column( $allgoalsforyear, $metricLabel ) );
    }

    function getPhoneGoalMetric( $metricLabel ){
        global $allPhonegoalsforyear;
        tableCellWrap( array_column( $allPhonegoalsforyear, $metricLabel ) );
    }

    function tableCellWrap( $array ){
        foreach( $array as $v ):
            echo "<td>".$v."</td>";
        endforeach;
    }

    //////////////////////
    //////////////////////
    //////////////////////

    function ajax_dates(){
        global $dataBridge;
        $date_cols = array();
        for( $i = 0; $i <= TIME_PERIOD; $i++ ){
            $m             = date( "Y-m", strtotime( TO_DATE." -$i months" ) );
            $ym            = explode( "-", $m );
            $date_cols[$i] = array($ym[0], $ym[1]);
        }
        return $dataBridge->prepare_json( $date_cols );
    }

    /////////////////////
    //   SINGLE METRICS
    /////////////////////

    function get_metric( $metric, $from_date, $to_date, $optParams = array() ){
        global $api;
        $r = $api->get_metric_by_custom_date( $metric, $from_date, $to_date, $optParams );
        return $r;
    }

    $metric_handles_array        = array(
        "sessions"                  => array(
            'metric'  => 'sessions',
            'options' => array('dimensions' => "ga:yearMonth")
        ),
        "bounceRate"                => array(
            'metric'  => 'bounceRate',
            'options' => array('dimensions' => "ga:yearMonth")
        ),
        "goalCompleteDirect"        => array(
            'metric'  => 'goalCompletionsAll',
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Direct'
            )
        ),
        "goalCompleteDisplay"       => array(
            'metric'  => 'goalCompletionsAll',
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Display'
            )
        ),
        "goalCompleteOrganic"       => array(
            'metric'  => 'goalCompletionsAll',
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Organic Search'
            )
        ),
        "goalCompleteSEM"           => array(
            'metric'  => 'goalCompletionsAll',
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Paid Search'
            )
        ),
        "goalCompleteReferral"      => array(
            'metric'  => 'goalCompletionsAll',
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Referral'
            )
        ),
        "goalCompleteSocial"        => array(
            'metric'  => 'goalCompletionsAll',
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Social'
            )
        ),
        "goalPhoneCompleteDirect"   => array(
            'metric'  => 'goal6Completions',
            /* @sftodo: future issue. that goal string is specific to ben franklin */
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Direct'
            )
        ),
        "goalPhoneCompleteDisplay"  => array(
            'metric'  => 'goal6Completions',
            /* @sftodo: future issue. that goal string is specific to ben franklin */
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Display'
            )
        ),
        "goalPhoneCompleteOrganic"  => array(
            'metric'  => 'goal6Completions',
            /* @sftodo: future issue. that goal string is specific to ben franklin */
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Organic Search'
            )
        ),
        "goalPhoneCompleteSEM"      => array(
            'metric'  => 'goal6Completions',
            /* @sftodo: future issue. that goal string is specific to ben franklin */
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Paid Search'
            )
        ),
        "goalPhoneCompleteReferral" => array(
            'metric'  => 'goal6Completions',
            /* @sftodo: future issue. that goal string is specific to ben franklin */
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Referral'
            )
        ),
        "goalPhoneCompleteSocial"   => array(
            'metric'  => 'goal6Completions',
            /* @sftodo: future issue. that goal string is specific to ben franklin */
            'options' => array(
                'dimensions' => "ga:yearMonth",
                'filters'    => 'ga:channelGrouping==Social'
            )
        ),
        "impressions"               => array(
            'metric'  => 'impressions',
            'options' => array('dimensions' => "ga:yearMonth")
        ),
        "adClicks"                  => array(
            'metric'  => 'adClicks',
            'options' => array('dimensions' => "ga:yearMonth")
        ),
        "adCost"                    => array(
            'metric'  => 'adCost',
            'options' => array('dimensions' => "ga:yearMonth")
        ),
        "adCTR"                     => array(
            'metric'  => 'CTR',
            'options' => array('dimensions' => "ga:yearMonth")
        ),
    );
    $manual_metric_handles_array = array(
        't_month_conversions',
        't_month_budget',
        'cost_per_conversion',
        't_inbound_calls',
        'replacement_appts',
        'repair_appts',
        'replacement_opps',
        'replacement_quotes',
        'thumbtack_leads',
        'craigslist_leads',
    );

    //////
    //////
    //  @sftodo: working on goalCompletionsAll. returns array(6, (Other), 23), array(6, Direct, 12)
    //  @sftodo: how to group each metric into its own: array(Direct => array(23,12);
    //////
    //////

    foreach( $metric_handles_array as $metric_handle => $query_params ){
        $allMetricData[$metric_handle] =
            get_metric( "ga:".$query_params['metric'], $from_date, $to_date, $query_params['options'] );
    }

    foreach( $manual_metric_handles_array as $metric_handle ){
        $rows = array();
        foreach( $dates as $date ):
            $allMetricData[$metric_handle]['rows'][] =
                array($date[1], get_man_data( $metric_handle, $date[0], $date[1] ));
        endforeach;
    }

    /////////////////////
    //   ALL METRICS
    /////////////////////

    $allMetricData = $dataBridge->prepare_json( $allMetricData );

    //////////////////////
    //////////////////////
    //////////////////////

    $obj = array(
        array(
            "label"       => "General Performance",
            'subsections' => array(
                array(
                    'label'   => 'Unique Visits',
                    'metrics' => array(5, 5)
                ),
                array(
                    'label'   => 'Bounce Rate',
                    'metrics' => array(5, 5)
                )
            ),
        )
    );

    $cleandedDates = ajax_dates();

    $localizedData = 'var localizedData = {"dates":"'.$cleandedDates.'","data":"'.$allMetricData.'","test":"'.
        $dataBridge->prepare_json( $obj ).'"};';
    $dataBridge->print_extra_scripts( $localizedData );
?>
<div class="col-md-4">
    <div class="row">
        <div class="col-md-12" id="line-chart">
            <div class="panel panel-default">
                <div class="panel-heading">Line Chart</div>
                <div class="panel-body">
                    <canvas id="line" class="chart chart-line" data="data" labels="labels" legend="true"
                            click="onClick" hover="onHover" series="series"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Report</strong></h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="wfc-metric-table table table-condensed table-bordered">
                    <thead>
                    <tr>
                        <th class="first-col"></th>
                        <?php foreach( $dates as $date ): ?>
                            <th><?php echo $date[1].'-'.$date[0] ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ">General Performance:</td>
                        <td colspan="<?php echo (int)TIME_PERIOD + 1; ?>"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('sessions')">Chart</a>
                            Unique Visits
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo sessions_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class=" last-subsection-row">
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('bounceRate')">Chart</a>
                            Bounce Rate
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo bouncerate_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ">Form Conversions:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalCompleteDirect')">Chart</a>
                            Direct
                        </td>
                        <?php getGoalMetric( "Direct" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalCompleteDisplay')">Chart</a>
                            Display
                        </td>
                        <?php getGoalMetric( "Display" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalCompleteOrganic')">Chart</a>
                            Organic
                        </td>
                        <?php getGoalMetric( "Organic Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalCompleteSEM')">Chart</a>
                            SEM
                        </td>
                        <?php getGoalMetric( "Paid Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalCompleteReferral')">Chart</a>
                            Referral
                        </td>
                        <?php getGoalMetric( "Referral" ) ?>
                    </tr>
                    <tr class=" last-subsection-row">
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalCompleteSocial')">Chart</a>
                            Social
                        </td>
                        <?php getGoalMetric( "Social" ) ?>
                    </tr>
                    <tr class="success " ng-repeat="total in section.totals">
                        <td class="total-heading first-col ">Total Form Conversions</td>
                        <?php foreach( $allgoalsforyear as $monthgoals ): ?>
                            <td><?php echo array_sum( $monthgoals ); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ">Phone Conversions:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalPhoneCompleteDirect')">Chart</a>
                            Direct
                        </td>
                        <?php getPhoneGoalMetric( "Direct" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalPhoneCompleteDisplay')">Chart</a>
                            Display
                        </td>
                        <?php getPhoneGoalMetric( "Display" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalPhoneCompleteOrganic')">Chart</a>
                            Organic
                        </td>
                        <?php getPhoneGoalMetric( "Organic Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalPhoneCompleteSEM')">Chart</a>
                            SEM
                        </td>
                        <?php getPhoneGoalMetric( "Paid Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalPhoneCompleteReferral')">Chart</a>
                            Referral
                        </td>
                        <?php getPhoneGoalMetric( "Referral" ) ?>
                    </tr>
                    <tr
                        class=" last-subsection-row">
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('goalPhoneCompleteSocial')">Chart</a>
                            Social
                        </td>
                        <?php getPhoneGoalMetric( "Social" ) ?>
                    </tr>
                    <tr class="success " ng-repeat="total in section.totals">
                        <td class="total-heading first-col ">Total Phone Conversions</td>
                        <?php foreach( $allPhonegoalsforyear as $monthgoals ): ?>
                            <td><?php echo array_sum( $monthgoals ); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ">SEM Metrics:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('impressions')">Chart</a>
                            Impressions
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo adwords_impressions_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('adClicks')">Chart</a>
                            Clicks
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo adwords_clicks_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('adCTR')">Chart</a>
                            CTR
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo scf_number_format( total_ctr_month( $date[1], $date[0] ), 2 ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr
                        class=" last-subsection-row">
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('adCost')">Chart</a>
                            SEM Spend
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo scf_curreny_format( adwords_ppc_cost_month( $date[1], $date[0] ), 2 ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ">ROI Summary:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('t_month_conversions')">Chart</a>
                            Total Monthly Conversions
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo get_man_data( "t_month_conversions", $date[0], $date[1] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('t_month_budget')">Chart</a>
                            Total Monthly Budget
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo get_man_data( "t_month_budget", $date[0], $date[1] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr
                        class=" last-subsection-row">
                        <td class="no-line first-col ">
                            <a ng-click="chartMe('cost_per_conversion')">Chart</a>
                            Cost Per Conversion
                        </td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo get_man_data( "cost_per_conversion", $date[0], $date[1] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <?php if( $_POST['code'] == "30359942" ): ?>
                        <tbody>
                        <tr class="section-heading warning">
                            <td class="first-col ">Custom Client Metrics:</td>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('t_inbound_calls')">Chart</a>
                                Total Inbound Phone Calls
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "t_inbound_calls", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('replacement_appts')">Chart</a>
                                Replacement Appointments
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "replacement_appts", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('repair_appts')">Chart</a>
                                Repair &amp; Tune-up Appointments
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "repair_appts", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('replacement_opps')">Chart</a>
                                Replacement Opportunities
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "replacement_opps", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('replacement_quotes')">Chart</a>
                                Replacement Quotes
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "replacement_quotes", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('thumbtack_leads')">Chart</a>
                                Thumbtack Lead Source
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "thumbtack_leads", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr
                            class=" last-subsection-row">
                            <td class="no-line first-col ">
                                <a ng-click="chartMe('craigslist_leads')">Chart</a>
                                Craigslist Lead Source
                            </td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "craigslist_leads", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="success " ng-repeat="total in section.totals">
                            <td class="total-heading first-col ">MTD Acutal Sales</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "mtd_sales", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="success " ng-repeat="total in section.totals">
                            <td class="total-heading first-col ">MTD Sales Trending</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "mtd_sales_trend", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="success " ng-repeat="total in section.totals">
                            <td class="total-heading first-col ">Total Monthly Sales Goal</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "t_mtd_sales_goal", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="empty-row"></tr>
                        </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

