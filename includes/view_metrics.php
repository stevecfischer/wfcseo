<?php
    define( 'MONTH', "06" );
    define( 'YEAR', "2015" );
    define( 'TABLE_ID', $_POST['code'] );
    $allgoal          = allgoal_completions();
    $manual_data_file = PROP_DIR.DS.intval( $_POST['code'] ).DS.YEAR.DS.MONTH.DS.'data.json';
    $man_data         = array();
    if( file_exists( $manual_data_file ) ){
        $man_data = unserialize( file_get_contents( $manual_data_file ) );
    }
    $manual_data_array = array(
        'Cost Per Conversion'          => 'cost_per_conversion',
        'Closed Opportunities (Total)' => 'closed_opportunities',
        'Closing Ratio'                => 'closing_ratio',
        'Sales'                        => 'sales',
        'Money Earned Per Lead'        => 'money_earned_per_lead',
        'Average Sale'                 => 'average_sale',
        'Goals'                        => 'goals',
        'Ad Revenue Percentage'        => 'ad_revenue_percentage'
    );
    function get_man_data( $metric, $year, $month ){
        $manual_data_file = PROP_DIR.DS.intval( $_POST['code'] ).DS.$year.DS.$month.DS.'data.json';
        if( file_exists( $manual_data_file ) ){
            $y = unserialize( file_get_contents( $manual_data_file ) );
            if($y[$metric] && !empty($y[$metric])){
                return $y[$metric];
            }
        }
    }

    function get_date_headings(){
        $date_cols = array();
        for( $i = 0; $i <= 5; $i++ ){
            $m           = date( "Y-m", strtotime( "NOW"." -$i months" ) );
            $ym          = explode( "-", $m );
            $date_cols[] = $ym;
        }
        return array_reverse( $date_cols );
    }

    $dates = get_date_headings();
?>


<?php
    $allgoalsforyear = array();
    foreach( $dates as $date ):
        $allgoalsm         = allgoal_completions_month( $date[1], $date[0] );
        $allgoalsforyear[] = $allgoalsm;
    endforeach;
    //    print_r($allgoalsforyear);
    $other    = array_column( $allgoalsforyear, "(Other)" );
    $direct   = array_column( $allgoalsforyear, 'Direct' );
    $display  = array_column( $allgoalsforyear, 'Display' );
    $organic  = array_column( $allgoalsforyear, 'Organic Search' );
    $paid     = array_column( $allgoalsforyear, 'Paid Search' );
    $referral = array_column( $allgoalsforyear, 'Referral' );
    $social   = array_column( $allgoalsforyear, 'Social' );
?>
<table id='table1' class="table table-bordered">
    <thead>
    <tr>
        <th>Metrics</th>
        <?php foreach( $dates as $date ): ?>
            <th><?php echo $date[1].'-'.$date[0] ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody class="table-striped">
    <tr>
        <td>Other</td>
        <?php foreach( $other as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Direct</td>
        <?php foreach( $direct as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Display</td>
        <?php foreach( $display as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Organic Search</td>
        <?php foreach( $organic as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Paid Search</td>
        <?php foreach( $paid as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>SERP Calls</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo get_man_data( 'serp_calls', $date[0], $date[1] ); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Referral</td>
        <?php foreach( $referral as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Social</td>
        <?php foreach( $social as $v ): ?>
            <td><?php echo $v ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Conversions (Analytics)</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo goalcompletions_total_month( $date[1], $date[0] ) ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Sessions</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo sessions_month( $date[1], $date[0] ) ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Clicks</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo adwords_clicks_month( $date[1], $date[0] ) ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>PPC Impressions</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo adwords_impressions_month( $date[1], $date[0] ) ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>TOTAL CTR</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_number_format( total_ctr_month( $date[1], $date[0] ), 2 ) ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>PPC Cost</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_curreny_format( adwords_ppc_cost_month( $date[1], $date[0] ), 2 ) ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Cost Per Conversion</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_curreny_format( get_man_data( 'cost_per_conversion', $date[0], $date[1] ), 2 ); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Closed Opportunities (Total)</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo get_man_data( 'closed_opportunities', $date[0], $date[1] ); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Closing Ratio</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo get_man_data( 'closing_ratio', $date[0], $date[1] ); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Sales</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_curreny_format( get_man_data( 'sales', $date[0], $date[1] ), 2); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Money Earned Per Lead</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_curreny_format( get_man_data( 'money_earned_per_lead', $date[0], $date[1] ), 2); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Average Sale</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_curreny_format( get_man_data( 'average_sale', $date[0], $date[1] ), 2); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Goals</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo scf_curreny_format( get_man_data( 'goals', $date[0], $date[1] ), 2); ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td>Ad Revenue Percentage</td>
        <?php foreach( $dates as $date ): ?>
            <td><?php echo get_man_data( 'ad_revenue_percentage', $date[0], $date[1] ); ?></td>
        <?php endforeach; ?>
    </tr>
    </tbody>
</table>