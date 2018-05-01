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
			$arr = array("status" => "ok", "message" => "Correo enviado correctamente");
			print json_encode($arr);
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