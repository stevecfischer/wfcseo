<?php
    /**
     * PHPExcel
     *
     * Copyright (C) 2006 - 2014 PHPExcel
     *
     * This library is free software; you can redistribute it and/or
     * modify it under the terms of the GNU Lesser General Public
     * License as published by the Free Software Foundation; either
     * version 2.1 of the License, or (at your option) any later version.
     *
     * This library is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
     * Lesser General Public License for more details.
     *
     * You should have received a copy of the GNU Lesser General Public
     * License along with this library; if not, write to the Free Software
     * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
     *
     * @category   PHPExcel
     * @package    PHPExcel
     * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
     * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
     * @version    1.8.0, 2014-03-02
     */
    /** Error reporting */
    error_reporting( E_ALL );
    ini_set( 'display_errors', TRUE );
    ini_set( 'display_startup_errors', TRUE );
//    date_default_timezone_set( 'Europe/London' );
    define( 'EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />' );
    define( 'MONTH', "05" );
    define( 'YEAR', "2015" );
    define( 'TABLE_ID', $_POST['code'] );
    // Create new PHPExcel object
    echo date( 'H:i:s' ), " Create new PHPExcel object", EOL;
    $objPHPExcel = new PHPExcel();
    // Set document properties
    echo date( 'H:i:s' ), " Set document properties", EOL;
    /*$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("PHPExcel Test Document")
                                 ->setSubject("PHPExcel Test Document")
                                 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                                 ->setKeywords("office PHPExcel php")
                                 ->setCategory("Test result file");*/
    // Add some data
    $fileName = TABLE_ID.".php";
    echo date( 'h:i:s' ), " Add some data", EOL;
    /**
     * build shell
     * label rows with metrics
     * label columns with dates 13 months
     */
    function build_shell($objPHPExcel){
        $monthArr   = array(
            'blank',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N'
        );
        $metricArr  = array(
            'Paid',
            'Organic',
            'Direct',
            'Referral',
            'Social',
            'Conversions (Analytics)',
            'Sessions',
            'Click',
            'PPC Impressions',
            'Search CTR',
            'PPC Cost',
            'Cost Per Conversion',
            'Website Opportunities',
            'Closed Opportunities',
            'Closing Ratio',
            'Sales',
            'Money Earned Per Lead',
            'Average Sale',
            'Goals',
            'Ad Revenue Percentage'
        );
        $aciveSheet = $objPHPExcel->setActiveSheetIndex( 0 );
        foreach( $metricArr as $mk => $mv ){
            $cell = "A".($mk + 2);
            $aciveSheet->setCellValue( $cell, $mv );
        }
        foreach( array_reverse($monthArr) as $monK => $monV ){
            if( $monV == "blank" ){
                $aciveSheet->setCellValue( "A1", "" );
            } else{
                $cell     = $monV."1";
                $col_date = date( "y-M", strtotime( "-$monK month" ) );
                $aciveSheet->setCellValue( $cell, $col_date );
            }
        }
        $aciveSheet->getColumnDimension('A')->setWidth(30);
    }
    build_shell($objPHPExcel);


    function populate_data($objPHPExcel){
        $aciveSheet = $objPHPExcel->setActiveSheetIndex( 0 );
        $aciveSheet->setCellValue( "L8",  sessions());
        $aciveSheet->setCellValue( "L9",  users());
    }
    populate_data($objPHPExcel);

    // Rename worksheet
    echo date( 'H:i:s' ), " Rename worksheet", EOL;
    $objPHPExcel->getActiveSheet()->setTitle( 'Property Name Here' );
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex( 0 );
    // Save Excel 2007 file
    echo date( 'H:i:s' ), " Write to Excel2007 format", EOL;
    $callStartTime = microtime( true );
    $objWriter     = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
    $objWriter->save( str_replace( '.php', '.xlsx', $fileName ) );
    $callEndTime = microtime( true );
    $callTime    = $callEndTime - $callStartTime;
    echo date( 'H:i:s' ), " File written to ", str_replace( '.php', '.xlsx', pathinfo( $fileName, PATHINFO_BASENAME ) ), EOL;
    echo 'Call time to write Workbook was ', sprintf( '%.4f', $callTime ), " seconds", EOL;
    // Echo memory usage
    echo date( 'H:i:s' ), ' Current memory usage: ', (memory_get_usage( true ) / 1024 / 1024), " MB", EOL;
    // Echo memory peak usage
    echo date( 'H:i:s' ), " Peak memory usage: ", (memory_get_peak_usage( true ) / 1024 / 1024), " MB", EOL;
    // Echo done
    echo date( 'H:i:s' ), " Done writing files", EOL;
    echo 'Files have been created in ', getcwd(), EOL;
    echo '<a target="_blank" href="'.URL.DS.'includes/'.str_replace( '.php', '.xlsx', $fileName ).
        '">Click to view table.</a>';