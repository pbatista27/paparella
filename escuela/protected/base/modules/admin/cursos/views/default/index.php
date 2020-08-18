<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;
    use base\widgets\faicons\Fa;
    use yii\widgets\Pjax;
    Pjax::begin([
        'id'                => $this->context->pjaxId,
        'enablePushState'   => false,
    ]);
?>
<div class="row" id="<?= $this->context->pjaxId; ?>">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo Fa::icon($this->iconClass)->fw(); ?>
                    <?php echo $this->H1 ?>
                </h3>
            </div>
            <div class="panel-body" >
                <!--tob button add / delete-->
                <div class="padding-v-15" >
                    <div class="clearfix">
                        <div class="text-right">
                            <?php
                                echo Html::a(Yii::t('app', 'Nuevo registro'), Url::toRoute(['/'. $this->context->module->id.'/create/index' ]), [
                                    'class'     => 'btn btn-primary',
                                    'data-pjax' => 0
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
                <!--navs-->
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#activos">
                            <?php echo Fa::icon('check')->fw() .  Yii::t('app', 'Activos') . ' ('. $activos->getTotalCount() .')' ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#inactivas">
                            <?php echo Fa::icon('times')->fw() .  Yii::t('app', 'Inactivos') . ' ('. $inactivos->getTotalCount() .')' ?>
                        </a>
                    </li>
                </ul>


                <!--gridviews-->
                <div class="tab-content">
                    <!--actives-->
                    <div id="activos" class="tab-pane fade in active">
                        <div id="grid-actives" class="container-fluid">
                            <div class="row" >
                                <div class="col-sx-12">
                                    <div class="padding-h-15">
                                        <div class="padding-top-5">
                                            <div class="table-responsive">
                                                <?php
                                                    echo $this->render('partial/_grdviewActives', [
                                                        'dataProvider' => $activos,
                                                    ]);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="inactivas" class="tab-pane fade">
                        <div id="grid-inactives" class="container-fluid">
                            <div class="row" >
                                <div class="col-sx-12">
                                    <div class="padding-h-15">
                                        <div class="padding-top-5">
                                            <div class="table-responsive">
                                                <?php
                                                    echo $this->render('partial/_grdviewInactives', [
                                                        'dataProvider' => $inactivos,
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
    </div>
</div>
<?php Pjax::end(); ?>
