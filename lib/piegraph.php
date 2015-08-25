<?php // content="text/plain; charset=utf-8"
    /**
     *    PIE GRAPH LIB
     *    Thibault Miclo
     */
    require_once(__DIR__.'/../src/jpgraph.php');
    require_once(__DIR__.'/../src/jpgraph_pie.php');
    /**
     * @param $d
     * @param $l
     * @param $title
     * @param $filename - use shortcode handle
     *
     * @return string
     */
    function draw_pie( $d, $l, $title, $filename ){
        // A new pie graph
        $graph = new PieGraph( 250, 200);
        $graph->SetShadow();
        // Title setup
        $graph->title->Set( $title );
        $graph->title->SetFont( FF_FONT1, FS_BOLD );
        $graph->SetBox( true );
        $graph->img->SetTransparent( "white" );
        // Setup the pie plot
        $p1 = new PiePlot( $d );
        // Adjust size and position of plot
        $p1->SetSize( 0.35 );
        $p1->SetCenter( 0.5, 0.4 );
        // Setup slice labels and move them into the plot
        $p1->value->SetFont( FF_FONT1, FS_BOLD );
        $p1->value->SetColor( "darkred" );
        $p1->SetLabelPos( 0.5 );
        $p1->SetLabels( $l );
        $p1->SetLabelType( PIE_VALUE_PER );
        // Explode all slices
        $p1->ExplodeAll( 10 );
        // Add drop shadow
        $p1->SetShadow();
        // Finally add the plot
        $graph->Add( $p1 );
        // ... and stroke it
        @unlink( PROP_DIR."/".TABLE_ID."/pie.png" );
        $graph->Stroke( PROP_DIR."/".TABLE_ID."/".$filename.".png" );
        return '<img src="'.PROP_URI.'/'.TABLE_ID.'/'.$filename.'.png" />';
    }