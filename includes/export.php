<?php

    define('MONTH', $_POST['month']);
    define('YEAR', $_POST['year']);
    define('TABLE_ID', $_POST['code']);
    @unlink( TMP_DIR.'/exportReport.pdf' );
    function parse_awr_report( $awr_file ){
        $awr_html = file_get_contents( ROOT.DS.'awr_reports/'.$awr_file );
        $dom      = new domDocument;
        $dom->loadHTML( $awr_html );
        $finder    = new DomXPath( $dom );
        $classname = "content_main";
        $nodes     = $finder->query( "//*[@class = '$classname']" );
        foreach( $nodes as $node ){
            $node->setAttribute( 'id', "alltables" );
        }
        /*
         * use this to get ALL tables. but remember it will error due to not enough memory
         */
        //$awr_table = $dom->getElementById( 'alltables' );
        /*
         * use this to get just the first table.
         */
        $awr_table = $dom->getElementById( 'section_table1' );
        $imgs = $dom->getElementsByTagName( "img" );
        foreach( $imgs as $img ){
            $old_src = $img->getAttribute( 'src' );
            $src     = 'http://wfcseo.wfcdemo.com/analytics/awr_reports/'.$old_src;
            $img->setAttribute( 'src', $src );
        }
        if( !$awr_table ){
            die("Element not found");
        }
        $awr_report = '<page class="page" style="width:100%"
                backimg="http://wfcseo.wfcdemo.com/analytics/images/backgroundwfc.png"
                backcolor="white" backimgy="top" backimgx="center" backtop="26mm"
                backbottom="18mm">
                <p>'.$dom->saveHTML( $awr_table ).'</p>
            </page>';
        return $awr_report;
    }

    $pdf = new HTML2PDF( 'P', 'A4', 'en' );

    //$html = '<link type="text/css" href="'.URL.'/css/style.css" rel="stylesheet" >';
    $stylesheet = "<style>";
    $stylesheet .= file_get_contents( ROOT.DS.'css/styles-pdf.css' );
    $stylesheet .= "</style>";

    $pdf->WriteHTML( $stylesheet );
    //echo PROP_DIR.DS.$_SESSION['properties'][TABLE_ID].DS.TABLE_ID.DS.'template.tpl';
    if( !file_exists( PROP_DIR.DS.TABLE_ID.DS.'template.tpl' ) ){
        die('File: '.PROP_DIR.DS.TABLE_ID.DS.'template.tpl does not exist');
    }
    $html = file_get_contents( PROP_DIR.DS.TABLE_ID.DS.'template.tpl' );
    $html = do_shortcode( $html );
    /*
     * @todo: this needs to be dynamic
     */
    $awr_file = "Keyword Rankings_Carolina Pest_2014-05-07.html";
    /*
     * temp commenting out awr so reports generate faster!!
     *
     * @todo: don't forget to uncomment this
     */
    //$html .= parse_awr_report( $awr_file );
    echo $stylesheet;
    echo $html;

    $pdf->WriteHTML( $html );
    $pdf->Output( PROP_DIR.DS.TABLE_ID.DS.'reports/'.MONTH.'_'.YEAR.'_Report.pdf', 'F' );
    echo '<a target="_blank" href="'.PROP_URI.DS.TABLE_ID.DS.'reports/'.MONTH.'_'.YEAR.'_Report.pdf">Click to see report.</a>';