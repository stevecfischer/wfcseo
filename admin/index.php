<?php
    require __DIR__.'/../load.php';

    $propertiesPath = ROOT.'/properties/';
    $awrdir         = ROOT.'/awr_reports/';

    $wfc_core = new wfc_core_class;
    $authorized = array(
        'clcsblack@gmail.com',
        'stevecfischer@gmail.com',
        'fischerwfc@gmail.com',
        'semwebfullcircle@gmail.com'
    );

    if( isset($_SESSION['email']) && in_array( $_SESSION['email'], $authorized ) ){
    } else {
        exit('Not authorized.');
    }

?>
<!DOCTYPE>
<html>
<head>
    <title>WFC PDF ADMIN</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/toastr.min.css"/>
    <style>
        td, th{
            width:4rem;
            height:2rem;
            border:1px solid #ccc;
            text-align:center;
        }
        th{
            background:lightblue;
            border-color:white;
        }
    </style>
</head>
<body>
<div id="container" class="">
    <nav class="row toolbar wfc-toolbar">
        <p class="navbar-text">Welcome <strong><?php echo $_SESSION['email']; ?></strong></p>
        <span class="separator"></span>
        <?php echo $revoke; ?>
    </nav>
    <div class="row">
        <div class="col-md-4  sidebar-menu" id="sidebar">
            <ul>
                <li><a href="index.php?action=profiles">Profiles</a></li>
                <li><a href="index.php?action=pdfs">Send PDF</a></li>
                <li><a href="index.php?action=edit_prop">Toggle Property Status</a></li>
            </ul>
        </div>
        <div class="col-md-8 main-content">
            <h1>Admin panel</h1>
            <?php
                if( isset($_GET) && !empty($_GET['action']) ){
                    $_GET['action'] = preg_replace( '#[^0-9a-zA-Z]#i', '', $_GET['action'] );
                    include $_GET['action'].'.php';
                } else {
                    echo 'dashboard';

                }
            ?>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/toastr.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="admin.js"></script>
</html>