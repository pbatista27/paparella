<?php
namespace base\modules\admin\cursos\components;
use Yii;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use base\modules\admin\cursos\models\CursoContenido as DbModel;

class DownloadAction extends \yii\base\Action
{
	public function run()
	{
		try{
			$id = (int) Yii::$app->request->getQueryParam('id', 0);
			$model = DbModel::findOne($id);

			if(is_null($model))
				throw new NotFoundHttpException( Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

			$file = $model->getFile(true);

			if(!$file || !is_file($file) || !is_readable($file) )
				throw new HttpException( 500, Yii::t('app', 'Contenido no disponible') );


			$ext      = pathinfo($file, PATHINFO_EXTENSION);
			$fileName = Inflector::slug($model->nombre)  . ($ext ? '.'.$ext : null );

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			header('Content-Type: ' . finfo_file($finfo, $file));
			finfo_close($finfo);

			header('Content-Disposition: attachment; filename='. $fileName );
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');

			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			exit(readfile($file));
		}
		catch(\Exception $e){
			throw new HttpException( 404, Yii::t('app', 'Contenido no disponible') );
		}
	}
}
