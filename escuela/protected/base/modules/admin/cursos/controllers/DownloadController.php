<?php
namespace base\modules\admin\cursos\controllers;

class DownloadController extends \base\Controller
{
	public function actions()
	{
		return [
			'index' => [
				'class' => '\base\modules\admin\cursos\components\DownloadAction'
			],
		];
	}
}
