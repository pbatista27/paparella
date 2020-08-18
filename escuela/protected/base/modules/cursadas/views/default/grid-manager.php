<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;
    use base\widgets\faicons\Fa;
    use yii\widgets\Pjax;

    Pjax::begin([
        'id'                => 'cursadas',
        'enablePushState'   => false,
    ]);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo Fa::icon($this->iconClass)->fw(); ?>
                    <?php echo $this->H1;?>
                </h3>
            </div>
            <div class="panel-body" >
                <div class="padding-v-15" >
                    <div class="container-fluid">
                        <div class="row">
                            <div style="margin:0 15px">
                                <div class="col-sx-12 text-right">
                                    <?php
                                        $route = Url::toRoute([ $this->context->currentModule .'/create/index' , 'step'=> 1 , 'idSucursal' => $this->context->modelSucursal->id ]);
                                        echo Html::a(Yii::t('app', 'Nuevo registro'), $route, [
                                            'class'     => 'btn btn-primary',
                                            'data-pjax' => 0
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="padding-v-15" >
                    <div class="container-fluid">
                        <div class="row" >
                        <div class="col-sx-12">
                            <div class="padding-h-15">
                                <div class="padding-top-5">
                                    <div class="table-responsive">
                                        <?php
                                            echo GridView::widget([
                                                'id'            => 'grid',
                                                'filterModel'   => $this->context->model,
                                                'dataProvider'  => $this->context->dataProvider,
                                                'tableOptions'  => ['class' => 'table' ],
                                                'layout'        => '<div>{items}</div><div class="text-center">{pager}</div>',
                                                'columns' => [
                                                   'id_curso_sucursal' => [
                                                        'header'    => Yii::t('app', 'Curso'),
                                                        'attribute' => 'id_curso_sucursal',
                                                        'enableSorting' => false,
                                                        'contentOptions' => ['style' => 'vertical-align:baseline; padding:20px 0'],
                                                        'filter' => Html::activeDropDownList($this->context->model, 'id_curso_sucursal', $this->context->model->getMapCursoSucursal($this->context->modelSucursal->id, $this->context->model->status) ,['class'=>'form-control','prompt' => '--']),
                                                        'value' => function($model){
                                                            return $model->getNombreCurso();
                                                        },
                                                    ],

                                                   'id' => [
                                                        'header'    => 'Periodo / sec.',
                                                        'attribute' => 'id_curso_sucursal',
                                                        'enableSorting' => false,
                                                        'contentOptions' => ['style' => 'vertical-align:baseline; padding:20px 0', 'class'=>'text-center'],
                                                        'filter' => Html::activeDropDownList($this->context->model, 'id', $this->context->model->getMapNombreCursada($this->context->modelSucursal->id, $this->context->model->status) ,['class'=>'form-control','prompt' => '--']),
                                                        'value' => function($model){
                                                            return $model->getPeriodoSec();
                                                        },
                                                    ],

                                                    [
                                                        'attribute' => 'nro_cupos',
                                                        'enableSorting'  => false,
                                                        'contentOptions' => ['style' => 'width: 150px; vertical-align:baseline;  padding:20px 0', 'class' => 'text-center'],
                                                        'filter'         => '<div class="clearfix" style="width: 150px;">
                                                                                <div style="width:50%;  padding-right:5px" class="pull-left">'
                                                                                    . Html::activeInput('text', $this->context->model, 'nro_disponibles',['class'=>'form-control' , 'placeholder'=>"disp."]) .
                                                                                '</div>
                                                                                <div style="width:50%;  padding-left:5px" class="pull-right">'
                                                                                    . Html::activeInput('text', $this->context->model, 'nro_cupos',['class'=>'form-control', 'placeholder'=>"total"]) .
                                                                                '</div>
                                                                            </div>',

                                                        'value'          => function($model){
                                                            return $model->nro_disponibles . ' / ' . $model->nro_cupos ;
                                                        },
                                                    ],
                                                    [
                                                        'header' => '<div class="text-center">' . Yii::t('app','Cronograma') . '</div>',
                                                        'format' => 'raw',
                                                        'contentOptions' => ['style' => 'width: 400px'],
                                                        'value'     => function($model){
                                                            $idContent = uniqid('horario-');

                                                            $this->registerJs('
                                                                $("[data-runtime=horario]").off();
                                                                $("[data-runtime=horario]").on("click", function(e){
                                                                    e.preventDefault();
                                                                    e.stopPropagation();
                                                                    $($(this).data("target")).toggle(350);
                                                                });
                                                            ', $this::POS_END);


                                                            $html = '<table style="margin:0px 0" class="table table-bordered">';
                                                            $html.= '<tr>';
                                                            $html.= '<td colspan="2" class="text-center">';
                                                            $html.= '<div class="pull-left"><b>'. $model->getAttributeLabel('horario') .'</b></div>';
                                                            $html.= '<div class="pull-right"><a href="javascript:void(0)" data-target="#'.$idContent.'"  data-runtime="horario" >'.Fa::icon('angle-down')->fw().'</a></div></td>';
                                                            $html.= '</tr>';
                                                            $html.= '<tbody style="display:none" id="'.$idContent.'">';
                                                            $html.= '<tr>';
                                                            $html.= '<td colspan="2" class="text-center">'. $model->horario .'</td>';
                                                            $html.= '</tr>';

                                                            $html.= '<tr>';
                                                            $html.= '<td><b>'. $model->getAttributeLabel('fecha_inicio') .'</b></td>';
                                                            $html.= '<td>'. $model->fecha_inicio .'</td>';
                                                            $html.= '</tr>';

                                                            $html.= '<tr>';
                                                            $html.= '<td><b>'.$model->getAttributeLabel('fecha_inicio_evaluacion').'</b></td>';
                                                            $html.= '<td>'. $model->fecha_inicio_evaluacion .'</td>';
                                                            $html.= '</tr>';

                                                            $html.= '<tr>';
                                                            $html.= '<td><b>'.$model->getAttributeLabel('fecha_fin_evaluacion') .'</b></td>';
                                                            $html.= '<td>'. $model->fecha_fin_evaluacion .'</td>';
                                                            $html.= '</tr>';

                                                            $html.= '<tr>';
                                                            $html.= '<td><b>'.$model->getAttributeLabel('fecha_fin') .'</b></td>';
                                                            $html.= '<td>'. $model->fecha_fin .'</td>';
                                                            $html.= '</tr>';
                                                            $html.= '</tbody>';

                                                            $html.= '</table>';

                                                            return $html;

                                                        },
                                                    ],


                                                    [
                                                        'class'          => 'yii\grid\ActionColumn',
                                                        'header'         => Yii::t('app', 'Acciones'),
                                                        'contentOptions' => ['style' => 'width: 150px; vertical-align:baseline', 'class' => 'text-center'],
                                                        'template'       => '{docentes} {estudiantes} {cronograma} {pagos} {update} {delete}',
                                                        'buttons' => [
                                                            'docentes' => function($url, $model, $key){
                                                                $link    = Url::toRoute([ $this->context->currentModule. '/docentes/index' , 'idCursada' => $key ]);
                                                                $text    = Fa::icon('users')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'     =>  Yii::t('app', 'Administrar Docentes') ,
                                                                    'class'     => 'text-info',
                                                                    'data-pjax' => 0,
                                                                    'data-role' => 'open-modal',
                                                                ]);
                                                            },
                                                            'estudiantes' => function($url, $model, $key){
                                                                $link    = Url::toRoute([ $this->context->currentModule. '/estudiantes/index' , 'idCursada' => $key ]);
                                                                $text    = Fa::icon('graduation-cap')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'     =>  Yii::t('app', 'Administrar Estudiantes') ,
                                                                    'class'     => 'text-info',
                                                                    'data-pjax' => 0,
                                                                    'data-role' => 'open-modal',
                                                                ]);
                                                            },
                                                            'cronograma' => function($url, $model, $key){
                                                                $link    = Url::toRoute([ $this->context->currentModule. '/cronograma/index' , 'idCursada' => $key ]);
                                                                $text    = Fa::icon('history')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'     =>  Yii::t('app', 'Administrar cronograma') ,
                                                                    'class'     => 'text-info',
                                                                    'data-pjax' => 0,
                                                                    'data-role' => 'open-modal',
                                                                ]);
                                                            },
                                                            'pagos' => function($url, $model, $key){
                                                                $link    = Url::toRoute([ $this->context->currentModule. '/pagos/index' , 'idCursada' => $key ]);
                                                                $text    = Fa::icon('credit-card-alt')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'     =>  Yii::t('app', 'Administrar Pagos') ,
                                                                    'class'     => 'text-info',
                                                                    'data-pjax' => 0,
                                                                    'data-role' => 'open-modal',
                                                                ]);
                                                            },
                                                            'update' => function($url, $model, $key){
                                                                $link    = Url::toRoute([ $this->context->currentController . '/update/index' , 'id' => $key ]);
                                                                $text    = Fa::icon('edit')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'     =>  Yii::t('yii', 'Update') ,
                                                                    'class'     => 'text-info',
                                                                    'data-pjax' => 0,
                                                                    'data-role' => 'open-modal',
                                                                ]);
                                                            },
                                                            'delete' => function($url, $model, $key){
                                                                $link    = Url::toRoute([ $this->context->currentController. '/delete' , 'id' => $key ]);
                                                                $text    = Fa::icon('trash')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'         =>  Yii::t('yii', 'Delete') ,
                                                                    'class'         => 'text-danger',
                                                                    'data-pjax'     => 0,
                                                                ]);
                                                            }
                                                        ],

                                                        /*
                                                        'buttons'   => [
                                                            'delete' => function ($url, $model, $key){
                                                                $link = Url::toRoute([$this->context->currentController .'/delete' , 'id' => $key , 'redirect' => $this->context->currentUrl ]);
                                                                $text = Fa::icon('trash')->fw();

                                                                return Html::a($text, $link, [
                                                                    'title'                 => Yii::t('app', 'Eliminar registro') ,
                                                                    'class'                 => 'text-danger',
                                                                    'data-pjax'             => 0,
                                                                    //'data-title-confirm'  => Yii::t('app', 'Eliminar {nombre}', ['nombre' => $model->nombre ]),
                                                                    'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea eliminar este registro?'),
                                                                    'data-runtime'          => 'ajax-confirm',
                                                                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                                                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                                                    'data-icon-class'       => 'fa fa-trash',
                                                                    //'data-pjax-target'    => '#' . $this->context->pjaxId,
                                                                ]);
                                                            },
                                                        ]
                                                        */
                                                    ],
                                                ],
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>
