<?php

    /**
     *
     * @package scf-framework
     * @author Steve
     * @date 12/17/13
     * @version 5.2
     */
    class wfc_core_class
    {
        public $month_arr = array();

        public function wfc_core_class(){
            $this->setReporting();
            $this->setMonthArr();
        }

        /**
         * @param array $month_arr
         */
        public function setMonthArr(){
            $wfc_months      = array(
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
            $this->month_arr = $wfc_months;
        }

        public function buildPropertyDirectory( $prop_id ){
            if( !file_exists( PROP_DIR.DS.$prop_id.DS.'reports' ) ){
                if( !mkdir( PROP_DIR.DS.$prop_id.DS.'reports', 755 ) ){
                    return false;
                }
            }
            return true;
        }

        public function getSitesList( &$analytics ){
            $result   = array();
            $accounts = $analytics->management_accounts->listManagementAccounts();
            if( count( $accounts->getItems() ) > 0 ){
                $items = $accounts->getItems();
                foreach( $items as $a ){
                    $webproperties = $analytics->management_webproperties->listManagementWebproperties( $a->getId() );
                    if( count( $webproperties->getItems() ) > 0 ){
                        $items_p = $webproperties->getItems();
                        foreach( $items_p as $b ){
                            $profiles =
                                $analytics->management_profiles->listManagementProfiles( $a->getId(), $b->getId() );
                            if( count( $profiles->getItems() ) > 0 ){
                                $items_s = $profiles->getItems();
                                foreach( $items_s as $c ){
                                    $_SESSION['properties'][$c->getId()] = $b->getId();
                                    $result[]                            = $c;
                                }
                            }
                        }
                    }
                }
            }
            return $result;
        }

        public function sanitize_title( $property_url ){
            $property_url = str_replace( "http://www.", "", $property_url );
            $property_url = str_replace( "http://", "", $property_url );
            $property_url = rtrim( $property_url, "/" );
            return strtolower( $property_url );
        }

        public function property_sort( $a, $b ){
            return $this->sanitize_title( $a->getWebsiteUrl() ) == $this->sanitize_title( $b->getWebsiteUrl() ) ? 0 :
                ($this->sanitize_title( $a->getWebsiteUrl() ) > $this->sanitize_title( $b->getWebsiteUrl() )) ? 1 : -1;
        }

        private function setReporting(){
            if( DEVELOPMENT_ENVIRONMENT == true ){
                error_reporting( E_ALL );
                ini_set( 'display_errors', 1 );
            } else{
                error_reporting( E_ALL );
                ini_set( 'display_errors', 'Off' );
                ini_set( 'log_errors', 'On' );
                ini_set( 'error_log', ROOT.DS.'lm/tmp'.DS.'logs'.DS.'error.log' );
            }
        }

        /**
         * @param  array $data
         *
         * @return string;
         */
        public function html_table( $data = array() ){
            $r    = '';
            $rows = 10; // define number of rows
            $cols = 4; // define number of columns
            $r .= '<table border="1">';
            for( $tr = 1; $tr <= $rows; $tr++ ){
                $r .= '<tr>';
                for( $td = 1; $td <= $cols; $td++ ){
                    $r .= '<td>row: '.$tr.' column: '.$td.'</td>';
                }
                $r .= '</tr>';
            }
            $r .= '</table>';
            return $r;
        }

        public function upload_file( $origin, $dest, $tmp_name, $prop_id = '' ){
            //@todo needs to be improved.
            // image extension is unknown.
            $fileinfo    = pathinfo( $origin );
            $ext         = $fileinfo['extension'];
            $newfilename = "logo.".$ext;
            $fulldest    = $dest.$newfilename;
            if( !move_uploaded_file( $tmp_name, $fulldest ) ){
                die('error uploading image');
            }
            return PROP_URI.'/'.$prop_id.'/'.$newfilename;
            //return false;
        }

        public function parseTpl( $f, $remove = false ){
            $is_intextarea = false;
            $textarea      = '';
            $i             = 0;
            while( ($buffer = fgets( $f, 4096 )) !== false ){
                if( preg_match( '#<page #', $buffer ) && !$is_intextarea ){
                    if( !$remove ){
                        $textarea .= '<textarea name="content['.$i.']" id="content'.$i.
                            '" style="width:100%;height:400px;">';
                        $is_intextarea = true;
                        $i++;
                    }
                } else{
                    if( preg_match( '#</page>#', $buffer ) ){
                        if( !$remove ){
                            $textarea .= '</textarea>';
                            $is_intextarea = false;
                        } else{
                            $remove = false;
                        }
                    } else{
                        if( !preg_match( '#<page_header#', $buffer ) && !preg_match( '#</page_header#', $buffer ) &&
                            $is_intextarea
                        ){
                            $textarea .= str_replace( array('<br />'.'<br>'), '', $buffer );
                        }
                    }
                }
            }
            return $textarea.'<input type="hidden" name="nb_textarea" id="nb_textarea" value="'.$i.'" />';
        }

        public function print_extra_script( $jsObj, $echo = true ){

            if( !$echo ){
                return $jsObj;
            }

            echo "<script type='text/javascript'>\n"; // CDATA and type='text/javascript' is not needed for HTML 5
            echo "/* <![CDATA[ */\n";
            echo "$jsObj\n";
            echo "/* ]]> */\n";
            echo "</script>\n";

            return true;
        }
    }