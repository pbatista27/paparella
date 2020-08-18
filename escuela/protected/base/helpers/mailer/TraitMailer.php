<?php
namespace base\helpers\mailer;

use Yii;
use \PHPMailer\PHPMailer\PHPMailer;

trait TraitMailer
{
	public  $subject;
	public  $message;
	public  $usernameSend;
	public  $recipients  = [];
	public  $attachments = [];
	private $_PHPMailer;

	public function init()
	{
		$config = (object) Yii::$app->params['mailer'];
		$this->usernameSend	= (empty($this->usernameSend)) ? $config->usernameSend : $this->usernameSend;

		$this->_PHPMailer 				= new PHPMailer;
		$this->_PHPMailer->CharSet      = 'utf-8';
		$this->_PHPMailer->SMTPDebug 	= (YII_ENV_DEV) ? 2 : 0;
		$this->_PHPMailer->host 		= $config->host;
		$this->_PHPMailer->port 		= $config->port;
		$this->_PHPMailer->SMTPAuth		= true;
		$this->_PHPMailer->Username 	= $config->username;
		$this->_PHPMailer->Password		= $config->password;
		$this->_PHPMailer->SMTPSecure	= $config->encryption;
		$this->_PHPMailer->Subject 		= $this->subject;
		$this->_PHPMailer->Body 		= $this->message;

		$this->_PHPMailer->IsHTML(true);
		$this->_PHPMailer->SetFrom( $config->username , $this->usernameSend );
	}


	public function getMail()
	{
		return $this->_PHPMailer;
	}

	public function addRecipient($email, $username)
	{
		array_push($this->recipients, [
			'email'    => $email,
			'username' => $username,
		]);
		return $this;
	}

	public function addAttachment($file, $name = null)
	{
		array_push($this->attachments, [
			'file' => $file,
			'name' => $name,
		]);
		return $this;
	}

	public function sendMessage()
	{
		foreach($this->recipients as $value)
		{
			$u = (object) $value;
			$this->_PHPMailer->addAddress($u->email, $u->username);
		}
		unset($value,$u);

		foreach($this->attachments as $value)
		{
			$f = (object) $value;
			$this->_PHPMailer->addAttachment($f->file, $f->name);
		}
		unset($value, $f);

		if($this->_PHPMailer->Send() == false)
		{
			if(YII_ENV_DEV || YII_ENV_TEST)
				exit($this->_PHPMailer->ErrorInfo);
			else
				return false;
		}

		return true;
	}

	public function __destruct()
	{
		unset($this->_PHPMailer);
	}
}

