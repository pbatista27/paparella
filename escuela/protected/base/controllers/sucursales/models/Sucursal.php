<?php
namespace controllers\sucursales\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Localidad;
use app\models\TipoNumeroTelefonico;

class Sucursal extends \app\models\Sucursal
{
	const ID_NUM_TEL_EMPRESA    = [2,3,4,6];
	const ID_NUM_TEL_PERSONAL   = [1,3,4,5];
	const ID_NUM_TEL_EXTENSION  = [1,2,5,6];

	public function getMapTipoNum()
	{
		$query = TipoNumeroTelefonico::find()->where(['in', 'id', static::ID_NUM_TEL_EMPRESA ]);
		$query->orderBy('nombre asc');
		return ArrayHelper::map($query->all(), 'id','nombre');
	}

	public function attributeLabels()
	{
		return [
			'id_localidad' 	=> Yii::t('app', 'Localidad'),
			'Nombre'	   	=> Yii::t('app', 'Nombre de sucursal'),
			'codigo_postal' => Yii::t('app', 'Código postal'),
			'direccion'    	=> Yii::t('app', 'Dirección'),
			'email'    		=> Yii::t('app', 'Correo eléctronico'),

			'extension1' 	=> Yii::t('app', 'Ext.'),
			'extension2' 	=> Yii::t('app', 'Ext.'),

			'numero1'		=> Yii::t('app', 'Numero Principal'),
			'numero2'		=> Yii::t('app', 'Numero Secundario'),

			'id_tipo_num1'  => Yii::t('app', 'Tipo de num. principal'),
			'id_tipo_num2'  => Yii::t('app', 'Tipo de num. secundario'),
			'activo'		=> Yii::t('app', '¿Sucursal activa?'),
		];
	}

	public function rules()
	{
		return [
			[['id_localidad', 'nombre', 'direccion'], 'required'],
			[['direccion'], 'string', 'min'=> 5, 'max' => 255],
			[['email'] , 'email'],
			[['nombre', 'email'], 'string', 'min'=> 3, 'max' => 50],
			[['codigo_postal'], 'string', 'min' => 4, 'max' => 4],
			[['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id'] ],
			[['nombre'] , 'validarNombreUnico'],
			[['id_tipo_num1', 'id_tipo_num2'] , 'in', 'range' => static::ID_NUM_TEL_EMPRESA, 'enableClientValidation' => false ],
			[['extension1', 'extension2'] ,'integer'],
			[['extension1', 'extension2'] ,'string', 'min' => 0, 'max' => 4],
			[['codigo_postal'] ,'validarCodigoPostal'],
			[['numero1', 'numero2'] ,'string', 'min' => 7, 'max' => 20],

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

	public function validarNombreUnico()
	{
		$model = static::find()->where('nombre=:nombre', [':nombre' => $this->nombre])->one();

		if(is_null($model))
			return;

		if( ($this->id === null) || ($this->id != $model->id) )
			return $this->addError('nombre',  Yii::t('app', 'Ya existe una sucursal con este nombre') );
	}

	public function beforeSave($insert)
	{
		if(empty($this->id_tipo_num1) ||  empty($this->numero1) )
		{
			$this->id_tipo_num1 = null;
			$this->numero1      = null;
			$this->extension1   = null;
		}

		if(empty($this->id_tipo_num2) ||  empty($this->numero2) )
		{
			$this->id_tipo_num2 = null;
			$this->numero2      = null;
			$this->extension2   = null;
		}

		if(!in_array($this->id_tipo_num1, static::ID_NUM_TEL_EXTENSION ))
			$this->extension1   = null;

		if(!in_array($this->id_tipo_num2, static::ID_NUM_TEL_EXTENSION ))
			$this->extension2   = null;

		return parent::beforeSave($insert);
	}
}
