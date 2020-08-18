<?php

namespace controllers\account\models;

use Yii;
use yii\web\UploadedFile;
use app\models\TipoDocumentoIdentidad;

class DatosBasicos extends \base\models\UserIdentity
{
	public function rules()
	{
		return [
			[['nombres', 'apellidos', 'id_tipo_doc', 'nro_documento', 'email', 'fecha_nacimiento'], 'required'],

			[['id_tipo_doc'], 'integer'],
			[['id_tipo_doc'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDocumentoIdentidad::className(), 'targetAttribute' => ['id_tipo_doc' => 'id']],

    		[['email'], 'checkUniqueEmail'],
    		[['email'], 'email'],
    		[['email'], 'string', 'max' => 100],

			[['nombres', 'apellidos'], 'string', 'max' => 50],
			[['nombres', 'apellidos'], 'match', 'pattern'=>'/^[a-zA-ZñÑ\s\.]+$/'],

			[['fecha_nacimiento'], 'date', 'format'=> 'php:Y-m-d'],
			['imagen_personal', 'file', 'checkExtensionByMimeType' => true, 'extensions' => 'jpg, jpeg, png',  'maxSize'=> (1024 * 1024 * 2) ],

			[['nro_documento'], 'match', 'pattern' =>'/^[0-9]/'],

			[['id_tipo_doc','nro_documento'], 'checkUniqueNroDoc'],
		];
	}

	public function checkUniqueNroDoc()
	{
		$model = static::find()->where('id_tipo_doc =:tipo_doc and nro_documento =:nro_documento', [
			':tipo_doc' 		=> $this->id_tipo_doc,
			':nro_documento'  	=> $this->nro_documento,
		])->one();

		if(is_null($model))
			return;

		if($this->id != $model->id)
		{
			$doc   = $model->getTipoDoc()->one()->codigo . ' ' . $this->nro_documento;
			$error = Yii::t('app', 'Ya se ha registrado otro usuario con el doc. de identidad {doc}', ['doc' => $doc]);
			$this->addError('id_tipo_doc',   '');
			$this->addError('nro_documento', $error);
		}
	}

	public function checkUniqueEmail()
	{
		$model = static::find()->where('email =:email', [
			':email' => $this->email,
		])->one();

		if(is_null($model))
			return;

		if($this->id != $model->id)
		{
			$error = Yii::t('app', 'Ya se ha registrado otro usuario con este correo eléctronico');
			$this->addError('email', $error);
		}
	}

	public function attributeLabels()
	{
		return [
			'id_tipo_doc'		=> Yii::t('app', 'Tipo Documento'),
			'nro_documento'		=> Yii::t('app', 'Nro Documento'),
			'imagen_personal'	=> Yii::t('app', 'Imagen Personal'),
			'nombres'			=> Yii::t('app', 'Nombres'),
			'apellidos'			=> Yii::t('app', 'Apellidos'),
			'fecha_nacimiento'	=> Yii::t('app', 'Fecha de nacimiento'),
		];
	}

	protected function proccessImage()
	{
		$this->imagen_personal = UploadedFile::getInstance($this, 'imagen_personal');

		if(is_null($this->imagen_personal))
		{
			$this->imagen_personal = $this->oldAttributes['imagen_personal'];
			return;
		}

		try{
			$fileName = 'avatar_' . preg_replace('<\s|\.>', '', microtime()) .'.'. $this->imagen_personal->getExtension();
			$this->imagen_personal->saveAs( Yii::getAlias( static::WEBROOT_UPLOAD . $fileName ) );
			$this->imagen_personal = $fileName;
		}
		catch(\Exception $e){
			$this->imagen_personal = $this->oldAttributes['imagen_personal'];
		}
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		if($this->validate() !== true)
			return;

		$changeImage = $this->proccessImage();

		if(parent::save(false, $attributeNames) == false)
			return false;

		if($this->imagen_personal != $this->oldAttributes['imagen_personal'])
			@unlink(  Yii::getAlias( static::WEBROOT_UPLOAD . $this->oldAttributes['imagen_personal'] )  );

		return true;
	}
}
