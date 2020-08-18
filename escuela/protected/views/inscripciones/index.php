<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use base\widgets\faicons\Fa;
/* @var $this yii\web\View */
/* @var $searchModel app\models\InscripcionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inscripcion Onlines');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-online-index">   
    <div class="row">
        
        <div class="col-lg-12 col-md-12 col-sm-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo Fa::icon($this->iconClass); ?>
                        <?php echo Yii::t('app', 'Pre-inscripciones'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php Pjax::begin([
                    'enablePushState'=>false,
                    ]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'label'=>'Localidad',
                                'attribute'=>'id_localidad',
                                'value' => 'localidad.nombre',
                            ],
                            [
                                'label' => 'Cursos',
                                'attribute'=> 'id_curso',
                                'value' =>'curso.nombre',
                                'filter'=>\kartik\select2\Select2::widget([
                                    'model'=>$searchModel,
                                    'attribute'=>'id_curso',
                                    'data'=>ArrayHelper::map(\app\models\Curso::find()->select(['id','nombre'])->orderBy('nombre ASC')->asArray()->all(),'id','nombre'),
                                    'language'=>'es',
                                    'options'=>[
                                    'placeholder'=>'Curso'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],
                            [   'label' => 'Sucursal',
                                'attribute' => 'id_sucursal',
                                'value' =>'sucursal.nombre',
                                'filter'=>\kartik\select2\Select2::widget([
                                    'model'=>$searchModel,
                                    'attribute'=>'id_sucursal',
                                    'data'=>ArrayHelper::map(\app\models\Sucursal::find()->select(['id','nombre'])->orderBy('nombre ASC')->asArray()->all(),'id','nombre'),
                                    'language'=>'es',
                                    'options'=>[
                                    'placeholder'=>'Sucursal'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],
                            'nombres',
                            'apellidos',
                            'dni',
                            'email',
                            'direccion',
                            'telefono',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template'=>'{aceptar} {delete}',
                                'buttons'=>
                                [
                                    'aceptar'=>function($url,$model)
                                    {
                                        return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,['class'=>'text-center text-success','title'=>'Ver']);
                                    },
                                ],
                                'urlCreator'=>function($action, $model, $key, $index)
                                {
                                    if($action == 'aceptar')
                                    {
                                    return Url::to(['/inscripciones/registrar','id'=>$model->id]);
                                    }
                                    if($action == 'delete' )
                                    {
                                        return Url::to(['/inscripciones/delete','id'=>$model->id]);
                                    }
                                }              
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
