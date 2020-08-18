<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->H1       =  Yii::t('Yii', 'Error {code}' , ['code' => $exception->statusCode ]);//Yii::t('app', $name);
$this->title    = $this->H1 .' | '. Yii::$app->name;

    $this->breadcrumbs    = [
        ['label' =>  Yii::t('yii', 'Home'), 'url'=> Url::toRoute(['/site/index' ]) ],
        ['label' => Yii::t('yii', 'Error')],
    ];

?>
<div class="container-fluid">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="row margin-v-30 text-center ">
            <h1 class="text-danger" style="font-size: 6.5vw "><?php echo $exception->statusCode; ?></h1>
            <small style="font-size: 1.5vw"><?php echo nl2br($message) ?></small>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
