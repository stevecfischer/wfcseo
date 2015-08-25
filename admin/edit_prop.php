<?php

    $propertiesPath = ROOT.'/properties/';
    $awrdir         = ROOT.'/awr_reports/';

    $sites = $wfc_core->getSitesList( $analytics );
    die('eee');
    usort( $sites, array($wfc_core, 'property_sort') );
    foreach( $sites as $s ){
        print_r($s);
        ?>

    <?php
    }//endforeach


?>
<form method="post" action="index.php?action=pdfs">
    Month (ex: 04 = avril) <input type="text" name="month"/> - Year (ex: 1992) <input type="text" name="year"/>
    <?php
        $a->displayTable();

    ?>
    <input type="submit" value="Send reports"/>
</form>
