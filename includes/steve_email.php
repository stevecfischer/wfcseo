<?php
    if(isset($_REQUEST['to'])){
        $receiver = $_REQUEST['to'];
        $subject  = "The subject";
        $message .= 'Hello';
        $header = "MIME-Version: 1.0"."\r\n";
        $header .= "Content-type:text/html;charset=utf-8"."\r\n";
        $header .= "From: marketing@webfullcircle.com"."\r\n";
        if(!mail( "fischerwfc@gmail.com", $subject, $message, $header )){
            die("Error sending mail");
        }else{
            die('mail sent');
        }
    }
    //die("End of the road");

    define('FROM_EMAIL', 'webforms@webfullcircle.com');
    define('FROM_NAME', 'forms');
    define('ADD_EMAIL', 'fischerwfc@gmail.com');
    define('BODY', "email came from".$_SERVER['HTTP_HOST']);
    date_default_timezone_set( 'America/New_York' );
    require_once ROOT.DS.'phpmailer/class.phpmailer.php';
    // this uses smtp2go service smtp
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug   = 2;
    $mail->Debugoutput = 'html';
    $mail->Host        = 'smtpcorp.com';
    $mail->Port        = 465;
    $mail->SMTPSecure  = "ssl";
    $mail->SMTPAuth    = true;
    $mail->Username    = "steve.fischer@webfullcircle.com";
    $mail->Password    = "K5GNJy6r";
    $mail->setFrom( FROM_EMAIL, FROM_NAME );
    $mail->addAddress( ADD_EMAIL );
    $mail->Subject = 'this uses smtp2go service smtp';
    $mail->msgHTML( BODY );
    if( !$mail->send() ){
        echo "Mailer Error: ".$mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
?>
<div class="<?php echo __FILE__; ?>">
    mail status
</div>