<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;
    use base\widgets\faicons\Fa;
    use yii\widgets\Pjax;
?>

<div class="padding-top-5">
    <div class="table-responsive">
        <?php
            echo GridView::widget([
                'dataProvider'  => $dataProvider,
                'layout'        => '{items}',
                'tableOptions'  => ['class' => 'table' ],
                'columns' => [
                    [
                        'header'    => Yii::t('app', 'Inhabilitar'),
                        'class'     => 'yii\grid\ActionColumn',
                        'visible'   => Yii::$app->user->identity->isAdmin(),
                        'template'  => '{btn}',
                        'contentOptions' => ['style' => 'width: 50px', 'class' => 'text-center'],
                        'buttons' => [
                            'btn' => function ($url, $model, $key){

                                $link = Url::toRoute([$this->context->currentController .'/toggle-status' , 'id' => $key ]);
                                $text = Fa::icon('times')->fw();

                                return Html::a($text, $link, [
                                    'title'                 => Yii::t('app', 'Inhabilitar registro') ,
                                    'class'                 => 'text-danger',
                                    'data-pjax'             => false,
                                    'data-title-confirm'    => Yii::t('app', 'Inhabilitar {nombre}', ['nombre' => $model->nombre ]),
                                    'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea inhabilitar este registro?'),
                                    'data-runtime'          => 'ajax-confirm',
                                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                    'data-pjax-target'      => '#' . $this->context->pjaxId,
                                ]);
                            }
                        ],
                    ],
                    [
                        'attribute' => 'nombre',
                    ],
                    [
                        'attribute' => 'direccion',
                        'enableSorting' => false,
                        'format'    => 'raw',
                        'visible'   => Yii::$app->user->identity->isAdmin(),
                        'value'     => function($model){
                            return $model->direccion . ', ' . $model->getLocalidad()->one()->keyword;
                        }
                    ],
                    [
                        'attribute'     => 'email',
                        'visible'   => Yii::$app->user->identity->isAdmin(),
                        'contentOptions' => ['style' => 'width: 180px'],
                        'enableSorting' => false,
                    ],
                    [
                        'attribute' => 'telefonos',
                        'visible'   => Yii::$app->user->identity->isAdmin(),
                        'contentOptions' => ['style' => 'width: 250px'],
                        'format'    => 'raw',
                        'value'     => function($model){
                            $html = null;

                            if(!empty($model->numero1))
                            {
                                $html    .= '<div style="margin-bottom:10px">';
                                $html    .= '<div>' . $model->numero1 . '</div>';
                                if($model->extension1 != null)
                                $html    .= '<div> <small>Ext. '. $model->extension1 .'</small></div>';
                                $html    .= '</div>';
                            }

                            if(!empty($model->numero2))
                            {
                                $html    .= '<div style="margin-bottom:10px">';
                                $html    .= '<div>' . $model->numero2 . '</div>';
                                if($model->extension2 != null)
                                $html    .= '<div> <small>Ext. '. $model->extension2 .'</small></div>';
                                $html    .= '</div>';
                            }

                            return $html;
                        }
                    ],
                    [
                        'class'             => 'yii\grid\ActionColumn',
                        'header'            => Yii::t('app', 'Acciones'),
                        'contentOptions'    => ['style' => 'width: 100px', 'class' => 'text-center'],
                        'template'          => Yii::$app->user->identity->isAdmin() ? '{view} {update} {delete}' : '{view}',
                        'buttons'   => [

                            'view' => function ($url, $model, $key){
                                $link    = Url::toRoute([ $this->context->currentController . '/view' , 'id' => $key ]);
                                $text    = Fa::icon('institution')->fw();

                                return Html::a($text, $link, [
                                    'title'         =>  Yii::t('yii', 'Administrar sucursal') ,
                                    'class'         => 'text-info',
                                    'data-pjax'     => 0,
                                ]);
                            },

                            'update' => function ($url, $model, $key){
                                $link    = Url::toRoute([$this->context->currentController . '/update' , 'id' => $key ]);
                                $text    = Fa::icon('edit')->fw();

                                return Html::a($text, $link, [
                                    'title'         =>  Yii::t('app', 'Actualizar registro') ,
                                    'class'         => 'text-info',
                                    'data-pjax'     => 0,
                                ]);
                            },

                            'delete' => function ($url, $model, $key){
                                $link = Url::toRoute([$this->context->currentController .'/delete' , 'id' => $key , 'redirect' => $this->context->currentUrl ]);
                                $text = Fa::icon('trash')->fw();

                                return Html::a($text, $link, [
                                    'title'                 => Yii::t('app', 'Eliminar registro') ,
                                    'class'                 => 'text-danger',
                                    'data-pjax'             => 0,
                                    'data-title-confirm'    => Yii::t('app', 'Eliminar {nombre}', ['nombre' => $model->nombre ]),
                                    'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea eliminar este registro?'),
                                    'data-runtime'          => 'ajax-confirm',
                                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                    'data-icon-class'       => 'fa fa-trash',
                                    //'data-pjax-target'      => '#' . $this->context->pjaxId,
                                ]);
                            },
                        ]
                    ],
                ],
            ]);
        ?>
    </div>
</div>
