<?php

    require_once 'load.php';

    // Print out authorization URL.
    if( !$authHelper->isAuthorized() ){
        echo "<p id=\"revoke\"><a href='$authUrl'>Grant access to Google Analytics data</a></p>";
        exit;
    }

    //Deal with POST datas
    require_once './includes/datas.php';
?>
<?php require_once './includes/header.php'; ?>

<?php
    require_once './includes/index.php';
    require_once './includes/footer.php';