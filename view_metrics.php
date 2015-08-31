<?php
    $date1 = new DateTime( $_POST['f_year'].'-'.$_POST['f_month'] );
    $date2 = new DateTime($_POST['t_year'].'-'.$_POST['t_month'] );
    $to_date = $date2->format("Y-m");
    $diff = $date1->diff( $date2 );
    $time_period = ($diff->format( '%y' ) * 12) + ($diff->format( '%m' )) + 1;


    define( 'TABLE_ID', $_POST['code'] );
    define( 'TO_DATE', $to_date );
    define( 'TIME_PERIOD', $time_period );

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
        return "N/A";
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
        $allgoalsforyear = allGoalsMetric();
        tableCellWrap( array_column( $allgoalsforyear, $metricLabel ) );
    }

    function getPhoneGoalMetric( $metricLabel ){
        $allPhonegoalsforyear = allPhoneGoalsMetric();
        tableCellWrap( array_column( $allPhonegoalsforyear, $metricLabel ) );
    }

    function tableCellWrap( $array ){
        foreach( $array as $v ):
            echo "<td>".$v."</td>";
        endforeach;
    }

?>
<div class="col-md-12 ng-scope">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Report</strong></h3> <a ng-click="toggleDetail">close</a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="wfc-metric-table table table-condensed table-bordered" ng-show="showTable">
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
                        <td class="first-col ng-binding">General Performance:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Unique Visits</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo sessions_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="ng-scope last-subsection-row">
                        <td class="no-line first-col ng-binding">Bounce Rate</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo bouncerate_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ng-binding">Form Conversions:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Direct</td>
                        <?php getGoalMetric( "Direct" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Display</td>
                        <?php getGoalMetric( "Display" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Organic</td>
                        <?php getGoalMetric( "Organic Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">SEM</td>
                        <?php getGoalMetric( "Paid Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Referral</td>
                        <?php getGoalMetric( "Referral" ) ?>
                    </tr>
                    <tr class="ng-scope last-subsection-row">
                        <td class="no-line first-col ng-binding">Social</td>
                        <?php getGoalMetric( "Social" ) ?>
                    </tr>
                    <tr class="success ng-scope" ng-repeat="total in section.totals">
                        <td class="total-heading first-col ng-binding">Total Form Conversions</td>
                        <?php foreach( $allgoalsforyear as $monthgoals ): ?>
                            <td><?php echo array_sum( $monthgoals ); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ng-binding">Phone Conversions:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Direct</td>
                        <?php getPhoneGoalMetric( "Direct" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Display</td>
                        <?php getPhoneGoalMetric( "Display" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Organic</td>
                        <?php getPhoneGoalMetric( "Organic Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">SEM</td>
                        <?php getPhoneGoalMetric( "Paid Search" ) ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Referral</td>
                        <?php getPhoneGoalMetric( "Referral" ) ?>
                    </tr>
                    <tr
                        class="ng-scope last-subsection-row">
                        <td class="no-line first-col ng-binding">Social</td>
                        <?php getPhoneGoalMetric( "Social" ) ?>
                    </tr>
                    <tr class="success ng-scope" ng-repeat="total in section.totals">
                        <td class="total-heading first-col ng-binding">Total Phone Conversions</td>
                        <?php foreach( $allPhonegoalsforyear as $monthgoals ): ?>
                            <td><?php echo array_sum( $monthgoals ); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ng-binding">SEM Metrics:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Impressions</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo adwords_impressions_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Clicks</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo adwords_clicks_month( $date[1], $date[0] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">CTR</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo scf_number_format( total_ctr_month( $date[1], $date[0] ), 2 ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr
                        class="ng-scope last-subsection-row">
                        <td class="no-line first-col ng-binding">SEM Spend</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo scf_curreny_format( adwords_ppc_cost_month( $date[1], $date[0] ), 2 ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <tbody>
                    <tr class="section-heading warning">
                        <td class="first-col ng-binding">ROI Summary:</td>
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Total Monthly Conversions</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo get_man_data( "t_month_conversions", $date[0], $date[1] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td class="no-line first-col ng-binding">Total Monthly Budget</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo get_man_data( "t_month_budget", $date[0], $date[1] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr
                        class="ng-scope last-subsection-row">
                        <td class="no-line first-col ng-binding">Cost Per Conversion</td>
                        <?php foreach( $dates as $date ): ?>
                            <td><?php echo get_man_data( "cost_per_conversion", $date[0], $date[1] ) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="empty-row"></tr>
                    </tbody>
                    <?php if( $_POST['code'] == "30359942" ): ?>
                        <tbody>
                        <tr class="section-heading warning">
                            <td class="first-col ng-binding">Custom Client Metrics:</td>
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td class="no-line first-col ng-binding">Total Inbound Phone Calls</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "t_inbound_calls", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ng-binding">Replacement Appointments</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "replacement_appts", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ng-binding">Repair &amp; Tune-up Appointments</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "repair_appts", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ng-binding">Replacement Opportunities</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "replacement_opps", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ng-binding">Replacement Quotes</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "replacement_quotes", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="no-line first-col ng-binding">Thumbtack Lead Source</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "thumbtack_leads", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr
                            class="ng-scope last-subsection-row">
                            <td class="no-line first-col ng-binding">Craigslist Lead Source</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "craigslist_leads", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="success ng-scope" ng-repeat="total in section.totals">
                            <td class="total-heading first-col ng-binding">MTD Acutal Sales</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "mtd_sales", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="success ng-scope" ng-repeat="total in section.totals">
                            <td class="total-heading first-col ng-binding">MTD Sales Trending</td>
                            <?php foreach( $dates as $date ): ?>
                                <td><?php echo get_man_data( "mtd_sales_trend", $date[0], $date[1] ) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="success ng-scope" ng-repeat="total in section.totals">
                            <td class="total-heading first-col ng-binding">Total Monthly Sales Goal</td>
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

