<?php
namespace base\helpers\mailer;

use Yii;
use Yii\helpers\ArrayHelpers;
use PHPMailer\PHPMailer\PHPMailer;

class SendMail extends \yii\base\component
{
	use TraitMailer;

	public static function test($email='salas.flavio@gmail.com', $username='Flavio Salas', $message='<h1>MSN TEST BODY</h1>', $subject = 'MSN TEST TITLE')
	{
		$obj = Yii::createObject([
			'class'			=> static::className(),
			'subject'		=> $subject,
			'message'		=> $message,
		]);
		$obj
		->addRecipient($email, $username)
		->addAttachment(__FILE__, __FILE__);

		return $obj->sendMessage();
	}

	public static function send($params)
	{
		$params = (object) $params;
		return Yii::createObject([
			'class'			=> static::className(),
			'subject'		=> $params->subject,
			'message'		=> $params->bodyMsn,
		])
		->addRecipient($params->mail, $params->username)
		->sendMessage();
	}
}
