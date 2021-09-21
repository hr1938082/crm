<?php
/**
* Phpmailer Class
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
	public $mail;
	public function __construct()
	{
		require DIR_BUILDER.'libs/mailer/src/Exception.php';
		require DIR_BUILDER.'libs/mailer/src/PHPMailer.php';
		require DIR_BUILDER.'libs/mailer/src/SMTP.php';
		$this->mail = new PHPMailer;
		$this->mail->CharSet = 'UTF-8';
		//$this->mail->isSMTP();
		if( defined('SMTP_HOST') && defined('SMTP_USERNAME') && defined('SMTP_PASSWORD') && defined('SMTP_PORT')) {
			if (!empty(DB_HOSTNAME) || !empty(SMTP_USERNAME) || !empty(SMTP_PASSWORD) || !empty(SMTP_PORT) ) {
				$this->mail->Host = SMTP_HOST;
				$this->mail->SMTPAuth = true;
				$this->mail->Username = SMTP_USERNAME;
				$this->mail->Password = SMTP_PASSWORD;
				$this->mail->SMTPSecure = 'tls';
				$this->mail->Port = SMTP_PORT;
			}
		}
	}

	public function sendMail()
	{
		$this->mail->send();
	}

	public function getData($name = 'emailsetting')
	{
		$this->model = Registry::getInstance()->get('database');
		$query = $this->model->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `name` = ? LIMIT 1", array($name));
		$result = $query->row;
		$smtp_crd = json_decode($result['data'], true);
		
		if ($result['status'] == "1") {
			$this->mail->Host = $smtp_crd['host'];
			$this->mail->SMTPAuth = $smtp_crd['authentication'];
			$this->mail->Username = $smtp_crd['username'];
			$this->mail->Password = $smtp_crd['password'];
			$this->mail->SMTPSecure = $smtp_crd['encryption'];
			$this->mail->Port = $smtp_crd['port'];

			$this->mail->setFrom($smtp_crd['fromemail'], $smtp_crd['fromname']);
			if (!empty($smtp_crd)) {
				$this->mail->addReplyTo($smtp_crd['reply'], $smtp_crd['fromname']);
			} else {
				$this->mail->addReplyTo($smtp_crd['fromemail'], $smtp_crd['fromname']);
			}
			return true;
		} else {
			return false;
		}
	}
}