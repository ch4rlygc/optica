<?php
/**
 * User: Alexander Flores
 * Date: 1/05/2018
 * Time: 10:20 AM
 */
header('Content-Type: application/json');
if(!empty($_POST)){
	include_once('recaptchalib.php');
	// your secret key
	$secret = "6LcYkFYUAAAAAKSnzynG6CVY575zV64XMt8wSvfo";

	// empty response
	$response = null;

	// check secret key
	$reCaptcha = new ReCaptcha($secret);

	// if submitted check response
	if (!empty($_POST["g-recaptcha-response"])) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);

		if ($response != null && $response->success) {

			// Check for empty fields
			if(empty($_POST['name'])  		||
				empty($_POST['email']) 		||
				empty($_POST['message'])){
				$arr = array("status" => "fail", "message" => "Todos los campos son obligatorios");
				print json_encode($arr);
				die;
			}

			$name = $_POST['name'];
			$email_address = $_POST['email'];
			$message = $_POST['message'];

			// Create the email and send the message
			$to = 'yourname@yourdomain.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
			$email_subject = "Website Contact Form:  $name";
			$email_body = "Recibió un nuevo mensaje del formulario de contacto de su sitio web.\n\n"."Aquí están los detalles:\n\nNombre: $name\n\nCorreo: $email_address\n\nMensaje:\n$message";
			$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
			$headers .= "Reply-To: $email_address";
			if(mail($to,$email_subject,$email_body,$headers)){
				$arr = array("status" => "ok", "message" => "Correo enviado correctamente");
				print json_encode($arr);
			}
			else{
				$arr = array("status" => "fail", "message" => "Hubo un problema al enviar el correo, intente de nuevo.");
				print json_encode($arr);
			}
		}
		else{
			$arr = array("status" => "fail", "message" => "No se pudo enviar el mensaje");
			print json_encode($arr);
		}
		die;
	}

	$arr = array("status" => "fail", "message" => "Por favor, valide que no es robot");
	print json_encode($arr);
}