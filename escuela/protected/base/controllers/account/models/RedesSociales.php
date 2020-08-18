<?php

namespace controllers\account\models;

use Yii;
use yii\web\Controller;
use base\models\UserIdentity;
use yii\helpers\ArrayHelper;

class RedesSociales extends \base\models\UserIdentity
{

	public function rules()
	{
		return [
			[['facebook', 'instagram', 'twitter'], 'url'],
			[['facebook', 'instagram', 'twitter'], 'string', 'max' => 50],
            ['facebook'  ,'match','pattern'=>'/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/'],
            ['instagram' ,'match','pattern'=>'/^(https?:\/\/)?(www\.)?instagram.com\/[a-zA-Z0-9(\.\?)?]/'],
            ['twitter'   ,'match','pattern'=>'/^(https?:\/\/)?(www\.)?twitter.com\/[a-zA-Z0-9(\.\?)?]/'],
		];
	}


	public function attributeLabels()
	{
		return [
			'facebook'			=> Yii::t('app', 'Facebook'),
			'instagram'			=> Yii::t('app', 'Instagram'),
			'twitter'			=> Yii::t('app', 'Tiwtter'),
		];
	}
}
