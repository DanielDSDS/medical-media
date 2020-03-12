<?php
    $to_email = 'ddimelan9no@gmail.com';
    $subject = 'Testing PHP Mail';
    $message = 'This mail is sent using the PHP mail function';
    $headers = 'From: ddimela9no@gmail.com';
    mail($to_email,$subject,$message,$headers);
?>