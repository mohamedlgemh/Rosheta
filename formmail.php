<?php
if ($_SERVER['REQUEST_METHOD']=="POST"){

   // we'll begin by assigning the To address and message subject
   $email_to="email@domain.com"; // Change to your email - CC email add comma and email , email@domain.com
   $subject="Appointments Contact Form"; // Change subject if wished

   // get the sender's name and email address
   // we'll just plug them a variable to be used later
   $from = stripslashes($_POST['fullname'])."<".stripslashes($_POST['email']).">";

   // generate a random string to be used as the boundary marker
   $mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";

   // now we'll build the message headers
   $headers = "From: $from\r\n" .
//   'Cc: '.$from."\r\n" . // to enable sending a Cc email to sender remove two comment forward slashes in front of // 'CC
// 'Reply-To: webmaster@example.com' . "\r\n" . // to enable the reply email address remove the two commment forward slashes in front of 'Reply-To
   all-forms
   "MIME-Version: 1.0\r\n" .
      "Content-Type: multipart/mixed;\r\n" .
      " boundary=\"{$mime_boundary}\"";

   // here, we'll start the message body.
   // this is the text that will be displayed
   // in the e-mail
   // validation expected data exists
   
    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['fullname']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['phone']) ||
		
		!isset($_POST['dates']) ||
		
		!isset($_POST['radio_email_phone']) ||
		
		!isset($_POST['checkbox_days']) ||
		
		!isset($_POST['radio_am_pm']) ||
 
        !isset($_POST['comment'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
     
 
    $fullname = $_POST['fullname']; // required
 
    $email_from = $_POST['email']; // required
 
    $phone = $_POST['phone']; // not required
	
	$dates = $_POST['dates']; // not required
	
	$radio_email_phone = $_POST['radio_email_phone']; // not required
	
	$checkbox_days = $_POST['checkbox_days']; // not required
	
	$radio_am_pm = $_POST['radio_am_pm']; // not required
 
    $comment = $_POST['comment']; // required
	
	$ip = $_SERVER['REMOTE_ADDR']; //User IP Address
 
    $message = "Form results.\n\n"; // Email Heading
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }  
 
    $message .= "Full Name: ".clean_string($fullname)."\n";
 
    $message .= "Email: ".clean_string($email_from)."\n";
 
    $message .= "Phone: ".clean_string($phone)."\n\n";
	
	$message .= "Dates: ".clean_string($dates)."\n";
	
	$message .= "Contact Via: ".clean_string($radio_email_phone)."\n";
	
	$message .= "Preferred Days: ".implode(" ", $_POST['checkbox_days'])."\n";
	
	$message .= "Prefer AM/PM: ".clean_string($radio_am_pm)."\n\n";
 
    $message .= "Message:\n".clean_string($comment)."\n\n";
	
	$message .= "* Senders IP Address: ".clean_string($ip)."\n";
	

   // next, we'll build the invisible portion of the message body
   // note that we insert two dashes in front of the MIME boundary 
   // when we use it
   $message = "This is a multi-part message in MIME format.\n\n" .
      "--{$mime_boundary}\n" .
      "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
      "Content-Transfer-Encoding: 7bit\n\n" .
   $message . "\n\n";

   // now we'll process our uploaded files
   foreach($_FILES as $userfile){
      // store the file information to variables for easier access
      $tmp_name = $userfile['tmp_name'];
      $type = $userfile['type'];
      $name = $userfile['name'];
      $size = $userfile['size'];

      // if the upload succeded, the file will exist
      if (file_exists($tmp_name)){

         // check to make sure that it is an uploaded file and not a system file
         if(is_uploaded_file($tmp_name)){
 	
            // open the file for a binary read
            $file = fopen($tmp_name,'rb');
 	
            // read the file content into a variable
            $data = fread($file,filesize($tmp_name));

            // close the file
            fclose($file);
 	
            // now we encode it and split it into acceptable length lines
            $data = chunk_split(base64_encode($data));
         }
 	
         // now we'll insert a boundary to indicate we're starting the attachment
         // we have to specify the content type, file name, and disposition as
         // an attachment, then add the file content.
         // NOTE: we don't set another boundary to indicate that the end of the 
         // file has been reached here. we only want one boundary between each file
         // we'll add the final one after the loop finishes.
         $message .= "--{$mime_boundary}\n" .
            "Content-Type: {$type};\n" .
            " name=\"{$name}\"\n" .
            "Content-Disposition: attachment;\n" .
            " filename=\"{$fileatt_name}\"\n" .
            "Content-Transfer-Encoding: base64\n\n" .
         $data . "\n\n";
      }
   }
   // here's our closing mime boundary that indicates the last of the message
   $message.="--{$mime_boundary}--\n";
   // now we just send the message
   
   @mail($email_to, $subject, $message, $headers);
      header('Location: redirect.php'); // your custom redirect after submit, replace redirect.html with full path i.e. http://www.yourdomain.com/redirect.html

session_start();
/* ---- Your other validation code -- */
if (isset($_POST['submit'])){
$_SESSION['fullname'] = $_POST['fullname'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['dates'] = $_POST['dates'];
$_SESSION['radio_email_phone'] = $_POST['radio_email_phone'];
$_SESSION['checkbox_days'] = $_POST['checkbox_days'];
$_SESSION['radio_am_pm'] = $_POST['radio_am_pm'];
$_SESSION['comment'] = $_POST['comment'];
 exit();
}

?>

<?php
if (isset($_POST['checkbox_days'])) {
    $checkbox_days_str = implode(" ", $_POST['checkbox_days']);// converts $_POST interests into a string
    $checkbox_days_array = explode(" ", $checkbox_days_str);// converts the string to an array which you can easily manipulate
}

for ($i = 0; $i > count($checkbox_days_array); $i++) {
    echo $checkbox_days_array[$i];// display the result as a string
}
?>

<!-- include your own success html here - will only show if redirct fails -->
Thank you! <br>
Your submission has been sent.

<?php

   echo "<br>", "<strong>Name:</strong> ", $_SESSION['fullname'];
   echo "<br>", "<strong>Email:</strong> ", $_SESSION['email'];
   echo "<br>", "<strong>Phone:</strong> ", $_SESSION['phone'];
   echo "<br>", "<strong>Dates:</strong> ", $_SESSION['dates'];
   echo "<br>", "<strong>Contact Via:</strong> ", $_SESSION['radio_email_phone'];
   echo "<br>", "<strong>Preferred Days:</strong> ".implode(" ", $_SESSION['checkbox_days']);
   echo "<br>", "<strong>Prefer AM/PM:</strong> ", $_SESSION['radio_am_pm'];
   echo "<br>", "<strong>Message:</strong> ", $_SESSION['comment'];
?>



<?php
 
}
 
?>
