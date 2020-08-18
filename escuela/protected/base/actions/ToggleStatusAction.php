<?php
namespace base\actions;

use Yii;

class ToggleStatusAction extends \yii\base\Action
{
	public $modelClass;
	public $key = 'id';
	public $columnStatus = 'activo';

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$id    = (int) Yii::$app->request->getQueryParam($this->key, 0);
		$model = $this->modelClass::findOne($id);

		if(is_null($model))
			return;

		$model->{$this->columnStatus} = !$model->{$this->columnStatus};
		try{
			$model->save(false, [$this->columnStatus]);
		}
		catch(\Exception $e){
		}
	}
}
