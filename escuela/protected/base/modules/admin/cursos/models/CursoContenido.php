<?php
namespace base\modules\admin\cursos\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class CursoContenido extends \app\models\CursoContenido
{
	const WEBROOT_UPLOAD   = '@app/data/uploads/cursos/';
	const WEB_UPLOAD       = '@app/data/uploads/cursos/';

	public function getFile($webroot = false)
	{
		if(is_null($this->archivo))
			return;

		$file = Yii::getAlias(static::WEBROOT_UPLOAD) . $this->archivo;

		if(!is_file($file))
			return;

		if($webroot === true)
			return $file;
		else
			return Yii::getAlias(static::WEB_UPLOAD) . $this->archivo;
	}

	public function getFileExtension()
	{
		try{
			return strtolower(pathinfo($this->getFile(true), PATHINFO_EXTENSION));
		}
		catch(\Exception $e){
			return null;
		}
	}

	public function hasFile()
	{
		return $this->getFile() ? true : false;
	}

	public function rules()
	{
		$rules = [
        	[['id_curso','nombre'], 'required'],
        	[['nombre'], 'string', 'min' => 5, 'max' => 255],
        	[['id_curso'], 'integer'],
        	[['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']],
			['archivo', 'file',  'maxSize'=> (1024 * 1024 * 64) ], // 'checkExtensionByMimeType' => true, 'extensions' => 'jpg, jpeg, png'
		];

		if($this->hasFile() == false)
			$rules[] = [['archivo'] , 'required'];

		return $rules;
	}

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_curso' => Yii::t('app', 'Curso'),
            'id_tipo_contenido' => Yii::t('app', 'Tipo de contenido'),
            'archivo' => Yii::t('app', 'Archivo'),
            'nombre' => Yii::t('app', 'Titulo'),
        ];
    }

	public function save($runValidation = true, $attributeNames = null)
	{
		if(!empty($attributeNames))
			return parent::save($runValidation, $attributeNames);

		//$flagIsNewRecord 	= $this->isNewRecord;
		$oldFile 			= ($this->isNewRecord) ? null : $this->oldAttributes['archivo'];

		$flagDeleteOldFile  = false;
		$db 		  		= static::getDb();
		$transaction  		= $db->beginTransaction();

		if($this->archivo instanceof UploadedFile)
		{

			$fileName = 'archivo_' . preg_replace('<\s|\.>', '', microtime()) .'.'. $this->archivo->getExtension();
			try{
				$this->archivo->saveAs( Yii::getAlias( static::WEBROOT_UPLOAD . $fileName ) );
				$this->archivo = $fileName;

				if(!empty($oldFile))
					$flagDeleteOldFile = true;
			}
			catch(\Exeption $e){
				$this->archivo = $oldFile;
				$flagDeleteOldFile  = false;
			}
		}
		else
			$this->archivo = $oldFile;

		$this->id_tipo_contenido = static::TIPO_CONTENIDO;
		$save = parent::save($runValidation, $attributeNames);

		if($save !== true)
		{
			$transaction->rollBack();
			return false;
		}

		$transaction->commit();

		if($flagDeleteOldFile and $this->id_tipo_contenido != 4)
			@unlink(  Yii::getAlias( static::WEBROOT_UPLOAD . $oldFile )  );

		return true;
	}
}
