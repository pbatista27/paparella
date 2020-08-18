<?php

namespace controllers\account\models;

use Yii;
use yii\web\Controller;
use base\models\UserIdentity;
use yii\helpers\ArrayHelper;

class Password extends \base\models\UserIdentity
{
	public $current_password;
	public $new_password;
	public $repeat_password;

	public function attributes()
	{
		return ArrayHelper::merge(
			parent::attributes(),
			['current_password','new_password', 'repeat_password']
		);
	}

	public function rules()
	{
		$rules = [
			[['new_password'	 , 'repeat_password'], 'required'],
			[['new_password'] 	 , 'string', 'min' => 6 , 'max' => 12],
			[['repeat_password'] , 'compare', 'compareAttribute' => 'new_password']
		];

		if($this->requiere_cambio_pass == 0)
		{
			$rules[] = ['current_password', 'required'];
			$rules[] = ['current_password', 'validateCurrentPassword'];
			$rules[] = ['new_password','compare', 'operator' => '!=', 'compareAttribute' => 'current_password'];
		}

		return $rules;
	}

	public function validateCurrentPassword()
	{
		if($this->validatePassword($this->current_password) == false)
			$this->addError('current_password', Yii::t('app', 'Contraseña actual invalida'));
	}


	public function attributeLabels()
	{
		return [
			'current_password'	=> Yii::t('app', 'Contraseña actual'),
			'new_password'		=> Yii::t('app', 'Nueva contraseña'),
			'repeat_password'	=> Yii::t('app', 'Reptir nueva contraseña'),
		];
	}

	public function save($runValidation = true, $attributeNames = NULL)
	{
		if($this->isNewRecord)
			return false;

		if($this->validate() == false)
			return false;

		$this->password = Yii::$app->security->generatePasswordHash($this->new_password);
		$this->requiere_cambio_pass = 0;
		return parent::update(false , ['password', 'requiere_cambio_pass']);
	}
}


