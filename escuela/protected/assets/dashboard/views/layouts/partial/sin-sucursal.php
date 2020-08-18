<?php
use yii\helpers\Html;
use yii\helpers\Url;
$link = Html::a( Yii::t('app', 'panel de sucursales'), Url::toRoute(['/admin-sucursales/default/create']) , ['target' => '_blank', 'data-pjax' => 0]);
?>
<div class="col-md-12 text-center margin-v-30 padding-v-30">
	<h3>
		<?= Yii::t('app', 'No tiene ninguna sucursal disponible!<br><small>Favor entrar en el {link} para crear una nueva sucursal</small>', ['link' => $link]) ?>
	</h3>
</div>
