<?php
namespace base\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\Html;

class ActiveRecord extends \yii\db\ActiveRecord
{
	public function getClientErrors()
	{
		$errors = [];

		if($this->hasErrors() === false)
			return $errors;

		foreach($this->getErrors() as $attribute => $listError)
			$errors[Html::getInputId($this, $attribute)] = $listError;

		return $errors;
	}
}
