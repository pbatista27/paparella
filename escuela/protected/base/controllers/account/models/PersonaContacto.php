<?php

namespace controllers\account\models;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use app\models\TipoDocumentoIdentidad;
use app\models\Localidad;

class PersonaContacto extends \app\models\UsuarioContacto
{
	public function attributeLabels()
	{
		return [
			'id_localidad' 			=> Yii::t('app', 'Localidad'),
			'codigo_postal' 		=> Yii::t('app', 'Código postal'),
			'direccion'    			=> Yii::t('app', 'Dirección'),
			'telefono_celular'		=> Yii::t('app', 'Teléfono celular'),
			'telefono_habitacion'	=> Yii::t('app', 'Teléfono de habitación'),
		];
	}

	public function rules()
	{
		return [
			[['id_localidad'  , 'direccion', 'codigo_postal', 'nombres', 'apellidos', 'relacion'], 'required'],
			[['id_localidad'] , 'integer'],
			[['id_localidad'] , 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id'] ],
			[['direccion']    , 'string', 'min'=> 5, 'max' => 255],
			[['codigo_postal'], 'validarCodigoPostal'],
			[['telefono_celular', 'telefono_habitacion'] ,'integer'],
			[['telefono_celular', 'telefono_habitacion'] ,'string', 'min' => 11, 'max' => 15],
			[['fecha_nacimiento'], 'date', 'format'=> 'php:Y-m-d'],
			[['nombres', 'apellidos', 'relacion'], 'string', 'max' => 50],
		];
	}

	public function validarCodigoPostal($attribute)
	{
		if( empty($this->{$attribute}) )
			return;

		$pattern = '<^(\d{4})$>';
		if(preg_match($pattern, $this->{$attribute}))
			return;

		$msnError = Yii::t('app', '{attribute} debe ser del formato {formato}', [
			'attribute' => $this->getAttributeLabel($attribute),
			'formato'   => '9999'
		]);

		$this->addError($attribute, $msnError);
	}
}


