<?php
require 'controller.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'aset/phpmailer/src/Exception.php';
require 'aset/phpmailer/src/PHPMailer.php';
require 'aset/phpmailer/src/SMTP.php';

class mailer extends EMBO {
	public function kirim() {
		$to = EMBO::pos('to');
		$name = EMBO::pos('name');
		$subjek = EMBO::pos('subjek');
		$message = EMBO::pos('message');

		$mail = new PHPMailer(true);

		// Settings
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host 		= 'blog.agendakota.id';
		$mail->SMTPAuth 	= true;
		$mail->Username 	= 'no-reply@blog.agendakota.id';
		$mail->Password 	= 'Inikatasandi2908';
		$mail->SMTPSecure	= 'ssl';
		$mail->Port 		= 465;
		$mail->isHTML(true);

		$mail->setFrom('no-reply@blog.agendakota.id', 'Agendakota');
		$mail->addAddress($to, $name);

	  	$mail->Subject = $subjek;
		$mail->Body = $message;
		$mail->send();
	}
}

$mailer = new mailer();