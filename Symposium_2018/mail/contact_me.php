<?php
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['empresa']) 		||
   empty($_POST['cargo']) 		||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$comment = $_POST['message'];
$empresa = $_POST['empresa'];
$cargo = $_POST['cargo'];

   $mysqli = mysqli_connect('localhost', 'www-citupc','25112011citupcUPC', 'www-citupc');
   $mysqli->set_charset("utf8");
   $query = "INSERT INTO tbl_symposium (nom, telefono, email, comentario, empresa, cargo)VALUES ('".$name."', '".$phone."', '".$email_address."','".$comment."','".$empresa."','".$cargo."')";
	$mysqli->query($query);
	
// Create the email and send the message
$to = $email_address; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$subject = "Confirmation of registration in Symposium";
$random_hash = md5(date('r', time()));
$email_body = "Dear $name,\n\nYour registration to  Symposium “CHALLENGES IN URBAN MOBILITY” was successfully received.\n\nThe date for the event is 16th of November, 2015 (9:00 – 19:30)"."UPC Campus Nord,\nCarrer Jordi Girona 1-3\n08034 Barcelona (Catalonia), Spain\nhttps://goo.gl/maps/f4bzWDAMmGk\n\nThank you for your interest in participating,\n\nKind regards,\nDaniel Serra\ninfo@carnetbarcelona.com\nCARNET Office\n";
$headers = "From: info@carnetbarcelona.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";	
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
$attachment = chunk_split(base64_encode(file_get_contents('date.msg')));
ob_start(); //Turn on output buffering
?>
--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-type: text/html; charset=UTF-8
Content-Transfer-Encoding: 7bit

<p style="font-family: Calibri">Dear <?php echo $name?>,<br><br>

Your registration at Symposium "CHALLENGES IN URBAN MOBILITY" was successfully received.<br><br>

The date for the event is 16th of November, 2015 (9:00 to 19:30).<br><br>

UPC Campus Nord,<br>
Carrer Jordi Girona 1-3<br>
08034 Barcelona (Catalonia), Spain<br>
https://goo.gl/maps/f4bzWDAMmGk<br><br>

Thank you for your interest in participating.<br><br>

Kind regards,<br>
Daniel Serra <br>
CARNET Office<br>
info@carnetbarcelona.com<br>

</p>

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: application/msg; name="date.msg" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $attachment; ?>
--PHP-mixed-<?php echo $random_hash; ?>--

<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
$to="info@carnetbarcelona.com";
$subject = "$name se ha registrado para el symposium";
$headers = "From: info@carnetbarcelona.com\n";
$headers .= "Content-type: text/html; charset=UTF-8";	
$message = "Nombre: $name<br>Mail: $email_address<br>Telf: $phone<br>Comentario: $comment<br>Empresa: $empresa<br>Cargo: $cargo";
$mail_sent2 =  @mail( $to, $subject, $message, $headers );
return true			
?>