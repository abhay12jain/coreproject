<?php 

    $name= $_POST['user_name'];
    $email= $_POST['Email_id'];
    $subject=$_POST['subject'];
    $mesage=$_POST['message'];


 $to = 'aron@aronswebsites.com';
 $user_to = $email;
 $subject = 'Contact Us';
 $from = '';
 $headers = 'MIME-Version: 1.0'."\r\n";
 $headers .= 'Content-Type: text/html; charset=UTF-8\n' . "\r\n";
 // Create email headers
 $headers .= 'From: '.$email."\r\n".
 'Reply-To: '.$email."\r\n" .
 'X-Mailer: PHP/'.phpversion();
 // Compose a simple HTML email message

 $message = '<html><body><div>';
 $message .= '<h1>Hi Admin!</h1>';
 $message .='<p>Contact  Information</p>';
 $message .= '<table style="width:100%;" border="1">';
 $message .= '<tr><td>'.$name.'</td></tr>';
 $message .= '<tr><td>'.$email.'</td></tr>';
 $message .= '<tr><td>'.$subject.'</td></tr>';
 $message .= '<tr><td>'.$mesage.'</td></tr>';
 $message .= '<tr><td align="center">Funeral</td></table></div></body></html>';

 if(mail($to, $subject, $message, $headers)){
 	//echo '###';
    $_SESSION['ststus']="Success";
 	header('Location: ' . $_SERVER['HTTP_REFERER'].'?msg='.$_SESSION['ststus']);
 	die();
 } 
else{
	//echo '@@@';
       $_SESSION['ststus']="failed";
 	header('Location: ' . $_SERVER['HTTP_REFERER'].'?msg='.$_SESSION['ststus']);;
 	die();
}
 
?>