<?php

    class wfc_ga_class
    {

        public $name; // the name of the device
        public $battery; // holds a Battery object
        public $data = array(); // stores misc. data in an array
        public $connection; // holds some connection resource

        public function wfc_ga_class(){
            //not sure i need any init things
        }

        public function get_ga_metric( $metric ){
        }

        public function get_metric( $metric, $optParams = array(),$format = "single" ){
            global $demo;
            $from = YEAR.'-'.MONTH.'-01';
            $to   = YEAR.'-'.MONTH.'-'.cal_days_in_month( CAL_GREGORIAN, MONTH, YEAR );
            $m    = "$metric";
            if( ! empty($optParams) && isset($optParams) ){
                $data = $demo->getHtmlOutput( 'ga:'.TABLE_ID, $from, $to, $m, $optParams );
            } else{
                $data = $demo->getHtmlOutput( 'ga:'.TABLE_ID, $from, $to, $m );
            }
            if($format == "all"){
                return $data;
            }
            return $data->totalsForAllResults[$metric];
        }

        public function get_metric_by_month( $metric, $optParams = array(),$format = "single", $month, $year ){
            global $demo;
            $from = $year.'-'.$month.'-01';
            $to   = $year.'-'.$month.'-'.cal_days_in_month( CAL_GREGORIAN, $month, $year );
            $m    = "$metric";
            if( ! empty($optParams) && isset($optParams) ){
                $data = $demo->getHtmlOutput( 'ga:'.TABLE_ID, $from, $to, $m, $optParams );
            } else{
                $data = $demo->getHtmlOutput( 'ga:'.TABLE_ID, $from, $to, $m );
            }
            if($format == "all"){
                return $data;
            }
            return $data->totalsForAllResults[$metric];
        }

        public function new_get_metric_by_month( $metric, $optParams = array(),$format = "single", $month, $year, $propertyID ){
            global $demo;
            $from = $year.'-'.$month.'-01';
            $to   = $year.'-'.$month.'-'.cal_days_in_month( CAL_GREGORIAN, $month, $year );
            $m    = "$metric";
            if( ! empty($optParams) && isset($optParams) ){
                $data = $demo->getHtmlOutput( 'ga:'.$propertyID, $from, $to, $m, $optParams );
            } else{
                $data = $demo->getHtmlOutput( 'ga:'.$propertyID, $from, $to, $m );
            }
            if($format == "all"){
                return $data;
            }
            return $data->totalsForAllResults[$metric];
        }
    }

    //Signature: array array_column ( array $input , mixed $column_key [, mixed $index_key ] )
    if( !function_exists( 'array_column' ) ):
        function array_column( array $input, $column_key, $index_key = NULL ){
            $result = array();
            foreach( $input as $k => $v ){
                $result[$index_key ? $v[$index_key] : $k] = $v[$column_key];
            }
            return $result;
        }
    endif;
