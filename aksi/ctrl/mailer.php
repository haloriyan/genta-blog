<?php
include 'controller.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../aset/phpmailer/Exception.php';
require '../../aset/phpmailer/PHPMailer.php';
require '../../aset/phpmailer/SMTP.php';

class mailer extends EMBO {
	public function kirim($to, $name, $subjek, $message) {
		$mail = new PHPMailer(true);

		// Settings
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host 		= 'blog.agendakota.co.id';
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