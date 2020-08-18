<?php
namespace controllers\personal\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use app\models\Sucursal;
use app\models\TipoDocumentoIdentidad;
use yii\web\UploadedFile;

use base\helpers\mailer\SendMail;

class Personal extends \base\models\UserIdentity
{
	public $sucursales = [];
	public $flagNotEditSucursal = false;

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
			[['sucursales'], 'safe'],
		];
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

	public function checkUniqueNroDoc()
	{

		$model = static::find()->where('id_tipo_doc =:tipo_doc and nro_documento =:nro_documento', [
			':tipo_doc' 		=> $this->id_tipo_doc,
			':nro_documento'  	=> $this->nro_documento,
		])->one();

		if(is_null($model))
			return;

		if($this->isNewRecord || $this->id != $model->id)
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
			':email' 			=> $this->email,
		])->one();

		if(is_null($model))
			return;

		if($this->isNewRecord || $this->id != $model->id)
		{
			$error = Yii::t('app', 'Ya se ha registrado otro usuario con este correo eléctronico');
			$this->addError('email', $error);
		}
	}

	public function afterFind()
	{
        parent::afterFind();
        if($this->isNewRecord)
        	return;

        $this->sucursales = array_column( $this->getSucursals()->select('id')->asArray()->all(), 'id');
	}

	protected function proccessImage()
	{
		$this->imagen_personal = UploadedFile::getInstance($this, 'imagen_personal');

		if(is_null($this->imagen_personal))
		{
			$this->imagen_personal = $this->isNewRecord ? null : $this->oldAttributes['imagen_personal'];
			return null;
		}

		try{
			$fileName = 'avatar_' . preg_replace('<\s|\.>', '', microtime()) .'.'. $this->imagen_personal->getExtension();
			$this->imagen_personal->saveAs( Yii::getAlias( static::WEBROOT_UPLOAD . $fileName ) );
			$this->imagen_personal = $fileName;
			return $this->isNewRecord ? null : $this->oldAttributes['imagen_personal'];
		}
		catch(\Exception $e){
			$this->imagen_personal = $this->isNewRecord ? null : $this->oldAttributes['imagen_personal'];
		}

		return null;
	}

	protected function processSucursales()
	{
		$db 	 = static::getDb();
		$data 	 = Yii::$app->request->post($this->formName());

		$allDb 	 = array_column( $this->getDb()->createCommand('select id from sucursal order by id asc')->queryAll(), 'id');
		$oldAdd	 = array_column( $this->getSucursals()->select('id')->orderBy('id asc')->asArray()->all(), 'id');
		$listAdd = (isset($data['sucursales'])) ? $data['sucursales'] : [];
		$news    = empty($oldAdd) ? $listAdd :  array_diff($listAdd, $oldAdd);

		// agregar nuevos items previamente no seleccionados
		foreach( $news as $value)
		{
			if(!in_array($value, $allDb))
				continue;
			try{
				$db->createCommand()->insert('usuario_sucursal', [
					'id_sucursal' => $value,
					'id_usuario'  => $this->id,
				])->execute();
			}
			catch(\Exception $e){
				//puede ser un error de procedure.. no hace falta msn flash error
			}
		}

		// eliminar deseleccionados
		foreach( array_diff($oldAdd, $listAdd) as $value)
		{
			if(!in_array($value, $allDb))
				continue;
			try{
				$db->createCommand()
					->delete('usuario_sucursal', 'id_usuario = :id and id_sucursal =:id_sucursal', [':id' => $this->id, ':id_sucursal' => $value])
					->execute();
			}
			catch(\Exception $e){
				//@todo log flash error fk
			}
		}
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		$flagIsNewRecord 				= $this->isNewRecord;
		$oldImage 						= $this->proccessImage();
		$this->password					= ($flagIsNewRecord == false) ? $this->password 			 : Yii::$app->security->generatePasswordHash(uniqid());
		$this->activo					= ($flagIsNewRecord == false) ? $this->activo   			 : true;
		$this->requiere_cambio_pass		= ($flagIsNewRecord == false) ? $this->requiere_cambio_pass  : true;

		$db 		  = static::getDb();
		$transaction  = $db->beginTransaction();
		$save         = parent::save($runValidation, $attributeNames);

		if($save == false)
		{
			$transaction->rollBack();
			return false;
		}

		if($this->flagNotEditSucursal == false)
			$this->processSucursales();

		$transaction->commit();
		if($oldImage)
			@unlink(  Yii::getAlias( static::WEBROOT_UPLOAD . $oldImage )  );

		if($flagIsNewRecord)
			$this->sendMail('registro');

		return true;
	}

	protected function sendMail($type = 'registro')
	{
		$token = static::findOne($this->id)->token;

		switch (true)
		{
			case 'registro':
				$url    = Url::toRoute(['/site/reset-password', 'token' => $token ], true);
				$params = [
					'subject' => 'Bienvenido Escuela Leo Paparella',
					'mail' => $this->email,
					'username' => $this->getUserName(false),
					'bodyMsn' => '<p><b>'. $this->getUserName(false) .'</b> Te damos la bienvenida a la Escuela Leo Paparella.</p>
						Para iniciar sesión por favor ir al siguiente enlace:<br>
						<hr>
						<a href="'.$url.'" target="_blank">'.$url.'</a>
						<hr>
						<p>Saludos.</p>
						<p>Escuela LP</p>
					',
				];
				return SendMail::send($params);
				break;

			case 'reset-password':
				#code sendmail user recovery password..
				break;
		}
	}
}
