<?php
namespace base\modules\admin\cursos\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class Curso extends \app\models\Curso
{
    const DEFAULT_IMAGE   = '@web/images/dashboard/not-image.jpg';
    const WEBROOT_UPLOAD  = '@webroot/images/cursos/';
    const WEB_UPLOAD      = '@web/images/cursos/';

	public function init()
	{
		parent::init();

		if($this->isNewRecord)
			$this->activo = 1;
	}

	public function getImage()
	{
		if(is_null($this->foto_promocional))
			return Yii::getAlias(static::DEFAULT_IMAGE);

		$file = Yii::getAlias(static::WEBROOT_UPLOAD) . $this->foto_promocional;
		if(!is_file($file) || !is_readable($file))
			return Yii::getAlias(static::DEFAULT_IMAGE);
		else
			return Yii::getAlias(static::WEB_UPLOAD) . $this->foto_promocional;
	}

	public function rules()
	{
		return [
			[['nombre', 'cantidad_meses', 'cantidad_clases', 'precio_cuota'], 'required'],
			[['cantidad_meses', 'cantidad_clases'], 'integer', 'min' => 1],
			[['cantidad_clases'],'integer','max' => 36],
			[['activo'], 'boolean'],
			[['precio_matricula'], 'number', 'min' => 0],
			[['precio_cuota'], 'number', 'min' => 1],
			[['foto_promocional'], 'file', 'checkExtensionByMimeType' => true, 'extensions' => 'jpg, jpeg, png',  'maxSize'=> (1024 * 1024 * 64) ],
			[['nombre'], 'unique'],
			[['nombre'], 'string', 'min'=> 3 , 'max'=> 50],
		];
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		if(!empty($attributeNames))
			return parent::save($runValidation, $attributeNames);

		// region save Image:
		$flagIsNewRecord 	= $this->isNewRecord;
		$oldImage 			= ($this->isNewRecord) ? null : $this->oldAttributes['foto_promocional'];

		$flagDeleteOldImage = false;
		$db 		  		= static::getDb();
		$transaction  		= $db->beginTransaction();

		if($this->foto_promocional instanceof UploadedFile)
		{
			$fileName = 'img_' . preg_replace('<\s|\.>', '', microtime()) .'.'. $this->foto_promocional->getExtension();

			try{
				$this->foto_promocional->saveAs( Yii::getAlias( static::WEBROOT_UPLOAD . $fileName ) );
				$this->foto_promocional = $fileName;

				if(!empty($oldImage))
					$flagDeleteOldImage = true;
			}
			catch(\Exeption $e){
				$this->foto_promocional = $oldImage;
				$flagDeleteOldImage     = false;
			}
		}
		else
			$this->foto_promocional = $oldImage;

		$save = parent::save($runValidation, $attributeNames);

		if($save !== true)
		{
			$transaction->rollBack();
			return false;
		}

		$transaction->commit();

		if($flagDeleteOldImage)
			@unlink(  Yii::getAlias( static::WEBROOT_UPLOAD . $oldImage )  );

		return true;
	}

	public function findActivos()
	{
		$query = static::find();
		$query->join('INNER JOIN', 'curso_sucursal as cs', 'cs.id_curso    = curso.id');
		$query->join('INNER JOIN', 'sucursal as s'		 , 'cs.id_sucursal = s.id');
		$query->where('curso.activo = 1 and curso.is_tmp = 0');
		$query->andWhere('s.activo = 1');

		$query->orderBy('curso.nombre asc');
		return  $query;
	}

	public function getProgramacionDataProvider()
	{
		return new ActiveDataProvider([
			'query' 	 => CursoProgramacion::find()->where('id_curso = :id_curso', [ ':id_curso' => $this->id ]),
			'pagination' => [
				'pageSize' => 4,
			],
			'sort' => ['defaultOrder' => [
					'id' => SORT_ASC
				]
			]
		]);
	}

	public function getMaterialProgramaDataProvider()
	{
		return new ActiveDataProvider([
			'query' 	 => MaterialPrograma::find()->where('id_curso = :id_curso and id_tipo_contenido =:tipo_contenido', [
				':id_curso' 		=> $this->id,
				':tipo_contenido' 	=> MaterialPrograma::TIPO_CONTENIDO,
			]),
			'pagination' => [
				'pageSize' => 4,
			],
			'sort' => ['defaultOrder' => [
					'id' => SORT_ASC
				]
			]
		]);
	}

	public function getMaterialDocenteDataProvider()
	{
		return new ActiveDataProvider([
			'query' 	 => MaterialDocente::find()->where('id_curso = :id_curso and id_tipo_contenido =:tipo_contenido', [
				':id_curso' 		=> $this->id,
				':tipo_contenido' 	=> MaterialDocente::TIPO_CONTENIDO,
			]),
			'pagination' => [
				'pageSize' => 4,
			],
			'sort' => ['defaultOrder' => [
					'id' => SORT_ASC
				]
			]
		]);
	}

	public function getMaterialEstudianteDataProvider()
	{
		return new ActiveDataProvider([
			'query' 	 => MaterialEstudiante::find()->where('id_curso = :id_curso and id_tipo_contenido =:tipo_contenido', [
				':id_curso' 		=> $this->id,
				':tipo_contenido' 	=> MaterialEstudiante::TIPO_CONTENIDO,
			]),
			'pagination' => [
				'pageSize' => 4,
			],
			'sort' => ['defaultOrder' => [
					'id' => SORT_ASC
				]
			]
		]);
	}

	public function getExamenDataProvider()
	{
		return new ActiveDataProvider([
			'query' 	 => Examen::find()->where('id_curso = :id_curso and id_tipo_contenido =:tipo_contenido', [
				':id_curso' 		=> $this->id,
				':tipo_contenido' 	=> Examen::TIPO_CONTENIDO,
			]),
			'pagination' => [
				'pageSize' => 4,
			],
			'sort' => ['defaultOrder' => [
					'id' => SORT_ASC
				]
			]
		]);
	}

	public function delete()
	{
		$db = static::getDb();
		$transaction  = $db->beginTransaction();

        try{
			//curso_contenido:
			$db->createCommand()
	            ->delete('curso_contenido', 'id_curso = :id', [':id' => $this->id])
	            ->execute();

			//curso_programacion:
			$db->createCommand()
	            ->delete('curso_programacion', 'id_curso = :id', [':id' => $this->id])
	            ->execute();

			$db->createCommand()
	            ->delete('curso_sucursal', 'id_curso = :id', [':id' => $this->id])
	            ->execute();

	        if(parent::delete())
	        {
				$transaction->commit();
				return true;
	        }
        }
        catch(\Exception $e){
        	//@todo add log
        }

		$transaction->rollBack();
		return false;
	}
}



