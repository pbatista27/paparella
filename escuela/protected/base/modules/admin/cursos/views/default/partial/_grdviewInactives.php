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
                        'header'    => Yii::t('app', 'Activar'),
                        'class'     => 'yii\grid\ActionColumn',
                        'visible'   => Yii::$app->user->identity->isAdmin(),
                        'template'  => '{btn}',
                        'contentOptions' => ['style' => 'width: 50px', 'class' => 'text-center'],
                        'buttons' => [
                            'btn' => function ($url, $model, $key){

                                $link    = Url::toRoute([$this->context->currentController .'/toggle-status' , 'id' => $key ]);
                                $text    = Fa::icon('check')->fw();

                                return Html::a($text, $link, [
                                    'title'                 => Yii::t('app', 'Habilitar registro') ,
                                    'class'                 => 'text-success',
                                    'data-pjax'             => 0,
                                    'data-title-confirm'    => Yii::t('app', 'Habilitar {nombre}', ['nombre' => $model->nombre ]),
                                    'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea habilitar este registro?'),
                                    'data-runtime'          => 'ajax-confirm',
                                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                    'data-icon-class'       => 'fa fa-check',
                                    'data-pjax-target'      => '#' . $this->context->pjaxId,
                                ]);
                            }
                        ],
                    ],
                    [
                        'attribute' => 'nombre',
                    ],
                    [
                        'attribute' => 'cantidad_meses',
                        'headerOptions' => [
                             'style' => 'width:170px;'
                        ],
                        'contentOptions'   => [
                             'class' => 'text-right',
                        ],
                    ],
                    [
                        'attribute' => 'cantidad_clases',
                        'headerOptions' => [
                             'style' => 'width:170px;'
                        ],
                        'contentOptions'   => [
                             'class' => 'text-right',
                        ],
                    ],
                    [
                        'attribute' => 'precio_cuota',
                        'headerOptions' => [
                             'style' => 'width:170px;'
                        ],
                        'contentOptions'   => [
                            'class' => 'text-right',

                        ],
                        'value'     => function($model){
                            return Yii::$app->formatter->asCurrency($model->precio_cuota);
                        }
                    ],
                    [
                        'attribute' => 'precio_matricula',
                        'headerOptions' => [
                             'style' => 'width:170px;'
                        ],
                        'contentOptions'   => [
                            'class' => 'text-right',
                        ],
                        'value'     => function($model){
                            if( empty($model->precio_matricula) )
                                return 'N/A';
                            else
                                return Yii::$app->formatter->asCurrency($model->precio_matricula);
                        }
                    ],
                    [
                        'class'             => 'yii\grid\ActionColumn',
                        'header'            => Yii::t('app', 'Acciones'),
                        'contentOptions'    => ['style' => 'width: 100px', 'class' => 'text-center'],
                        'template'          => Yii::$app->user->identity->isAdmin() ? '{update} {delete}' : '{view}',
                        'buttons'   => [
                            'update' => function ($url, $model, $key){
                                $link   = Url::toRoute([$this->context->currentController . '/update' , 'id' => $key ]);
                                $text   = Fa::icon('edit')->fw();

                                return Html::a($text, $link, [
                                    'title' =>  Yii::t('yii', 'Update') ,
                                    'class' => 'text-info',
                                     'data-pjax'     => 0,
                                ]);
                            },

                            'delete' => function ($url, $model, $key){

                                $link = Url::toRoute([$this->context->currentController .'/delete' , 'id' => $key , 'redirect' => $this->context->currentUrl ]);
                                $text    = Fa::icon('trash')->fw();

                                return Html::a($text, $link, [
                                    'title'                 => Yii::t('app', 'Eliminar') ,
                                    'class'                 => 'text-danger',
                                    'data-pjax'             => 0,
                                    'data-title-confirm'    => Yii::t('app', 'Eliminar {nombre}', ['nombre' => $model->nombre ]),
                                    'data-text-confirm'     => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-runtime'          => 'ajax-confirm',
                                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                    'data-icon-class'       => 'fa fa-trash',
                                ]);
                            },
                        ]
                    ],
                ],
            ]);
        ?>
    </div>
</div>
